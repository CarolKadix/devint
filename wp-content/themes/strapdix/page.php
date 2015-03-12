<?php get_header(); ?>

<?php get_template_part('template-part', 'top-pages'); ?>

<!-- start content container -->
<div class="container">
<div class="row dmbs-paginas">

<!-- GRUPO 1 DE BANNERS 970X90 -->
  <?php echo adrotate_group(1); ?>
    
    <div class="col-md-8">
        <?php // theloop
        if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

           <h2 class="subtitle"> <?php the_subtitle(); ?></h2>  

              <figure>            
              <?php if ( has_post_thumbnail()) : ?>                              
                <?php the_post_thumbnail('single'); ?>
              <?php endif; ?> 
              </figure>

            <?php the_content(); ?>

            <div class="follow">
               <h5>Nos siga nas Mídias Sociais</h5>

               <p class="social-short">
                <a href="#" class="btn azm-social azm-btn azm-border-bottom azm-facebook"><i class="fa fa-facebook"></i> Facebook</a>
                <a href="#" class="btn azm-social azm-btn azm-border-bottom azm-twitter"><i class="fa fa-twitter"></i> Twitter</a>
                <a href="#" class="btn azm-social azm-btn azm-border-bottom azm-google-plus"><i class="fa fa-google-plus"></i> Google+</a>           
               </p>

                <h5>Veja outras iniciativas</h5>
            </div>



        <?php endwhile; ?>
        <?php else: ?>
            <?php get_404_template(); ?>
        <?php endif; ?>

    </div>

    <?php //get the right sidebar ?>
    <?php get_sidebar( 'right' ); ?>

</div>
<!-- end content container -->
</div>
<?php get_footer(); ?>
