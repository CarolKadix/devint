   
<div class="container dmbs-home"> 

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


                        <?php get_template_part('template-part', 'postmeta'); ?>

                         <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                         <?php echo excerpt1('17'); ?>  
                          <!-- Go to www.addthis.com/dashboard to customize your tools -->
                          <div class="addthis_native_toolbox"></div> <span class="comentario"><?php comments_number( '', '1', '% comentários' ); ?></span>                               
                                   
                        </li>                          
                         <?php endwhile;
                         wp_reset_postdata();?> 
                        </ul> 

                      <div class="col-md-3 row pull-right">
                          <a href="/category/publicacoes" class="btn btn-default">Ver mais</a> 
                      </div>  
              </div><!-- END RECENTS-->  



               <!-- START POPULAR-->  
                <div role="tabpanel" class="tab-pane fade" id="popular">

                <ul>
                <?php $query = new WP_Query( array (
                      'post_type' => 'post',
                      'category_name' => 'publicacoes', 
                      'meta_key' => 'post_views_count',
                      'orderby' => 'meta_value_num',   
                      'ignore_sticky_posts' => 1,
                      'posts_per_page' => '5'
                      ));                                   

                    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>               
                  
                    <li class="col-md-12 row-left"> 
                    
                        <figure class="col-md-5 row-left">                                                 
                             <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="hvr-reveal"><?php the_post_thumbnail(); ?></a> 
                                <?php endif; ?>                                     
                        </figure>
                        <?php get_template_part('template-part', 'postmeta'); ?>

                         <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                         <?php echo excerpt1('17'); ?>  
                          <!-- Go to www.addthis.com/dashboard to customize your tools -->
                          <div class="addthis_native_toolbox"></div> <span class="comentario"><?php comments_number( '', '1', '% comentários' ); ?></span>                               
                                         
                        </li>                          
                         <?php endwhile;
                         wp_reset_postdata();?> 
                        </ul> 

                      <div class="col-md-3 row pull-right">
                          <a href="/category/publicacoes" class="btn btn-default">Ver mais</a> 
                      </div>  
             
                </div><!-- END POPULAR-->
          </div><!--END TABCONTENT-->

  </div><!--END TABPANEL-->    
</div><!-- END ABAS-->


        <?php get_sidebar('home'); ?>

</div>