<?php

define( 'CTRL_PATH', APP_PATH . 'controllers' . DS );

/**
 * Require le contrôleur recherché
 *
 * @param string $name
 */
function controllerLoad( string $name ): void
{
    $path = CTRL_PATH . $name . '-controller.php';

    if( ! is_readable( $path ) ) die404();

    require_once $path;
}