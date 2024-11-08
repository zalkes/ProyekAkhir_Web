let darkModeEnabled = false;

const darkModeButton = document.getElementById('dark-mode-button');
const navbar = document.getElementById('navbar');
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector(".nav-links");
const icons = document.querySelectorAll("i");
let subMenu = document.getElementById('subMenu');
let userpict = document.querySelector(".user-pic");

hamburger.addEventListener("click", function () {
    const isVisible = navLinks.getAttribute('data-visible');
    if (isVisible == "true") {
        navLinks.setAttribute('data-visible', "false");
        icons[0].setAttribute('data-visible', "true");
        icons[1].setAttribute('data-visible', "false");
    } else if (isVisible == "false") {
        navLinks.setAttribute('data-visible', "true");
        icons[0].setAttribute('data-visible', "false");
        icons[1].setAttribute('data-visible', "true");
    }
});

function pemberitahuan() {
    alert("Maaf, Fitur ini belum tersedia ;(");
}

function toggleMenu(){
    subMenu.classList.toggle('open-menu');
}

window.addEventListener("click", (event) => {
    if (!subMenu.contains(event.target) && !userpict.contains(event.target)) {
        subMenu.classList.remove("open-menu");
    }
});

function mode(){
    document.body.classList.toggle('dark-mode');
    const darkmode = document.body.classList.contains("dark-mode");

    if (darkmode){
        localStorage.setItem("dark-mode", "enabled");
        
    } else {
        localStorage.setItem("dark-mode", "disabled");
        
    }
}
window.onload = mode;

function checkMode(){
    const modesetting = localStorage.getItem("dark-mode");
    
    if (modesetting === "enabled"){
        document.body.classList.add('dark-mode');
        darkModeButton.checked = true;
    }
}

window.onload = checkMode;
