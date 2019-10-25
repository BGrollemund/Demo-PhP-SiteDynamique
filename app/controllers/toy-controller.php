<?php

require_once APP_PATH . 'models/toy-model.php';

function toyControllerIndex(): void
{
    // --- Gestion des GET ---

    // Protection injection url

    if( isset( $_GET[ 'id' ] ) && ! is_numeric( $_GET[ 'id' ] ) ) die404();
    if( isset( $_GET[ 'brand_id' ] ) && ! is_numeric( $_GET[ 'brand_id' ] ) ) die404();
    if( isset( $_GET[ 'page' ] ) && ! is_numeric( $_GET[ 'page' ] ) ) die404();
    if( isset( $_GET[ 'order' ] ) && ! ( $_GET[ 'order' ] === '' || $_GET[ 'order' ] === 'ASC' || $_GET[ 'order' ] === 'DESC' ) ) die404();

    // Page détail du jouet
    if( isset( $_GET[ 'id' ] ) ) {
        toyControllerShow( (int) $_GET[ 'id' ] );
        return;
    }

    // Page jouets classé par marque
    if( isset( $_GET[ 'brand_id' ] ) && isset( $_GET[ 'page' ] )  && isset( $_GET[ 'order' ] ) ) {
        toyControllerShow_brand( (int) $_GET[ 'brand_id' ], $_GET[ 'order' ], (int) $_GET[ 'page' ] );
        return;
    }

    if( isset( $_GET[ 'brand_id' ] ) && isset( $_GET[ 'page' ] ) ) {
        toyControllerShow_brand( (int) $_GET[ 'brand_id' ], '', (int) $_GET[ 'page' ] );
        return;
    }

    if( isset( $_GET[ 'brand_id' ] ) && isset( $_GET[ 'order' ] ) ) {
        toyControllerShow_brand( (int) $_GET[ 'brand_id' ], $_GET[ 'order' ] );
        return;
    }

    if( isset( $_GET[ 'brand_id' ] ) ) {
        toyControllerShow_brand( (int) $_GET[ 'brand_id' ] );
        return;
    }

    // Page liste totale des jouets
    if( isset( $_GET[ 'order' ] ) && isset( $_GET[ 'page' ] ) ) {
        $toys = toyModelGetAll( $_GET[ 'order' ], (int) $_GET[ 'page' ] );
    }
    elseif( isset( $_GET[ 'order' ] ) ) {
        $toys = toyModelGetAll( $_GET[ 'order' ] );
    }
    elseif( isset( $_GET[ 'page' ] ) ) {
        $toys = toyModelGetAll( '', (int) $_GET[ 'page' ] );
    }
    else {
        $toys = toyModelGetAll();
    }

    $data = [
        'titre_h1' => 'Les jouets',
        'html_title' => SITE_NAME,
        'toys' => $toys,
        'brands' => brandModelGetAll(),
        'page_max' => (int) ceil( (int) $toys[0][ 'toys_total' ] / ITEM_PER_PAGE )
    ];

    viewRender( 'toy-list', $data );
}

function toyControllerShow( string $toy_id ): void
{
    $toy = toyModelGetById( $toy_id );

    if( empty( $toy ) ) die404();

    $toy[ 'stock_current' ] = $toy[ 'stock_total' ];

    if( isset( $_GET[ 'store_id' ] ) ) {
        // On exclut le cas où $_GET[ 'store_id' ] est vide
        // valeur par défaut du formulaire, on affiche le stock_total
        if( ! ( is_numeric( $_GET[ 'store_id' ] ) || empty( $_GET[ 'store_id' ] ) ) ) die404();

        foreach( $toy[ 'store' ] as $store ) {
            if( (int) $_GET[ 'store_id' ] === $store[ 'id' ] ) {
                $toy[ 'stock_current' ] = $store[ 'quantity' ];
            }

            if( empty( $_GET[ 'store_id' ] ) ) {
                $toy[ 'stock_current' ] = $toy[ 'stock_total' ];
            }
        }
    }

    $data = [
        'html_title' => SITE_NAME,
        'toy' => $toy
    ];

    viewRender( 'toy-details', $data );
}

function toyControllerShow_brand( string $brand_id, string $order = '', int $page = 1 ): void
{
    $toys_by_brand = toyModelGetByBrand( $brand_id, $order, $page );

    if( empty( $toys_by_brand ) ) die404();

    $data = [
        'titre_h1' => 'Les jouets',
        'html_title' => SITE_NAME,
        'toys' => $toys_by_brand,
        'brands' => brandModelGetAll(),
        'page_max' => ceil( (int) $toys_by_brand[0][ 'toys_total' ] / ITEM_PER_PAGE )
    ];

    viewRender( 'toy-list', $data );
}