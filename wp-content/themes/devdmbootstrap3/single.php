<?php get_header(); ?>

<?php get_template_part('template-part', 'top-news'); ?>

<!-- start content container -->
<div id="single" class="container">

   <div class="col-md-8 dmbs-single">

        <?php // theloop
        if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <h1 class="post-title"><?php the_title() ;?></h1>
            <?php get_template_part('template-part', 'postmeta'); ?>
           
             <!-- Go to www.addthis.com/dashboard to customize your tools -->
             <div class="addthis_native_toolbox"></div> <span class="comentario"><?php comments_number( '', '1', '% comentários' ); ?></span>                               
                          
            <?php the_content(); ?>
          
            
            <?php wp_link_pages(); ?>
            <?php comments_template(); ?>

        <?php endwhile; ?>
        <?php else: ?>

            <?php get_404_template(); ?>

        <?php endif; ?>

         <!-- Go to www.addthis.com/dashboard to customize your tools -->
           <div class="addthis_recommended_horizontal"></div>

    </div>

  <?php //get the right sidebar ?>
    <?php get_sidebar( 'right' ); ?>

</div>
<!-- end content container -->

<?php get_footer(); ?>