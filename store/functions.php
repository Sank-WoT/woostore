<?php 
/**
 * woostore_setup function init  css and js files
 */
	function woostore_setup() {
		wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.min.css' );
		wp_enqueue_style( 'vendors', get_template_directory_uri() . '/css/vendors.min.css' );
		wp_enqueue_style( 'mewcss', get_template_directory_uri() . '/style.css' );
		wp_enqueue_script( 'select', get_template_directory_uri() . '/js/select2.full.min.js' );
		wp_enqueue_script( 'vendors', get_template_directory_uri() . '/js/vendors.min.js' ); 
		wp_enqueue_script( 'se', get_template_directory_uri() . '/js/update-cart.js' );
		wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.min.js' ); 
	}
	add_action( 'wp_enqueue_scripts', 'woostore_setup' );
/**
 * setup function setup theme
 */
	function setup() {
		add_theme_support( 'starter-content', array(
		'options'     => '', // опции сайта
		'theme_mods'  => '', // опции темы
		'widgets'     => '', // данные виждетов
		'nav_menus'   => '', // данные меню
		'attachments' => '', // данные вложений
		'posts'       => '', 
		) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats' );
		add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		) );
		add_theme_support( 'title-tag' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'woocommerce' );
	}
	add_action( 'after_setup_theme', 'setup' );
/**
 * register_my_menus function register new menu
 */
	function register_my_menus() {
		register_nav_menus(array( 'header-menu' => 'header-menu'));
	}
	add_action( 'init', 'register_my_menus' );

	if( function_exists( 'acf_add_options_page' ) ) {	
		acf_add_options_page();	
	}
	add_action( 'init', 'acf_add_options_page' );

	if ( function_exists( 'add_image_size'  ) ) {
		add_image_size( 'homepage-thumb', 1200, 600, true ); // Кадрирование изображения
	}
/**
 * loop_subcategory_title function out category 
 * @param  [type] $category category store
 */
	function loop_subcategory_title( $category ) { ?>
		<div class="wallpapers__info-item wallpapers__title"><?php echo $category->name; ?></div>
	    <div class="wallpapers__info-item">
	       <a class="wallpapers__link" href="">Посмотреть</a>
	    </div> <?php
	}
	add_filter( 'woocommerce_shop_loop_subcategory_title_sank', 'loop_subcategory_title' );

/**
 * [adjust_woocommerce_get_order_item_totals unset cart item]
 * @param  [type] $totals [fields]
 * @return [type] $totals [totals]
 */
	function adjust_woocommerce_get_order_item_totals( $totals ) {
	  unset($totals['cart_subtotal'] );
	  return $totals;
	}
	add_filter( 'woocommerce_get_order_item_totals', 'adjust_woocommerce_get_order_item_totals' );
