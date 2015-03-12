<?php
/**
* Template Name: Publicações
 *
 */
get_header(); ?>

<?php get_template_part('template-part', 'top-news'); ?>

<!-- start content container -->
<div class="container dmbs-publicacoes">

<!-- GRUPO 1 DE BANNERS 970X90 -->
  <?php echo adrotate_group(1); ?>

<!--<?php get_template_part('template-part', 'categorias'); ?>-->

<div id="abas" class="col-md-9 row">

  <!-- ABAS --> 
  <div role="tabpanel" class="col-md-12 row">

      <div class="tabbable-line">
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs mb30" role="tablist">
                        <li role="presentation" class="active "><a href="#recentes" aria-controls="active" role="tab" data-toggle="tab" class="hvr-underline-from-left">Publicações Mais Recentes</a></li>
                        <li role="presentation"><a href="#popular" aria-controls="popular" role="tab" data-toggle="tab" class="hvr-underline-from-left">Publicações Mais Populares</a></li>  
                      </ul>
      </div>
              
      <!-- Tab panes -->
      <div class="tab-content transitionEnd">  
      
      <!-- START RECENTS--> 
      <div role="tabpanel" class="tab-pane active" id="recentes">
          <ul>

        <?php $the_query = new WP_Query( array( 
                      'post_type' => 'post',
                      'category_name' => 'publicacoes',
                      'orderby' => 'date',      
                      'order' => 'DESC',
                      'posts_per_page' => '5')); // how many posts to show

                      while ( $the_query->have_posts() ) : $the_query->the_post(); ?>               
                  
                    <li class="col-md-12 row-left"> 
                    
                        <figure class="col-md-5 row-left">                                                 
                             <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="hvr-reveal"><?php the_post_thumbnail(); ?></a> 
                                <?php endif; ?>                                     
                        </figure>


                       <div class="data">
                          <img src="<?php bloginfo('template_url'); ?>/img/time.png">
                          <p><?php _e('Postado em','devdmbootstrap3'); ?> 
                          <?php the_time('j \d\e F \d\e Y'); ?><p>
                         </div>

                         <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                         <?php echo excerpt1('15'); ?>  
                          <!-- Go to www.addthis.com/dashboard to customize your tools -->
                          <div class="addthis_native_toolbox"></div> <span class="comentario"><?php comments_number( '', '1', '% comentários' ); ?></span>                               
                                                       
                        </li>                          
                         <?php endwhile;
                         wp_reset_postdata();?> 
                        </ul> 
                      <div class="col-md-3 row pull-right">
                       <?php wp_pagenavi(); ?>
                      </div>  
                    </div><!-- END RECENTS-->  



               <!-- START POPULAR-->  
                <div role="tabpanel" class="tab-pane fade" id="popular">
            
                <?php echo '<ul>';
                $posts = wmp_get_popular( array( 'limit' => 5, 'post_type' => 'post', 'range' => 'all_time' ) );
                global $post;
                if ( count( $posts ) > 0 ): foreach ( $posts as $post ):
                    setup_postdata( $post );
                    ?>
                    
                    <li class="col-md-12 row-left">                    
                  
                        <figure class="col-md-5 row-left">                                                 
                            <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="hvr-reveal"><?php the_post_thumbnail(); ?></a> 
                            <?php endif; ?>                                     
                        </figure>

                        <img src="<?php bloginfo('template_url'); ?>/img/time.png"><?php _e('Postado em','devdmbootstrap3'); ?> 
                        <?php the_time('j \d\e F \d\e Y'); ?> 

                        <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                        <?php echo excerpt1('15'); ?>  
                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                        <div class="addthis_native_toolbox"></div> <span class="comentario"><?php comments_number( '', '1', '% comentários' ); ?></span>                               
                              
                     </li>

                      <?php
                      endforeach; endif;
                      echo '</ul>';
                      ?>
                      <div class="col-md-3 leia-mais row right">
                     <?php wp_pagenavi(); ?>
                      </div> 

                </div><!-- END POPULAR-->                      


          </div><!--END TABCONTENT-->

  </div><!--END TABPANEL-->    
</div><!-- END ABAS-->


  <?php get_sidebar('publicacoes'); ?>

</div>

<!-- end content container -->

<?php get_footer(); ?>

