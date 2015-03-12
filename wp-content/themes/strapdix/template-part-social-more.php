

  <p class="social-short">
    <a href="#" class="btn azm-social azm-btn azm-border-bottom azm-facebook"><i class="fa fa-facebook"></i> Facebook</a>
    <a href="#" class="btn azm-social azm-btn azm-border-bottom azm-twitter"><i class="fa fa-twitter"></i> Twitter</a>
    <a href="#" class="btn azm-social azm-btn azm-border-bottom azm-google-plus"><i class="fa fa-google-plus"></i> Google+</a>
    <span class="right">LINK <a href="<?php fts_show_shorturl($post); ?>" class="urlshort" >
      <?php fts_show_shorturl($post); ?></a>
      </span>
  </p>

<!-- Leia também -->
<div id="related">
 <h3>Leia também</h3>  
    <?php $orig_post = $post;
        global $post;
        $tags = wp_get_post_tags($post->ID);
 
        if ($tags) {
            $tag_ids = array();
        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
            $args=array(
                'tag__in' => $tag_ids,
                'post__not_in' => array($post->ID),
                'posts_per_page'=>3, // Number of related posts to display.
                'caller_get_posts'=>1
            );
 
            $my_query = new wp_query( $args ); 
            while( $my_query->have_posts() ) {
                $my_query->the_post();
            ?>
      
            <div class="col-md-4 box">	       
                <div class="content">
    		        <h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> <?php the_title();?></a></h4>      
    	        </div>
                  <a href="#" class="hvr-reveal">         	        
                    <span class="overlay"></span>
    	            <?php if ( has_post_thumbnail()) : ?>                              
    	            <?php the_post_thumbnail('relacionados'); ?>
    	            <?php endif; ?> 
                    </a>	           
            </div>
 
                <?php }
                }
                $post = $orig_post;
                wp_reset_query();
                ?>
    </div>