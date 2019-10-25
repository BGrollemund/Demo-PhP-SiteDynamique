<?php

/**
 * Renvoie un tableau avec tous les jouets (avec pagination)
 *
 * @param string $order (valeur par défaut: '', pas de tri)
 * @param int $page (valeur par défaut: 1, on démarre page 1)
 * @return array
 */
function toyModelGetAll( string $order = '', int $page = 1 ): array
{
    if( ! ( $order === '' || $order === 'ASC' || $order === 'DESC' ) ) die404();
    if( ! is_int( $page ) ) die404();

    $arr_all = [];

    $mysql = databaseGetConnection();

    $q_all = 'SELECT `id`, `name`, `price`, `image`, ( SELECT COUNT( * ) FROM `toys` ) AS `toys_total` FROM `toys`';

    // Ajout ordre
    if( $order === 'ASC' || $order === 'DESC' ) {
        $q_all .= ' ORDER BY `price` ' . $order;
    }

    // Ajout pagination
    $q_all .= ' LIMIT ?, ' . ITEM_PER_PAGE;

    $stmt_all = mysqli_prepare( $mysql, $q_all );

    if( ! $stmt_all ) return $arr_all;

    $start_index = ( ( $page - 1 ) * ITEM_PER_PAGE );

    mysqli_stmt_bind_param( $stmt_all, 'i', $start_index );
    mysqli_stmt_execute( $stmt_all );

    $r_all = mysqli_stmt_get_result( $stmt_all );
    mysqli_stmt_close( $stmt_all );

    if( mysqli_num_rows( $r_all ) <= 0 ) return $arr_all;

    while( $toy = mysqli_fetch_assoc( $r_all ) ) {
        $arr_all[] = $toy;
    }

    databaseClose();

    return $arr_all;
}

/**
 * Renvoie un tableau avec toutes les infos nécessaires du jouet demandé
 *
 * @param int $id
 * @return array
 */
function toyModelGetById( int $id ): array
{
    if( ! is_int( $id ) ) die404();

    $arr_toy = [];

    $mysql = databaseGetConnection();

    $q_toy = 'SELECT toys.id, toys.name, `description`, `price`, `image`, brands.name AS `brand_name`,
                `quantity`, stores.id AS `store_id`, stores.name AS `store_name`,
                ( SELECT SUM(quantity) FROM `stock` WHERE `toy_id` = ? GROUP BY `toy_id` ) AS `stock_total`
                    FROM `toys`
                    INNER JOIN brands ON toys.brand_id = brands.id
                    INNER JOIN stock ON toys.id = stock.toy_id
                    INNER JOIN stores ON stock.store_id = stores.id
                    WHERE toys.id = ?;
                    ';

    $stmt_toy = mysqli_prepare( $mysql, $q_toy );

    if( ! $stmt_toy ) return $arr_toy;

    mysqli_stmt_bind_param( $stmt_toy, 'ii', $id, $id );
    mysqli_stmt_execute( $stmt_toy );

    $r_toy = mysqli_stmt_get_result( $stmt_toy );
    mysqli_stmt_close( $stmt_toy );

    if( mysqli_num_rows( $r_toy ) <= 0 ) return $arr_toy;

    while( $toy = mysqli_fetch_assoc( $r_toy ) ) {
        $arr_toy[] = $toy;
    }


    // Transformation des données récupérées dans $arr_toy

    $store = [];

    foreach( $arr_toy as $toy ) {
        $toy_info = [
            'id' => $toy[ 'store_id' ],
            'name' => $toy[ 'store_name' ],
            'quantity' => $toy[ 'quantity' ]
        ];

        $store[] = $toy_info;
    }

    $arr_toy[0]['store'] = $store;
    unset( $arr_toy[0]['quantity'], $arr_toy[0]['store_id'], $arr_toy[0]['store_name'] );

    databaseClose();

    return $arr_toy[0];
}

/**
 * Renvoie un tableau avec toutes les infos nécessaires des jouets triés par marque (avec pagination)
 *
 * @param int $brand_id
 * @param string $order (valeur par défaut: '', pas de tri)
 * @param int $page (valeur par défaut: 1, on démarre page 1)
 * @return array
 */
function toyModelGetByBrand( int $brand_id, string $order = '', int $page = 1 ): array
{
    if( ! ( is_int( $brand_id ) && is_int( $page ) ) ) die404();
    if( ! ( $order === '' || $order === 'ASC' || $order === 'DESC' ) ) die404();

    $arr_by_brand = [];

    $mysql = databaseGetConnection();

    $q_by_brand = 'SELECT toys.id, toys.name, `price`, `image`, ( SELECT COUNT( * ) FROM `toys` WHERE `brand_id` = ? ) AS `toys_total`, brands.name AS `brand_name`, brands.id AS `brand_id` FROM `toys`
                INNER JOIN brands ON toys.brand_id = brands.id
                WHERE brands.id = ?';

    // Ajout ordre
    if( $order === 'ASC' || $order === 'DESC' ) {
            $q_by_brand .= ' ORDER BY `price` ' . $order;
    }

    // Ajout pagination
    $q_by_brand .= ' LIMIT ?, ' . ITEM_PER_PAGE;

    $stmt_by_brand = mysqli_prepare( $mysql, $q_by_brand );

    if( ! $stmt_by_brand ) return $arr_by_brand;

    $start_index = ( ( $page - 1 ) * ITEM_PER_PAGE );

    mysqli_stmt_bind_param( $stmt_by_brand, 'iii', $brand_id, $brand_id, $start_index );
    mysqli_stmt_execute( $stmt_by_brand );

    $r_by_brand = mysqli_stmt_get_result( $stmt_by_brand );
    mysqli_stmt_close( $stmt_by_brand );

    if( mysqli_num_rows( $r_by_brand ) <= 0 ) return $arr_by_brand;

    while( $toy_by_brand = mysqli_fetch_assoc( $r_by_brand ) ) {
        $arr_by_brand[] = $toy_by_brand;
    }

    databaseClose();

    return $arr_by_brand;

}