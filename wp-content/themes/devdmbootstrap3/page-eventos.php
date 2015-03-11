<?php get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<?php get_template_part('template-part', 'topnav'); ?>

<!-- start content container -->
<div class="row dmbs-content">
	
	<div class="col-md-<?php devdmbootstrap3_main_content_width(); ?> dmbs-main">
		
		<?php
		if ( have_posts() ){
			while ( have_posts() ){
				the_post();
				?>
					<h2 class="page-header"><?php the_title() ;?></h2>
					<?php the_content(); ?>
					<?php devint_events_table(); ?>
				<?php
			}
		}
		else {
			get_404_template();
		}
		?>

	</div>

</div>
</div>
<!-- end content container -->

<?php get_footer(); ?>
