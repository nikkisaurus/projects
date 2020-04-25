/* Variables */

const hamburger = document.getElementById("hamburger-menu");
const main = document.getElementById("main");
const menu = document.getElementById("menu");

/* Window Resize */

function SetMenuClass() {
    if (window.screen.width >= 530) {
        // Changes #menu's class to .largeMenu
        menu.classList.remove("smallMenu");
        menu.classList.add("largeMenu");

        // Hides #hamburger-menu and displays #main and #menu
        hamburger.style.display = "none";
        main.style.display = "block";
        menu.style.display = "block";
    } else {
        // Changes #menus class to .smallMenu
        menu.classList.remove("largeMenu");
        menu.classList.add("smallMenu");

        // Shows #hamburger-menu and #main and hides #menu
        hamburger.style.display = "block";
        main.style.display = "block";
        menu.style.display = "none";
    }
}

// Sets the initial #menu class and window resize function
SetMenuClass();
window.onresize = () => SetMenuClass();

/* Hamburger */

document.getElementById("hamburger-menu").onclick = function (event) {
    if (window.getComputedStyle(menu).display === "none") {
        menu.style.display = "flex";
        main.style.display = "none";
    } else {
        menu.style.display = "none";
        main.style.display = "block";
    }
};
