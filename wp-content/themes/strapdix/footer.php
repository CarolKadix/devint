 <div class="dmbs-footer">       

    <?php //footer sidebar ?>
    <?php get_sidebar( 'footer' ); ?>
    
        <div class="creditos">
          <div class="container">
           
            <div class="col-md-9 dmbs-author-credits left">             
                <?php $copyright_text = '&copy; ' . date( 'Y' ) . ' <a href="' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">' . esc_attr( get_bloginfo( 'name' ) ) . '</a>';?>
                <h6><?php bloginfo( 'description' ); ?></h6>
                               
            </div>  
                             
            <div id="social-icons-container" class="col-md-3 right no-padding">
                <ul>               
                <!--rss-->      <li><?php echo '<a class="btn btn-block btn-social btn-rss">     <img src="' . get_stylesheet_directory_uri() . '/img/icon-feed.png">'     . $strapdix_options['rss_uid']      . '</a>'; ?></li>
                <!--twitter-->  <li><?php echo '<a class="btn btn-block btn-social btn-twitter"> <img src="' . get_stylesheet_directory_uri() . '/img/icon-twitter.png">'  . $strapdix_options['twitter_uid']  . '</a>'; ?></li>
                <!--facebook--> <li><?php echo '<a class="btn btn-block btn-social btn-facebook"><img src="' . get_stylesheet_directory_uri() . '/img/icon-facebook.png">' . $strapdix_options['facebook_uid'] . '</a>'; ?></li>
                <!--contato-->  <li><?php echo '<a class="btn btn-block btn-social btn-envelope"><img src="' . get_stylesheet_directory_uri() . '/img/icon-email.png">'    . $strapdix_options['mail_uid']     . '</a>'; ?></li>
                </ul>              
            </div>
          </div>      
        </div>  

</div>
<?php wp_footer(); ?>
</body>
</html>
  





