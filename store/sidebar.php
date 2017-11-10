<?php 
/**
 * Template sidebar category shop
 */
?>
<div class="sidebar sidebar-menu">
    <h4 class="sidebar-menu__title">ФОТООБОИ</h4>
    <ul id='sidebar'>
        <?php 
        $all_categories = category_get(99);
        $is = isset( $wp_query->get_queried_object()->term_id );
        foreach ( $all_categories as $cat ) {
	        if ( $cat->category_parent == 0 ) {
	            $category_id = $cat->term_id;  
	            if ( true == $is ) {
	            	if ( $wp_query->get_queried_object()->term_id == $cat->term_id ) {
	                echo '<li class = current-cat><a href="'. get_term_link( $cat->slug, 'product_cat' ) . '">' . $cat->name . '</a></li>';
	               }  else {
	                echo '<li><a href="' . get_term_link( $cat->slug, 'product_cat' ) .'">'. $cat->name .'</a></li>';
	               }   
	            } else {
	            	echo '<li><a href="' . get_term_link( $cat->slug, 'product_cat' ) .'">'. $cat->name .'</a></li>';
	            }  
        }}?>
    </ul>
</div>