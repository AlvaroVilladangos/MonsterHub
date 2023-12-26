import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();


function popBannerCookie() {
  let cookieBanner = document.getElementById("cb-cookie-banner");
  cookieBanner.style.display = "block";
}


function esconderCookieBanner() {
  let fecha = new Date();
  fecha.setFullYear(fecha.getFullYear() + 1); // Establece la fecha para un año a partir de ahora
  document.cookie = `MonsterHub_Cookie=yes; expires=${fecha.toUTCString()}; path=/`;
  let cookieBanner = document.getElementById("cb-cookie-banner");
  cookieBanner.style.display = "none";
}


function comprobarCookie() {
  let cookieFila = document.cookie
    .split("; ")
    .find((fila) => fila.startsWith("MonsterHub_Cookie"));
  let cookieAceptada = cookieFila ? cookieFila.split("=")[1] : undefined;
  if (cookieAceptada === undefined || cookieAceptada === "no") {
    popBannerCookie();
  }
}

// Assigning values to window object
window.onload = comprobarCookie;
window.cb_esconderCookieBanner = esconderCookieBanner;
