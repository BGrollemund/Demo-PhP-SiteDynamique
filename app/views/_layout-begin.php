<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
    <link rel="stylesheet" href="<?php _uri('assets/css/style.css', true ); ?>">
    <title><?php echo $html_title; ?></title>
</head>
<body>

<div class="background">
    <img src="<?php _uri('assets/img/logos/background.jpg'); ?>" alt="Image de fond du site Toys'R'Us">
</div>

<div class="container">
    <header>
        <div class="logo">
            <img src="<?php _uri('assets/img/logos/logo.jpg'); ?>" alt="image du logo Toys'R'Us">
        </div>

        <nav>
            <ul class="menu-nav">
                <li class="btn">
                    <a href="<?php _uri('jouets'); ?>">Tous les jouets</a>
                </li>
                <li id="open-menu" class="btn sub-menu">
                    <a>Par marque &#9660;</a>
                    <ul id="hidden-menu" class="hidden">
                        <?php
                        foreach( $brands as $brand ) {
                            echo '<li><a href="';
                            _uri('jouets?brand_id=');
                            echo $brand[ 'id' ] . '">' . $brand[ 'name' ] . ' (' . $brand[ 'toys_num' ] . ')</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li class="btn grow-item"></li>
            </ul>
        </nav>
    </header>

    <main>