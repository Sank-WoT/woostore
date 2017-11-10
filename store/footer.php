		<?php 
		/**
		 * Template main footer
		 */
		get_template_part( 'template' ); ?>
		</div>
		<div class="footer">
		    <div class="container">
		        <div class="footer__item footer__menu">
		            <ul>
		                <li><a href="">Инструкция по оклейке</a></li>
		                <li><a href="">Контакты</a></li>
		            </ul>
		        </div>
		        <div class="footer__item social-menu">
		            <span class="social-menu__title">Поделиться</span>
		            <ul>
		            	<?php get_template_part( 'social' ); ?>
		            </ul>
		        </div>
		    </div>
		</div>
	    <?php wp_footer(); ?>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	</body>
</html>