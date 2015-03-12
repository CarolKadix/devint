
<?php if ( has_nav_menu( 'main_menu' ) ) : ?>

    <div class="row dmbs-top-menu">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">

         <div class="container">

            <div class="col-md-8">
            <!-- LOGO UPLOAD PAINEL -->
                            <?php if ( get_header_image() != '' ) : ?>
                            <div class="col-md-3 no-paddding dmbs-header-img text-center">
                                <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" /></a></h1>              
                            </div>
                           
                           <?php endif; ?>  

            <div class="col-md-8">
               
                <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-1-collapse">
                                <span class="sr-only"><?php _e('Toggle navigation','strapdix'); ?></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                               
                </div>   

                        <?php
                        wp_nav_menu( array(
                                'theme_location'    => 'main_menu',
                                'depth'             => 2,
                                'container'         => 'div',
                                'container_class'   => 'col-md-9 collapse navbar-collapse navbar-1-collapse',
                                'menu_class'        => 'nav navbar-nav',
                                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                                'walker'            => new wp_bootstrap_navwalker())
                        );
                        ?> 
              </div>   

            </div>               
            

            
             
              <!-- segundo menu --> 
                  <?php
                 wp_nav_menu( array(
                        'theme_location'    => 'main2_menu',
                        'depth'             => 2,
                        'container'         => 'div',
                        'container_class'   => 'col-md-4 no-padding right menu2',
                        'menu_class'        => 'nav navbar-nav navbar-right',
                        'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                        'walker'            => new wp_bootstrap_navwalker())
                );
                ?>  
              
        </nav>
    </div> 
</div>

<?php endif; ?>