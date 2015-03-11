<?php
/**
 * Template Name: Front Page
 *
 */
 get_header(); ?>

        <!-- NEWSLETTER--> 
	    <?php get_template_part('template-part', 'newsletter'); ?>

		<div class="container dmbs-home">  
		 	    <!-- ABAS--> 
			    <?php get_template_part('template-part', 'abas'); ?>
			    
			    <?php //get the right sidebar ?>
		        <?php get_sidebar( 'home' ); ?> 
		</div>
		<!-- end content container -->

        <!-- NEWSLETTER--> 
	    <?php get_template_part('template-part', 'newsletter'); ?>

<?php get_footer(); ?>


