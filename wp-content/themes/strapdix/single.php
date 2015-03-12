<?php get_header(); ?>

<?php get_template_part('template-part', 'top-news'); ?>

<!-- start content container -->
<div id="single" class="container dmbs-single">

  <!-- GRUPO 1 DE BANNERS 970X90 -->
  <?php echo adrotate_group(1); ?>

   <div class="col-md-8 no-padding">

        <?php // theloop
        if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <h1 class="post-title"><?php the_title() ;?></h1>
            <?php get_template_part('template-part', 'postmeta'); ?>
           
             
              <figure>            
              <?php if ( has_post_thumbnail()) : ?>                              
                <?php the_post_thumbnail('single'); ?>
              <?php endif; ?> 
              </figure>
            
            <?php the_content(); ?> 
            <?php comments_template(); ?>

            <?php endwhile; ?>
            <?php else: ?>

              <?php get_404_template(); ?>

            <?php endif; ?>

        <?php get_template_part('template-part', 'social-more'); ?>       
      

        <div class="right">   
          <a href="../publicacoes" class="back"> 
           <img src="<?php bloginfo('template_url'); ?>/img/arrow.png"> Voltar para a lista de publicações
          </a>
          
        </div>

    </div>

  <?php //get the right sidebar ?>
    <?php get_sidebar( 'right' ); ?>

</div>
<!-- end content container -->

<?php get_footer(); ?>