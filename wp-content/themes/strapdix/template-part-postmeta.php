
   <div id="postmeta" >
    <li class="text-left">       
        <img src="<?php bloginfo('template_url'); ?>/img/time.png"><?php _e('Postado em','devdmbootstrap3'); ?> 
        <?php the_time('j \d\e F \d\e Y'); ?> 
      </li> 
    <li class="text-right"> 
      <img src="<?php bloginfo('template_url'); ?>/img/category.png"><?php the_category(' , '); ?>
    </li> 
  
</div>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
             <div id="addthis" class="addthis_native_toolbox"></div> 
              <div class="comentario-counter">                 
                <span><?php comments_number( '0', '1', '%' ); ?></span>comentários                       
              </div>