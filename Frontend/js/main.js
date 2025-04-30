$(document).ready(function() {
    // Navegación entre páginas
    $('.nav-link').click(function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        window.location.href = `${page}.html`;
    });
});