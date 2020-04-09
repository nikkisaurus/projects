
$(document).ready(function () {

    function LoadContents(slug) {
        let path = document.location.pathname.replace(/[^\\\/]*$/, '') + slug

        // $("main").html("Fuck" + path)
        $("main").load(path)
        // alert(path)
        // $(location).attr('href', path)
    }

    // $("header a").on("click", function (e) {
    //     LoadContents("index.html")
    // })

    $("a").on("click", function (e) {
        LoadContents(e.target.id)
    })
});