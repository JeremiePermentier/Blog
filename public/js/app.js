// VARIABLES
let navBtn = document.getElementById('nav__button');
let ctrl =  document.getElementsByClassName('nav__subMenu');
let form = document.getElementById('form');
let submit = document.getElementById("submit");
let btn_load = document.querySelector(".btn--load");
let btn_text = document.querySelector(".btn__text");
let inputs = document.querySelectorAll('input, textarea');
let formValid = null;

// NAV
navBtn.addEventListener('click', () => {
    ctrl[0].classList.toggle('nav__subMenu--open');
})

// LOADER
let loader = document.getElementById("loader");

window.addEventListener('load', () => {
    loader.remove()
})


// LOADER BTN
form.addEventListener("submit", () => {
    btn_load.classList.toggle('hidden');
    btn_text.classList.toggle('hidden');
})