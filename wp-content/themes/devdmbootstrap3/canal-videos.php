<?php 

/**
 * Template Name: Canal de Videos *
 */

get_header(); ?>

<div class="dmbs-header navbar-fixed-top">
  <div class="container">

      <div class="col-md-4">
         <h2 class="page-header">Canal de Videos</h2>
      </div> 

    <div class="col-md-8 row right">

       <div class="col-md-5 row">
         <p>Cadastre-se gratuitamente e receba as melhores dicas e atualizações</p>
      </div> 

      <!-- NEWSLETTER-->   
      <div class="col-md-5 row" id="news-form" >       
        <input type="text" class="field envelope form-control"  name="s" id="s" placeholder="E-mail..."/></span>  
      </div>

      <div class="col-md-3 row right">
        <a class="btn btn-warning btn-lg">Cadastrar</a> 
      </div>  
    </div>
   
</div>
</div> 
<?php get_template_part('template-part', 'topnav'); ?>

<div class="col-md-12 dmbs-tv">
    <div class="container">

                  <!-- PRIMEIRO DESTAQUE -->
                  <?php $the_query = new WP_Query( array(
                   'post_type' => 'post',
                   'category_name' => 'canal-videos',
                   'orderby' => 'date',
                   'order' => 'DESC',
                   'posts_per_page' => '1'));
                    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>  

                    <div class="col-md-7">
                       <?php if ( has_post_thumbnail()) : ?>                              
                       <?php the_post_thumbnail( 'single'); ?>
                       <?php endif; ?> 
                     </div>

                      <div class="col-md-5 right">
                        <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                         <?php get_template_part('template-part', 'postmeta'); ?>
                           <?php the_excerpt(); ?>                          
                      </div>

                       <?php endwhile;
                        wp_reset_postdata();?> 

           </div>
</div>



<?php get_footer(); ?>
