$(function () {
    const currentPath = window.location.pathname.toLowerCase();

    switch (currentPath) {
        default:
            break;

        case "/":
        case "/index":
        case "/index.html":
            $('#home_nav_button').addClass('active');
            break;
    }

    $('.logo').click(() => {
        $(location).attr('pathname', '/');
    });
});