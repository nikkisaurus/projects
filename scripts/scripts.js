$(document).ready(function () {
    if ((/#portfolio$/).test(document.location) === true) {
        $("main").load("art/portfolio.html")
    } else if ((/#graphics$/).test(document.location) === true) {
        $("main").load("art/index.html")
    } else if ((/#projects$/).test(document.location) === true) {
        $("main").load("projects/index.html")
    } else if ((/#contact$/).test(document.location) === true) {
        $("main").load("contact.html")
    } else {
        $("main").load("main.html")
        // $("main").load("projects/index.html")
    }

    $("header a").on("click", function () {
        $("main").load("main.html")
        // $("main").load("projects/index.html")
    })

    $("nav a").on("click", function (slug) {
        $('main').load(slug.target.id)
    })
});