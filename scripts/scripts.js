$(document).ready(function () {
    if ((/#projects$/).test(document.location) === true) {
        $("main").load("projects/index.html")
    } else {
        $("main").load("main.html")
    }

    $("header a").on("click", function () {
        $("main").load("main.html")
    })

    $("nav a").on("click", function (slug) {
        $('main').load(slug.target.id)
    })
});