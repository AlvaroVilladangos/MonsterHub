<?php

namespace App\Http\Controllers;

use App\Models\Armor;
use App\Models\Weapon;
use App\Models\Comment;
use App\Models\Hunter;
use App\Models\Guild;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class hunterController extends Controller
{

    public function dashboard()
    {
        $hunter = auth()->user()->hunter;
        $weapon = Weapon::find($hunter->weapon_id);
        $armor = Armor::find($hunter->armor_id);
        $comments = $hunter->comments()->with('hunter')->get();
        return view('auth.hunterDashboard', compact('hunter', 'weapon', 'armor', 'comments'));
    }
    
    public function show(Hunter $hunter)
    {
        $weapon = Weapon::find($hunter->weapon_id);
        $armor = Armor::find($hunter->armor_id);
        $comments = $hunter->comments()->with('hunter')->paginate(5);
        return view('auth.hunter', compact('hunter', 'comments', 'weapon', 'armor'));
    }
    


    public function index()
    {

        $hunters = hunter::query();

        if (request()->has('search')) {
            $search = strtolower(request()->get('search', ''));
            $hunters = $hunters->whereRaw('lower(name) like (?)', ["%{$search}%"]);
        }

        $hunters = $hunters->paginate(5);

        return view('auth.hunters', compact('hunters'));
    }

    public function edit()
    {
        $hunter = auth()->user()->hunter;
        $weapon = Weapon::find($hunter->weapon_id);
        $armor = Armor::find($hunter->armor_id);
        $comments = $hunter->comments()->with('hunter')->paginate(5);
        $weapons = Weapon::all();
        $armors = Armor::all();
        return view('auth.hunterEdit', compact('weapon', 'armor', 'weapons', 'armors', 'comments'));
    }

    public function update(Request $request)
    {
        $hunter = auth()->user()->hunter;
    
        $request->validate([
            'hunterName' => 'required|min:2|unique:hunters,name,' . $hunter->id,
            'img' => 'nullable|image',
            'weapon' => 'required',
            'armor' => 'required',
            'bio' => 'required|min:10',
        ]);
    
        if ($request->has('img')) {
            $imgPath = $request->file('img')->store('imgProfile', 'public');
    
            if ($hunter->img != 'imgProfile/defaultProfile.webp') {
                Storage::disk('public')->delete($hunter->img);
            }
    
            $hunter->img = $imgPath;
        }
    
        $hunter->name = $request->get('hunterName');
        $hunter->bio = $request->get('bio');
        $hunter->weapon_id = $request->get('weapon');
        $hunter->armor_id = $request->get('armor');
    
        if ($hunter->isDirty('name')) {
            $duplicate = Hunter::where('name', $request->get('hunterName'))->first();
            if ($duplicate) {
                return redirect()->back()->withErrors(['hunterName' => 'El nombre ya existe.'])->withInput();
            }

        }
    
        $hunter->save();
    
        return redirect()->route('dashboard');
    }
    
    public function destroyUser(Request $request, $id){

        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->withErrors(['hunterName' => 'El usuario no existe'])->withInput();
        }
        
        $user->delete();
        if ( Auth::user()->admin){
            return redirect()->route('usersAdmin')->with('success', 'El usuario ha sido eliminado con éxito');
        }

        Auth::guard('web')->logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();

    
        return redirect('login')->with('success', 'El usuario ha sido eliminado con éxito');
    }
    


    public function destroyComment($id)
    {
        $comment = Comment::where('id', $id)->firstOrFail()->delete();
        return redirect()->back()->with('success', 'Comentario borrado con éxito');
    }


    public function leaveGuild()
    {

        $hunter = Auth::user()->hunter;

        $hunter->guild_id = null;

        $hunter->save();

        return redirect()->route('dashboard');
    }

    public function leaveRoom()
    {

        $hunter = Auth::user()->hunter;
        $room = $hunter->room;

        $hunter->room_id = null;

        $hunter->save();

        if ($room->hunters()->count() == 0) {
            $room->delete();
        }

        return redirect()->route('rooms');
    }

    public function joinRoom()
    {
        $room_id = request()->get('room_id');
        $room = Room::find($room_id);

        if ($room && $room->roomCount() < 4) {
            $hunter = Auth::user()->hunter;
            $hunter->room_id = $room_id;
            $hunter->save();
            return redirect()->route('rooms');
        } else {
            session()->flash('error', 'No se ha podido unir a la sala');
            return redirect()->route('rooms');
        }
    }


    public function comment()
    {

        $msg = request()->get('commentMsg');

        $from = Auth::user()->hunter->id;

        $to = request()->get('hunter_id');

        $comment = new Comment;

        $comment->from_id = $from;

        $comment->to_id = $to;

        $comment->msg = $msg;

        $comment->save();

        return redirect()->route('hunter.show', ['hunter' => $to]);
    }

    public function joinGuild(Guild $guild)
    {

        $hunter = Auth::user()->hunter;
        $hunter->guild_id = $guild->id;
        $hunter->save();

        return redirect()->route('guild.show', $guild);
    }

    public function friendsList()
    {
        $user = Auth::user()->hunter;

        $friendsOfThisUser = $user->friendsOfThisUser()->get();
        $thisUserIsFriendOf = $user->thisUserIsFriendOf()->get();

        $acceptedFriends = $friendsOfThisUser->concat($thisUserIsFriendOf);

        $id = $user->id;


        $receivedRequests = DB::table('friends')
            ->where('status', 'pending')
            ->where('requester_id', '!=', $id)
            ->where(function ($query) use ($id) {
                $query->where('hunter_1', $id)
                    ->orWhere('hunter_2', $id);
            })
            ->get();

        $receivedRequestsData = $receivedRequests->map(function ($request) {
            $requesterId = $request->requester_id;
            $requesterData = Hunter::find($requesterId);
            return $requesterData;
        });

        return view('auth.friends', compact('acceptedFriends', 'receivedRequestsData'));
    }


    public function addFriend($requesterId, $receiverId)
    {
        $existingFriendship = DB::table('friends')
            ->where(function ($query) use ($requesterId, $receiverId) {
                $query->where('hunter_1', min($requesterId, $receiverId))
                    ->where('hunter_2', max($requesterId, $receiverId));
            })
            ->first();

        if (!$existingFriendship) {
            DB::table('friends')->insert(
                ['hunter_1' => min($requesterId, $receiverId), 'hunter_2' => max($requesterId, $receiverId), 'requester_id' => $requesterId, 'status' => 'pending']
            );
        }

        return redirect()->route('dashboard');
    }


    public function acceptFriend()
    {
        $requesterId = request('requestId');

        $currentUserId = auth()->user()->hunter->id;

        $friendRequest = DB::table('friends')
            ->where(function ($query) use ($requesterId, $currentUserId) {
                $query->where('hunter_1', min($requesterId, $currentUserId))
                    ->where('hunter_2', max($requesterId, $currentUserId))
                    ->where('requester_id', $requesterId);
            })
            ->where('status', 'pending')
            ->first();

        if ($friendRequest) {
            DB::table('friends')
                ->where('id', $friendRequest->id)
                ->update(['status' => 'accepted']);
        }

        return redirect()->route('friends');
    }

    public function deleteFriend()
    {
        $requesterId = request('requestId');
        $currentUserId = auth()->user()->hunter->id;

        $friendRelation = DB::table('friends')
            ->where(function ($query) use ($requesterId, $currentUserId) {
                $query->where('hunter_1', $requesterId)
                    ->where('hunter_2', $currentUserId);
            })
            ->orWhere(function ($query) use ($requesterId, $currentUserId) {
                $query->where('hunter_1', $currentUserId)
                    ->where('hunter_2', $requesterId);
            })
            ->first();

        if ($friendRelation) {
            DB::table('friends')
                ->where('id', $friendRelation->id)
                ->delete();
        }

        return redirect()->route('friends');
    }
}
