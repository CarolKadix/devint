<?php


/**
 * Iniciar a class de vídeos
 * 
 */
$videos = new Canal_Videos();

get_header();
?>

<?php get_template_part('template-part', 'top-pages'); ?>
</div><!-- fechar o header -->

<div class="dmbs-videos-featured">
	<div class="container">
		<?php $videos->output_featured_video(); ?>
	</div>
</div>
<div class="dmbs-videos-grid">
	<div class="container">
		<?php $videos->output_video_grid(); ?>
	</div>
</div>

<?php get_footer(); ?>