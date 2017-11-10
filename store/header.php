<?php
/**
 * Template main header 
 */
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body>
	<div class="wrap">
		<div class="header-top js-header-top">
		    <div class="container">
		        <div class="header-top__item">
			        <ul class="header-cord" >
			            <li><a class="header-top__city header__link" href="">Омск</a></li>
			            <li><a class="header-top__address header__link" href="">ул. Гагарина, 8/2</a></li>
			            <li><a class="header-top__cart header__link" href="/cart">Корзина <span><?php echo "(" . WC()->cart->get_cart_contents_count() . ")"; ?></span></a></li>
			        </ul>
			    </div>
		        <div class="header-top__item">
		            <button class="header-top__phone-call" type="button">Заказать обратный звонок</button>
		            <a class="header-top__number-phone" href="tel:+89087997555"><?php if ( get_field( 'phone', 'option' ) ) : ?> <?php the_field( 'phone', 'option' ); ?> <?php endif; ?></a>
		        </div>
		    </div>
		</div>
		<div class="header container">
		    <div class="header__item header__logo">
		        <a href="" class="header__logo-link">
		            <?php 
					$image = get_field( 'logo', 'option' );
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