<?php 
/**
 * Template header for cart
 */
wp_head(); 
?>
<div class="header container">
    <div class="header__item header__logo">
        <a href="" class="header__logo-link">
            <?php $image = get_field( 'logo', 'option' );
			if( !empty( $image ) ): ?>
				<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
			<?php endif; ?>
        </a>
    </div>
    <div class="header__item header__menu">
        <ul>
            <li class="header__menu_stock"><a href="">Акции</a></li>
            <li class="current-menu-item header__menu_wallpapers"><a href="">Фотообои</a></li>
            <li class="header__menu_payment-shipping"><a href="">Оплата и доставка</a></li>
        </ul>
    </div>
</div>