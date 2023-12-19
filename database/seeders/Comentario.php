<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class comentario extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comments')->insert([

            'from_id' => 2,
            'to_id' => 3,
            'msg' => 'HOLAAAAAAAAAAAAAAAAAAAAAAA'
        ]);
    }
}
