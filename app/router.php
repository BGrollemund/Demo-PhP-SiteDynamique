<?php

$routerRoutes = [];

/**
 * Recherche et lance la fonction contrôleur qui doit être lancée en fonction de l'url demandée
 */
function routerStart(): void
{
    global $routerRoutes;

    $requested_url = $_SERVER[ 'REDIRECT_URL' ] ?? '/';
    $requested_method = $_SERVER[ 'REQUEST_METHOD' ];

    // Teste si la méthode de la route demandée existe dans les routes enregistrées
    if( empty( $routerRoutes[ $requested_method ] ) ) die404();

    $current_route = [];

    foreach( $routerRoutes[ $requested_method ] as $route_url => $route ) {

        // Modifie les routes enregistrées en Regex
        // Par ex: /jouets devient /^\/jouets$/i
        $route_url = '/^' . str_replace( '/', '\/', $route_url ) . '$/i';

        // Cherche si l'url de la route demandée correspond à la Regex de l'url d'une route enregistrée
        // Si pas de correspondance on continue le foreach sans appliquer le reste
        if( preg_match( $route_url, $requested_url ) === 0 ) {
            continue;
        }

        // Si correspondance on affecte la route trouvée dans les routes enregistrées
        $current_route = $route;

        break;
    }

    // Pas de correspondance trouvée grâce au foreach:
    // La route demandée n'est pas dans les routes enregistrées, erreur 404
    if( empty( $current_route ) ) die404();

    // Si correspondance dans le foreach:
    // Require le contrôleur correspondant
    $ctrl_name = $current_route[0];
    controllerLoad( $ctrl_name );

    // Ajoute l'action de la route enregistrée pour sélectionner la fonction à lancer
    $action = $ctrl_name . 'Controller' . ucfirst( $current_route[1] );

    // Si la fonction à lancer n'existe pas, erreur 404
    if( ! function_exists( $action ) ) die404();

    // Lance la fonction contrôleur
    $action();
}

/**
 * Affecte les routes à $routerRoutes (utilisation dans app.php)
 *
 * @param string $method
 * @param string $url
 * @param string $controller
 * @param string $action
 */
function routerRegisterRoute( string $method, string $url, string $controller, string $action ): void
{
    global $routerRoutes;
    $routerRoutes[ $method ][ $url ] = [ $controller, $action ];
}