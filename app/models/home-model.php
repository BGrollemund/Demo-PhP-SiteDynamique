<?php

/**
 * Renvoie un tableau avec les 3 jouets les plus vendus et les infos nécessaires à l'affichage de la page Home
 *
 * @return array
 */
function homeModelGetTop3(): array
{
    $arr_top3 = [];

    $mysql = databaseGetConnection();

    $q_top3 = 'SELECT `toy_id` AS `id`, `name`, `brand_id`, `price`, `image`, SUM( `quantity` ) AS `sale_total`
                FROM `sales` INNER JOIN toys ON sales.toy_id = toys.id
                GROUP BY `toy_id` ORDER BY `sale_total` DESC LIMIT 3';
    $r_top3 = mysqli_query( $mysql, $q_top3 );

    if( ! $r_top3 ) return $arr_top3;

    while( $toy = mysqli_fetch_assoc( $r_top3 ) ) {

        $arr_top3[] = $toy;
    }

    databaseClose();

    return $arr_top3;
}