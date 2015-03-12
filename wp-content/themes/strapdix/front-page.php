<?php
/**
 * Template Name: Front Page
 *
 */
 get_header(); ?>

    <div class="container">
       
            <div id="myCarousel" class="carousel slide row">                
                <div class="carousel-inner">

                 <!-- PRIMEIRO DESTAQUE -->
                 <?php $the_query = new WP_Query( array(
                   'post_type' => 'post',
                   'category_name' => 'destaque',
                   'orderby' => 'date',
                   'order' => 'DESC',
                   'posts_per_page' => '1'));
                    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>  
                   
                    <div class="box col-md-6">
	                    <div class="item">
	                        <div class="content">
                               <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h2>
                               <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_subtitle(); ?></a></h3>
                          </div>                          
                                                           
                                  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                 <span class="overlay"></span>                                 
                                  <?php if ( has_post_thumbnail()) : ?>
                                  <?php the_post_thumbnail( 'destaque-first', array( 'class' => 'zoom-p' ) ); ?>
                                  <?php endif; ?> 
                                </a>
	                    </div>

	                </div>
	                 <?php endwhile;
                     wp_reset_postdata();?> 

                     <!-- SEGUNDO E TERCEIRO DESTAQUES -->
                        <?php $the_query = new WP_Query( array(
                        'post_type' => 'post',
                        'category_name' => 'destaque',
                        'offset'=> '1',
                        'order' => 'DESC',
                        'posts_per_page' => '2'));
                        while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

			            <div class="box col-md-6">
			                <div class="row">
			                      <div class="content">
			                         <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h2>
	                             <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_subtitle(); ?></a></h3>
			                    </div>		
			                     
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                 <span class="overlay"></span>                                 
	                                <?php if ( has_post_thumbnail()) : ?>
	                                <?php the_post_thumbnail( 'destaques', array( 'class' => 'zoom-p' ) ); ?>
	                                <?php endif; ?> 
                                </a>
			                </div>
			            </div><!--/ .col-md-5 -->
			            <?php endwhile;
	                    wp_reset_postdata();?>                  
                </div>	<!--/ INNER -->        
           </div>         
        </div><!--/ Carousel End --> 

      <div class="container"> 
        <!-- NEWSLETTER--> 
	    <?php get_template_part('template-part', 'newsletter'); ?>
      </div>
		 
		  <div class="container"> 
      <!-- ABAS--> 
		  <?php get_template_part('template-part', 'abas'); ?>	
      </div>	   
		

      <div class="container">  
      <!-- NEWSLETTER--> 
	    <?php get_template_part('template-part', 'newsletter'); ?>
      </div>

<?php get_footer(); ?>


