<?php
/**
 * Template Name: FAQ
 *
 */
get_header(); ?>

<?php get_template_part('template-part', 'top-pages'); ?>

<!-- start content container -->
	<div class="container dmbs-fornecedores no-padding">
		<div class="row">
			<div class="col-md-4">
				<?php devint_faq_sidebar(); ?>
			</div>
			<div class="col-md-8">
				<?php
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						the_content();
					}
				}
				?>
				
				<?php devint_faq_form(); ?> 
			</div>
		</div>
		
	</div>
<!-- end content container -->
<?php get_footer(); ?>