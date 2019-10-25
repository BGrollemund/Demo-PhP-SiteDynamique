document.addEventListener( 'DOMContentLoaded', function() {

    const
        $hiddenMenu = document.getElementById( 'hidden-menu' ),
        $openMenu = document.getElementById( 'open-menu' );

    $openMenu.addEventListener( 'click', function() {

        $hiddenMenu.classList.toggle( 'hidden' );
    });
});