/**
 * [custom_override_checkout_fields function edit fields checkout]
 * @param  [type] $fields [checkout fields]
 * @return [type] $fields [checkout fields]
 */
	function custom_override_checkout_fields( $fields ) { 
		$fields['billing']['billing_address_1']['required'] = false;
		$fields['billing']['billing_address_2']['required'] = false;
	    $fields['billing']['billing_company']['required'] = false;
	    $fields['billing']['billing_phone']['required'] = true;
	    unset( $fields['billing']['billing_company'] );
	    $fields['billing']['billing_country']['required'] = false;
	    unset( $fields['billing']['billing_country'] );
	    $fields['billing']['billing_city']['required'] = false;
	    unset( $fields['billing']['billing_city'] );
	    $fields['billing']['billing_state']['required'] = false;
	    unset( $fields['billing']['billing_state'] );
	    $fields['billing']['billing_postcode']['required'] = false;
	    unset( $fields['billing']['billing_postcode'] );
	    $fields['shipping']['shipping_first_name']['required'] = false;
	    unset( $fields['shipping']['shipping_first_name'] );
	    $fields['shipping']['shipping_last_name']['required'] = false;
	    unset( $fields['shipping']['shipping_last_name'] ); 
	    $fields['shipping']['shipping_country']['required'] = false;
	    unset( $fields['shipping']['shipping_country'] );
	    $fields['shipping']['shipping_postcode']['required'] = false;
	    unset( $fields['shipping']['shipping_postcode'] );
	    $fields['shipping']['shipping_postcode']['required'] = false;
	    unset( $fields['shipping']['shipping_state'] );
	    unset( $fields['shipping']['shipping_company'] );
	    unset( $fields['shipping']['shipping_address_2'] );
	    unset( $fields['shipping']['shipping_postcode'] );
	    $fields['shipping']['shipping_address_1'] ['placeholder'] = '';
	    $fields['order']['order_comments'] = array(
    	'type' 			=> 'textarea',
    	'label' 		=> __( '', 'woocommerce' )
    	);
	    $fields['shipping']['house'] = array(
    	'label'     	=> __( 'House', 'woocommerce' ),
	    'placeholder'   => _x( '', 'placeholder', 'woocommerce'),
	    'required'  	=> true,
	    'class'     	=> array( 'form-row-wide' ),
	    'clear'     	=> true
	     );
	    $fields['shipping']['apartament'] = array(
    	'label'     	=> __( 'Apartament', 'woocommerce' ),
	    'placeholder'   => _x( '', 'placeholder', 'woocommerce' ),
	    'required'  	=> true,
	    'class'     	=> array( 'form-row-wide' ),
	    'clear'     	=> true
	     );
	    $fields['shipping']['shipping_city']['required'] = false;
	    unset( $fields['shipping']['shipping_city'] );
	    return $fields;
	}
	add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
	// 2.1 +
	add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_single_add_to_cart_text' );  
	function woo_custom_single_add_to_cart_text() {
    	return __( 'Buy', 'woocommerce' );  
	}

	/**
 * Format the price with a currency symbol.
 * @param float $price
 * @param array $args (default: array())
 * @return string
 */
function wc_price_sank( $price, $args = array() ) {
	extract( apply_filters( 'wc_price_args', wp_parse_args( $args, array(
	'ex_tax_label'       => false,
	'currency'           => '',
	'decimal_separator'  => wc_get_price_decimal_separator(),
	'thousand_separator' => wc_get_price_thousand_separator(),
	'decimals'           => wc_get_price_decimals(),
	'price_format'       => get_woocommerce_price_format(),
	) ) ) );

	$unformatted_price = $price;
	$negative          = $price < 0;
	$price             = apply_filters( 'raw_woocommerce_price', floatval( $negative ? $price * -1 : $price ) );
	$price             = apply_filters( 'formatted_woocommerce_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );

	if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $decimals > 0 ) {
		$price = wc_trim_zeros( $price );
	}

	$formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format, '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol( $currency ) . '</span>', $price );
	$return          = '<span class="woocommerce-Price-amount amount fgk;lagkldfklgdfggfkgsdf">' . $formatted_price . '</span>';

	if ( $ex_tax_label && wc_tax_enabled() ) {
		$return .= ' <small class="woocommerce-Price-taxLabel tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
	}

	/**
	 * Filters the string of price markup.
	 *
	 * @param string $return 			Price HTML markup.
	 * @param string $price	            Formatted price.
	 * @param array  $args     			Pass on the args.
	 * @param float  $unformatted_price	Price as float to allow plugins custom formatting. Since 3.2.0.
	 */
	return add_filters( 'wc_price', 'wc_price_sank' );
}

	function woocommerce_get_product_thumbnail_sank($size = 'shop_catalog', $deprecated1 = 0, $deprecated2 = 0) {
		global $post;
        $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );
        if ( has_post_thumbnail() ) {
            $props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
            return get_the_post_thumbnail( $post->ID, $image_size, array(
                'title'  => $props['title'],
                'alt'    => $props['alt'],
            ) );
        } elseif ( wc_placeholder_img_src() ) {
            return wc_placeholder_img( $image_size );
        }
    }
  
/**
 * [woocommerce_template_loop_product_thumbnail function loop cart item]
 * @return [type] [description]
 */
    function woocommerce_template_loop_product_thumbnail() {
    	?>
    	<div class="wallpapers__item">
	        <?php echo woocommerce_get_product_thumbnail_sank(); ?>
	        <div class="wallpapers__info">
		    	<div class="wallpapers__info-item wallpapers__title">
		    		<?php echo  get_the_title(); ?>
		    	</div>
		    	<div class="wallpapers__info-item">
		    		<?php echo '<a href="' . get_the_permalink() . '" class=" wallpapers__link woocommerce-LoopProduct-link"> Посмотреть </a>' ?>
	        	</div>
	        </div>
	    </div>

        <?php
    }
    add_action( 'woocommerce_template_loop_product_thumbnail', 'woocommerce_template_loop_product_thumbnail' );
