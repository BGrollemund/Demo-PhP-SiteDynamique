<?php

define( 'VIEW_PATH', APP_PATH . 'views' . DS );

/**
 * Charge la page view recherché
 *
 * @param string $name
 * @param array $data
 */
function viewRender( string $name, array $data = [] ): void
{
    $path = VIEW_PATH . $name . '.php';

    if( ! is_readable($path) ) die404();

    $data['brands'] = brandModelGetAll();

    extract( $data );

    require_once VIEW_PATH . '_layout-begin.php';
    require_once $path;
    require_once VIEW_PATH . '_layout-end.php';

}

/**
 * Renvoie erreur 404, affiche la page d'erreur et die()
 */
function die404(): void
{
    http_response_code( 404 );
    require_once VIEW_PATH . 'error-404.php';
    die();
}

/**
 * Génère le lien http://
 * anticache optionnel qui ajoute la version du site à la fin du lien (utilisation pour la css)
 *
 * @param string $path
 * @param bool $anticache (optionnel, valeur par défaut: false)
 */
function _uri( string $path, $anticache = false ): void
{
    $format = '%s://%s/%s';

    if( $anticache ) {
        $format .= '?v=' . SITE_VERSION;
    }

    printf(
        $format,
        $_SERVER[ 'REQUEST_SCHEME' ],
        $_SERVER [ 'HTTP_HOST' ],
        $path
    );
}

/**
 * Renvoie la liste des marques et le nombre de jouets associés à chacune
 *
 * @return array
 */
function brandModelGetAll(): array
{
    $arr_brand = [];

    $mysql = databaseGetConnection();

    $q_brand = 'SELECT brands.id, brands.name, COUNT( * ) AS `toys_num` FROM `brands`
                INNER JOIN `toys` ON brands.id = toys.brand_id
                GROUP BY toys.brand_id';
    $r_brand = mysqli_query( $mysql, $q_brand );

    if( ! $r_brand ) return $arr_brand;

    while( $brand = mysqli_fetch_assoc( $r_brand ) ) {

        $arr_brand[] = $brand;
    }

    databaseClose();

    return $arr_brand;
}

/**
 * Remplace les points par des virgules (utilisation pour les prix)
 *
 * @param string $text
 * @return string
 */
function replaceDotByComma( string $text ): string
{
    return str_replace( '.', ',', $text );
}

/**
 * Supprime Toys'R'Us de la string (utilisation pour le nom des magasins)
 *
 * @param string $text
 * @return string
 */
function cleanStoreName( string $text): string
{
    return str_replace('Toys\'R\'Us ', '', $text);
}
