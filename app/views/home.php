<h1><?php echo $titre_h1; ?></h1>

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