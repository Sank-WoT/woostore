<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author     WooThemes
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

the_title( '<h1 class="product_title entry-title">', '</h1>' );
?>
<div class="product__container group">
	<button class="btn btn_blue product__btn-like" type="button">Нравится этот товар</button>
	<a class="btn product__btn-manual" href="">Инструкция по оклейке</a>
	<div class="footer__item right social-menu">
        <span class="social-menu__title">Поделиться</span>
        <ul>
        	<?php get_template_part( 'social' ); ?>
        </ul>
    </div>
</div>