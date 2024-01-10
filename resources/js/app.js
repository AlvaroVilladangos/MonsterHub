import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

let banner = document.createElement("div");
let texto = document.createElement("p");
let enlace = document.createElement("a");
let boton = document.createElement("button");

banner.id = "cb-cookie-banner";
banner.className = "alert alert-dark text-center bg-dark mb-0";
banner.role = "alert";

texto.className = "text-light";
texto.textContent =
  "🍪 Esta pagina utiliza cookies para un mejor uso de la página.";

enlace.className = "text-light";
enlace.href = "https://www.cookiesandyou.com/";
enlace.target = "blank";
enlace.textContent = "Aprender más";

boton.type = "button";
boton.className = "btn btn-primary btn-sm ms-3";
boton.textContent = "Entendido";
boton.onclick = esconderCookieBanner;

banner.appendChild(texto);
banner.appendChild(enlace);
banner.appendChild(boton);

document.body.appendChild(banner);

function esconderCookieBanner() {
  let fecha = new Date();
  fecha.setFullYear(fecha.getFullYear() + 1);
  document.cookie = `MonsterHub_Cookie=yes; expires=${fecha.toUTCString()}; path=/`;
  banner.style.display = "none";
}

function comprobarCookie() {
  let cookieFila = document.cookie
    .split("; ")
    .find((fila) => fila.startsWith("MonsterHub_Cookie"));
  let cookieAceptada = cookieFila ? cookieFila.split("=")[1] : undefined;
  if (cookieAceptada === undefined || cookieAceptada === "no") {
    banner.style.display = "block";
  }
}

window.onload = comprobarCookie;
