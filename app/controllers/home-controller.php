<?php

require_once APP_PATH . 'models/home-model.php';

function homeControllerIndex(): void
{

    $data = [
        'titre_h1' => 'Top 3 des Ventes',
        'html_title' => SITE_NAME,
        'toys' => homeModelGetTop3()
    ];

    viewRender( 'home', $data );
}