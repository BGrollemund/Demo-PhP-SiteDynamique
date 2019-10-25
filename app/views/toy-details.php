<h1><?php echo $toy[ 'name' ]; ?></h1>

<div class="toy-info line-height-30">
    <div>
        <img src="<?php _uri( 'assets/img/toys/' . $toy['image'] ) ?>" alt="image de <?php echo $toy[ 'name' ]; ?>">
        <div class="tall-extra padding-left">
            <?php echo replaceDotByComma( $toy['price'] ); ?> €
        </div>
        <div class="padding-left">
            <form action="" method="GET">
                <label>
                    <select name="id" class="hidden">
                        <option value="<?php echo $toy['id']; ?>"></option>
                    </select>
                    <select name="store_id">
                        <option value="">Quel magasin?</option>
                        <!--
                            Affichage des différents magasin dans le menu déroulant
                            avec un selected="selected" pour conserver le choix comme valeur par défaut
                        -->
                        <?php foreach( $toy['store'] as $store ) {
                            echo '<option ';
                            if( isset( $_GET[ 'store_id' ] ) && (int) $_GET[ 'store_id' ]  === $store[ 'id' ] ) {
                                echo 'selected="selected" ';
                            }
                            echo 'value="' . $store[ 'id' ] . '">';
                            echo cleanStoreName( $store[ 'name' ] );
                            echo '</option>';
                        }
                        ?>
                    </select>
                </label>
                <button type="submit">Ok</button>
            </form>
            <p><span class="bold-blue">Stock: </span><span class="tall-bold"><?php echo $toy[ 'stock_current' ]; ?></span></p>
        </div>
    </div>
    <div>
        <div class="inner-text-style">
            <p><span class="bold-blue">Marque: </span><span class="tall-bold"><?php echo $toy[ 'brand_name' ]; ?></span></p>
            <?php echo $toy[ 'description' ]; ?>
        </div>
    </div>

</div>



