<?php
if ( have_rows( 'social', 'option' ) ):
    while ( have_rows( 'social', 'option' )) : the_row();
        $img = get_sub_field( 'img' );
        $link = get_sub_field( 'link' );
        if( $img ): ?>
        <li class="full social-holder">
			<a target="_blank" href="<?php echo $link['url']?>" target="_blank"><img src="<?php echo $img['url']; ?>" alt="Social"></a>
		</li>
		<?php endif; 
    endwhile;
else :
endif;
?>