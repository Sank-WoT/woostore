<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="cart-footer <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>" >
    <div class="cart-footer__item cart-footer__item_btn">
        <a href="/shop" class="btn btn__cart-footer">Продолжить покупки</a>
    </div>
    
    <div class="cart-footer__item cart-footer__item_shipping">
	<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

		<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

		<?php wc_cart_totals_shipping_html(); ?>

		<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

	<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>
        <div class="cart-footer__item-title">ДОСТАВКА:</div>
        	<div data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>" class="shipping cart-footer__item-price"><?php woocommerce_shipping_calculator(); ?></div>
    	</div>
	<?php endif; ?>
	</div>  
    <div class="cart-footer__item cart-footer__item_total">
        <div class="cart-footer__item-title"><?php _e( 'Total', 'woocommerce' ); ?></div>
        <div data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>" class="cart-footer__item-price"><?php wc_cart_totals_order_total_html(); ?>
        </div>
    </div>

<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
    <div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>
</div>