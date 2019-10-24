<h1><?php echo $titre_h1; ?></h1>

<div class="text-center">
    <form action="" method="GET" class="padding-bottom-light">
        <label>
            <select name="brand_id">
                <option value="">Quelle marque ?</option>
                <?php foreach( $brands as $brand ) {
                    echo '<option value="' . $brand[ 'id' ] . '">';
                    echo $brand[ 'name' ] . ' (' . $brand[ 'toys_num' ] . ')';
                    echo '</option>';
                }
                ?>
            </select>
        </label>
        <button type="submit">Ok</button>
    </form>
</div>

<nav>
    <ul class="menu-sort">
        <li>
            <!--
                Ecriture de l'url du lien en conservant les GET potentiellement présents
                Lors de l'utilisation du bouton tri on passe sur la première page
            -->
            <a href="<?php _uri('jouets?order=ASC');
                        if( isset( $_GET[ 'brand_id' ] ) ) {
                            echo '&brand_id=' . $_GET[ 'brand_id' ];
                        }
                        if( isset( $_GET[ 'page' ] ) ) {
                        echo '&page=1';
                        }
                        echo '" '; ?> class="btn-sort">&#9650;</a>
        </li>
        <li class="tall-bold">
            Tri par prix
        </li>
        <li>
            <a href="<?php _uri('jouets?order=DESC');
                        if( isset( $_GET[ 'brand_id' ] ) ) {
                            echo '&brand_id=' . $_GET[ 'brand_id' ];
                        }
                        if( isset( $_GET[ 'page' ] ) ) {
                        echo '&page=1';
                        }
                        echo '" '; ?> class="btn-sort">&#9660;</a>
        </li>
        <li class="grow-item"></li>
        <!--
            Création de la pagination
                - On affiche rien si une seule page
                - On cache le bouton de gauche si pas de page sélectionnée ou première page
                - On cache le bouton de droite si dernière page
                - Ajout de "2/5" (par ex) pour la pagination, "1/5" si pas de page sélectionnée
                - Conservation des GET potentiellement présents
        -->
        <?php if( (int) $page_max !== 1) {
            echo '<li>';
            if( ! isset( $_GET[ 'page' ] ) || (int) $_GET[ 'page' ] === 1 ){
                echo '<span class="hidden-sort">&#9668;</span>';
            }
            else {
                echo '<a href="';
                _uri('jouets');
                echo '?';
                if( isset( $_GET[ 'brand_id' ] ) ) {
                    echo 'brand_id=' . $_GET[ 'brand_id' ] . '&';
                }
                if( isset( $_GET[ 'order' ] ) ) {
                    echo 'order=' . $_GET[ 'order' ] . '&';
                }
                if( isset( $_GET[ 'page' ] ) ) {
                    echo 'page=' . ( (int) $_GET[ 'page' ] - 1 );
                }
                echo '" class="btn-sort">&#9668;</a>';
            }
            echo '</li>';
            echo '<li class="tall-bold">';
            echo 'Page ';
            if( isset( $_GET[ 'page' ] ) ){
                echo $_GET[ 'page' ];
            }
            else {
                echo '1';
            }
            echo '/' . $page_max;
            echo '</li>';
            echo '<li>';
            if( isset( $_GET[ 'page' ] ) && (int) $_GET[ 'page' ] === (int) $page_max ){
                echo '<span class="hidden-sort">&#9658;</span>';
            }
            else {
                echo '<a href="';
                _uri('jouets');
                echo '?';
                if( isset( $_GET[ 'brand_id' ] ) ) {
                    echo 'brand_id=' . $_GET[ 'brand_id' ] . '&';
                }
                if( isset( $_GET[ 'order' ] ) ) {
                    echo 'order=' . $_GET[ 'order' ] . '&';
                }
                if( ! isset( $_GET[ 'page' ] ) ) {
                    echo 'page=2';
                }
                else {
                    echo 'page=' . ( (int) $_GET[ 'page' ] + 1 );
                }
                echo '" class="btn-sort">&#9658;</a>';
            }
            echo '</li>';
        } ?>
    </ul>
</nav>

<?php if( ! empty($toys) ): ?>
    <ul class="mosaic">
        <?php foreach( $toys as $toy ): ?>
            <li>
                <a href="<?php _uri('jouets?id=' . $toy[ 'id' ] ); ?>">
                    <div>
                        <img src="<?php _uri( 'assets/img/toys/' . $toy['image'] ) ?>" alt="image de <?php echo $toy[ 'name' ]; ?>">
                    </div>
                    <div class="bold-blue">
                        <?php echo $toy['name']; ?>
                    </div>
                    <div class="grow-item"></div>
                    <div>
                        <p class="tallest"><?php echo replaceDotByComma( $toy['price'] ); ?> €</p>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <div>Aucun jouet dans notre magasin</div>
<?php endif; ?>