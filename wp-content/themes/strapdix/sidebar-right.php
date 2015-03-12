
     <div class="col-md-4 dmbs-right pull-right">
     <h3 class="pop"> Veja Também </h3>
        <hr/>

     <aside id="popular" class="col-md-12 no-padding widget">
          <h3>Publicações Mais Populares</h3>
          <div class="triangle"></div>
          <?php echo '<ol>';
                    $posts = wmp_get_popular( array( 'limit' => 5, 'post_type' => 'post', 'range' => 'all_time' ) );
                    global $post;
                    if ( count( $posts ) > 0 ): foreach ( $posts as $post ):
                        setup_postdata( $post );
                        ?>
                        
                        <li class="col-md-12 row-left">
                         <a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
                            <?php if ( get_the_title() ) the_title(); else the_ID(); ?></a> 
                        </li>

                        <span class="divider"></span>
                       

                        <?php
                          endforeach; endif;
                          echo '</ol>';
                        ?>
            </aside>
         

       <?php //get the right sidebar
        dynamic_sidebar( 'Right' ); ?>
    </div>