/**
 * remove hook
 */
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
 	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
 	add_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 20);
 	add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 10);
	add_action( 'woocommerce_single_after_product_summary', 'woocommerce_template_single_title', 5);
	add_action( 'woocommerce_single_after_product_summary', 'woocommerce_template_single_rating', 10);
	add_action( 'woocommerce_single_after_product_summary', 'woocommerce_output_product_data_tabs', 10);
 	add_action( 'woocommerce_single_after_product_summary', 'woocommerce_template_single_price', 10);
 	add_action( 'woocommerce_single_after_product_summary', 'woocommerce_template_single_excerpt', 20);
 	add_action( 'woocommerce_single_after_product_summary', 'woocommerce_template_single_add_to_cart', 30);
 	add_action( 'woocommerce_single_after_product_summary', 'woocommerce_template_single_meta', 40);
 	add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
/**
 * [woo_remove_product_tabs function efit tabs ]
 * @param  [type] $tabs [tabs]
 * @return [type] $tabs [tabs]
 */
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['reviews'] ); 			
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

/**
 * [my_custom_checkout_field_update_order_meta ]
 * @param  [type] $order_id [description]
 */
function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['apartament'] ) ) {
        update_post_meta( $order_id, 'Apartament', sanitize_text_field( $_POST['apartament'] ) );
    }
    if ( ! empty( $_POST['house'] ) ) {
        update_post_meta( $order_id, 'House', sanitize_text_field( $_POST['house'] ) );
    }
    if ( ! empty( $_POST['shipping_address_1'] ) ) {
        update_post_meta( $order_id, 'Street', sanitize_text_field( $_POST['shipping_address_1'] ) );
    }
}
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

/**
 * [my_custom_checkout_field_display_admin_order_meta description]
 * @param  [type] $order [description]
 */
function my_custom_checkout_field_display_admin_order_meta( $order ) {
	echo '<p><strong>' . ( 'Street' ) . ':</strong> ' . get_post_meta( $order->get_id(), 'Street', true ) . '</p>';
    echo '<p><strong>' . ( 'Apartament' ) . ':</strong> ' . get_post_meta( $order->get_id(), 'Apartament', true ) . '</p>';
    echo '<p><strong>' . ( 'House' ) . ':</strong> ' . get_post_meta( $order->get_id(), 'House', true ) . '</p>';
}
 add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

/**
 * [nolo_custom_field_display_cust_order_meta description]
 * function out Street, House, Apartament.
 * @param  [type] $order [description]
 */
function nolo_custom_field_display_cust_order_meta( $order ) {
	echo '<h3> Address <h3>';
	echo '<p><strong>' . ( 'Street' ) . ':</strong> ' . get_post_meta( $order->get_id(), 'Street', true ) . '</p>';
	echo '<p><strong>' . ( 'House' ) . ':</strong> ' . get_post_meta( $order->get_id(), 'House', true ) . '</p>';
	echo '<p><strong>' . ( 'Apartament' ) . ':</strong> ' . get_post_meta( $order->get_id(), 'Apartament', true ) . '</p>';
}

/**
 * [category_get function output category]
 * @param  [type] $count [number count]
 * @return [type]        []
 */
function category_get( $count ) {
    $taxonomy     = 'product_cat';
    $orderby      = 'name';  
    $show_count   = 0;      // 1 for yes, 0 for no
    $pad_counts   = 0;      // 1 for yes, 0 for no
    $hierarchical = 1;      // 1 for yes, 0 for no  
    $title        = '';  
    $empty        = 0;

    $args = array(
   'taxonomy'     => $taxonomy,
   'orderby'      => $orderby,
   'show_count'   => $show_count,
   'pad_counts'   => $pad_counts,
   'hierarchical' => $hierarchical,
   'title_li'     => $title,
   'hide_empty'   => $empty,
   'number' 	  => $count
    );
   return get_categories( $args );
}