document.addEventListener( 'DOMContentLoaded', function() {

    const
        hiddenMenu = document.getElementById( 'hidden-menu' ),
        openMenu = document.getElementById( 'open-menu' ),
        triangleDown = document.getElementById('triangle-down'),
        triangleLeft = document.getElementById('triangle-left');

    openMenu.addEventListener( 'click', function() {

        hiddenMenu.classList.toggle( 'hidden' );

        var Lscreen = window.innerWidth;

        if( Lscreen < 576 ) {
        triangleDown.classList.toggle( 'hidden' );
        triangleLeft.classList.toggle( 'hidden' );
        }
    });
});