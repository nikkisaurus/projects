/* Menu */

const hamburger = document.getElementById("hamburger");
const menu = document.getElementById("menu");
const nav_links = document.getElementsByClassName("nav-link");

let isMenuSmall = false;

// Toggles the visibility of the menu on small screens
hamburger.onclick = function (event) {
    if (window.getComputedStyle(menu).display === "none") {
        menu.style.display = "flex";
    } else {
        menu.style.display = "none";
    }
};

// Hides the menu on small screens when a link is clicked
for (let i = 0; i < nav_links.length; i++) {
    let link = nav_links[i];

    link.onclick = (event) => {
        if (isMenuSmall) {
            menu.style.display = "none";
        }
    };
}

/* Window Resize */

function SetMenuClass() {
    if (window.screen.width >= 835) {
        // Removes the .menu-sm class to #menu
        menu.classList.remove("menu-sm");

        // Hides #hamburger-menu and displays #menu
        hamburger.style.display = "none";
        menu.style.display = "block";

        isMenuSmall = false;
    } else {
        // Adds .menu-sm class to #menu
        menu.classList.add("menu-sm");

        // Shows #hamburger-menu and hides #menu
        hamburger.style.display = "block";
        menu.style.display = "none";

        isMenuSmall = true;
    }
}

// Initializes menu
SetMenuClass();
window.onresize = () => SetMenuClass();

/* Project Cards */

const projects = [
    {
        id: "product-landing-page",
        title: "Supportix",
        desc: "A landing page for a fake company using HTML5, CSS, and JavaScript."
    },
    {
        id: "slackers",
        title: "Slackers",
        desc: "A website used to track video game bonus rolls written in HTML5, CSS, PHP and MySQL."
    },
    {
        id: "survey-form",
        title: "Born of Blood Guild Application",
        desc: "An HTML and CSS survey form for a video game guild application."
    },
    {
        id: "tribute-page",
        title: "A Tribute to Oreo",
        desc: "A tribute page to my cat created with HTML and CSS."
    }
]

// Load projects

function LoadCards() {
    const container = document.getElementById("project-container");

    projects.forEach((project) => {
        container.innerHTML += `
            <div class="card" id="${project.id}">
                <div class="card-image">
                    <img src="assets/images/project-screenshots/${project.id}.png" alt="" onclick="window.open('projects/${project.id}');" onmouseover="" style="cursor: pointer;">
                </div>
                <div class="card-title text-centered">
                    <p>${project.title}</p>
                </div>
                <div class="card-desc">
                    <p>${project.desc}</p>
                </div>
                <div class="card-links">
                    <button class="card-link card-link-primary" onclick="window.open('projects/${project.id}');">View</button>
                    <button class="card-link" onclick="window.open('https://github.com/jlvellocido/projects/tree/master/projects/${project.id}');">Source</button>
                </div>
            </div>
        `;
    })


}

LoadCards();