<?php get_header(); ?>
<?php $images = get_field( 'slider', 'option' );  ?>
<?php if( $images ): ?>
    <div class="home-slider container js-home-slider">      
        <?php foreach( $images as $image ): ?>
            <div class="item"> 
                <img src="<?php echo $image['sizes']['homepage-thumb']; ?>" alt="<?php echo $image['alt']; ?>"/>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<h1 class="title"><span>популярные фотообои</span></h1>
<div class="wallpapers container">
    <?php 
        $all_categories = category_get(6); 
        ?>
        <?php if ($all_categories): ?>
            <?php foreach ($all_categories as $category): ?> 
                ?>
                <div class="wallpapers__item">
                    <img src="<?php bloginfo('template_url'); ?>/images/popular/pw2.jpg" alt="">
                    <div class="wallpapers__info">
                        <div class="wallpapers__info-item wallpapers__title"><?php echo $category->name; ?></div>
                        <div class="wallpapers__info-item">
                            <a class="wallpapers__link" href="<?php echo get_term_link($category->slug, 'product_cat'); ?>">Посмотреть</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <a class="go-directory" href="/shop">Перейти в каталог</a>
</div>
<?php get_footer(); ?>