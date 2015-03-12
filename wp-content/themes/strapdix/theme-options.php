<?php

/**
 * Theme Options
 *
 *
 * @file           theme-options.php
 * @package        strapdix
 * @author         Carolina Kadix 
 * @copyright      2005 - 2015 Kadix
  */

/**
 * A safe way of adding JavaScripts to a WordPress generated page.
 */
function strapdix_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style('strapdix-theme-options', get_template_directory_uri() . '/options/theme-options.css', false, '1.0');
	wp_enqueue_script('strapdix-theme-options', get_template_directory_uri() . '/options/theme-options.js', array('jquery'), '1.0');
}
add_action('admin_print_styles-appearance_page_theme_options', 'strapdix_admin_enqueue_scripts');

/**
 * Init plugin options to white list our options
 */
function strapdix_theme_options_init() {
    register_setting('strapdix_options', 'strapdix_theme_options', 'strapdix_theme_options_validate');
}

/**
 * Load up the menu page
 */
function strapdix_theme_options_add_page() {
    add_theme_page(__('Theme Options', 'strapdix'), __('Theme Options', 'strapdix'), 'edit_theme_options', 'theme_options', 'strapdix_theme_options_do_page');
}

/**
 * Site Verification and Webmaster Tools
 * If user sets the code we're going to display meta verification
 * And if left blank let's not display anything at all in case there is a plugin that does this
 */
 
function strapdix_google_verification() {
    global $strapdix_options;
    if (!empty($strapdix_options['google_site_verification'])) {
		echo '<meta name="google-site-verification" content="' . $strapdix_options['google_site_verification'] . '" />' . "\n";
	}
}

add_action('wp_head', 'strapdix_google_verification');

function strapdix_bing_verification() {
    global $strapdix_options;
    if (!empty($strapdix_options['bing_site_verification'])) {
        echo '<meta name="msvalidate.01" content="' . $strapdix_options['bing_site_verification'] . '" />' . "\n";
	}
}

add_action('wp_head', 'strapdix_bing_verification');

function strapdix_yahoo_verification() {
    global $strapdix_options;
    if (!empty($strapdix_options['yahoo_site_verification'])) {
        echo '<meta name="y_key" content="' . $strapdix_options['yahoo_site_verification'] . '" />' . "\n";
	}
}

add_action('wp_head', 'strapdix_yahoo_verification');

function strapdix_site_statistics_tracker() {
    global $strapdix_options;
    if (!empty($strapdix_options['site_statistics_tracker'])) {
        echo $strapdix_options['site_statistics_tracker'];
	}
}

add_action('wp_head', 'strapdix_site_statistics_tracker');


	
/**
 * Create the options page
 */
function strapdix_theme_options_do_page() {

	if (!isset($_REQUEST['settings-updated']))
		$_REQUEST['settings-updated'] = false;
	?>
    
    <div class="wrap">
        <?php
        /**
         * < 3.4 Backward Compatibility
         */
        ?>
        <?php $theme_name = function_exists('wp_get_theme') ? wp_get_theme() : get_current_theme(); ?>
        <?php screen_icon(); echo "<h2>" . $theme_name ." ". __('Theme Options', 'strapdix') . "</h2>"; ?>
        

		<?php if (false !== $_REQUEST['settings-updated']) : ?>
		<div class="updated fade"><p><strong><?php _e('Options Saved', 'strapdix'); ?></strong></p></div>
		<?php endif; ?>
        
        <?php strapdix_theme_options(); // Theme Options Hook ?>
        
        <form method="post" action="options.php">
            <?php settings_fields('strapdix_options'); ?>
            <?php global $strapdix_options; ?>
            
            <div id="rwd" class="grid col-940">

            

            <h3 class="rwd-toggle"><a href="#"><?php _e('Logo Upload', 'strapdix'); ?></a></h3>
            <div class="rwd-container">
                <div class="rwd-block">
                <?php
                /**
                 * Logo Upload
                 */
                ?>
                <div class="grid col-300"><?php _e('Custom Header', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        
                        <p><?php printf(__('Need to replace or remove default logo?','strapdix')); ?> <?php printf(__('<a href="%s">Click here</a>.', 'strapdix'), admin_url('themes.php?page=custom-header')); ?></p>
                     			
                    </div><!-- end of .grid col-620 -->
                    
                </div><!-- end of .rwd-block -->
            </div><!-- end of .rwd-container -->
                        
         

            <h3 class="rwd-toggle"><a href="#"><?php _e('Social Icons', 'strapdix'); ?></a></h3>
            <div class="rwd-container">
                <div class="rwd-block"> 
                            
                <?php
                /**
                 * Social Media
                 */
                ?>

               <div class="grid col-300"><?php _e('Contato', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[contato_uid]" class="regular-text" type="text" name="strapdix_theme_options[contato_uid]" value="<?php if (!empty($strapdix_options['contato_uid'])) echo esc_url($strapdix_options['contato_uid']); ?>" />
                        <label class="description" for="strapdix_theme_options[contato_uid]"><?php _e('Enter your contato URL', 'strapdix'); ?></label>
                    </div><!-- end of .grid col-620 -->


                <div class="grid col-300"><?php _e('Twitter', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[twitter_uid]" class="regular-text" type="text" name="strapdix_theme_options[twitter_uid]" value="<?php if (!empty($strapdix_options['twitter_uid'])) echo esc_url($strapdix_options['twitter_uid']); ?>" />
                        <label class="description" for="strapdix_theme_options[twitter_uid]"><?php _e('Enter your Twitter URL', 'strapdix'); ?></label>
                    </div><!-- end of .grid col-620 -->

                <div class="grid col-300"><?php _e('Facebook', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[facebook_uid]" class="regular-text" type="text" name="strapdix_theme_options[facebook_uid]" value="<?php if (!empty($strapdix_options['facebook_uid'])) echo esc_url($strapdix_options['facebook_uid']); ?>" />
                        <label class="description" for="strapdix_theme_options[facebook_uid]"><?php _e('Enter your Facebook URL', 'strapdix'); ?></label>
                    </div><!-- end of .grid col-620 -->

                   <div class="grid col-300"><?php _e('rss', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[rss_uid]" class="regular-text" type="text" name="strapdix_theme_options[rss_uid]" value="<?php if (!empty($strapdix_options['rss_uid'])) echo esc_url($strapdix_options['rss_uid']); ?>" />
                        <label class="description" for="strapdix_theme_options[rss_uid]"><?php _e('Enter your rss URL', 'strapdix'); ?></label>
                    </div><!-- end of .grid col-620 -->              


                <div class="grid col-300"><?php _e('LinkedIn', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[linkedin_uid]" class="regular-text" type="text" name="strapdix_theme_options[linkedin_uid]" value="<?php if (!empty($strapdix_options['linkedin_uid'])) echo esc_url($strapdix_options['linkedin_uid']); ?>" /> 
                        <label class="description" for="strapdix_theme_options[linkedin_uid]"><?php _e('Enter your LinkedIn URL', 'strapdix'); ?></label>
                    </div><!-- end of .grid col-620 -->
                    
                <div class="grid col-300"><?php _e('YouTube', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[youtube_uid]" class="regular-text" type="text" name="strapdix_theme_options[youtube_uid]" value="<?php if (!empty($strapdix_options['youtube_uid'])) echo esc_url($strapdix_options['youtube_uid']); ?>" /> 
                        <label class="description" for="strapdix_theme_options[youtube_uid]"><?php _e('Enter your YouTube URL', 'strapdix'); ?></label>
                    </div><!-- end of .grid col-620 -->
                    
                <div class="grid col-300"><?php _e('StumbleUpon', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[stumble_uid]" class="regular-text" type="text" name="strapdix_theme_options[stumble_uid]" value="<?php if (!empty($strapdix_options['stumble_uid'])) echo esc_url($strapdix_options['stumble_uid']); ?>" /> 
                        <label class="description" for="strapdix_theme_options[youtube_uid]"><?php _e('Enter your StumbleUpon URL', 'strapdix'); ?></label>
                    </div><!-- end of .grid col-620 -->                  
              
                
                <div class="grid col-300"><?php _e('Google+', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[google_plus_uid]" class="regular-text" type="text" name="strapdix_theme_options[google_plus_uid]" value="<?php if (!empty($strapdix_options['google_plus_uid'])) echo esc_url($strapdix_options['google_plus_uid']); ?>" />  
                        <label class="description" for="strapdix_theme_options[google_plus_uid]"><?php _e('Enter your Google+ URL', 'strapdix'); ?></label>
                    </div><!-- end of .grid col-620 -->
                    
                <div class="grid col-300"><?php _e('Instagram', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[instagram_uid]" class="regular-text" type="text" name="strapdix_theme_options[instagram_uid]" value="<?php if (!empty($strapdix_options['instagram_uid'])) echo esc_url($strapdix_options['instagram_uid']); ?>" />  
                        <label class="description" for="strapdix_theme_options[instagram_uid]"><?php _e('Enter your Instagram URL', 'strapdix'); ?></label>
                    </div><!-- end of .grid col-620 -->
                    
                <div class="grid col-300"><?php _e('Pinterest', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[pinterest_uid]" class="regular-text" type="text" name="strapdix_theme_options[pinterest_uid]" value="<?php if (!empty($strapdix_options['pinterest_uid'])) echo esc_url($strapdix_options['pinterest_uid']); ?>" />  
                        <label class="description" for="strapdix_theme_options[pinterest_uid]"><?php _e('Enter your Pinterest URL', 'strapdix'); ?></label>
                    </div><!-- end of .grid col-620 -->
                    
                <div class="grid col-300"><?php _e('Yelp!', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[yelp_uid]" class="regular-text" type="text" name="strapdix_theme_options[yelp_uid]" value="<?php if (!empty($strapdix_options['yelp_uid'])) echo esc_url($strapdix_options['yelp_uid']); ?>" />  
                        <label class="description" for="strapdix_theme_options[yelp_uid]"><?php _e('Enter your Yelp! URL', 'strapdix'); ?></label>
                    </div><!-- end of .grid col-620 -->
                    
                <div class="grid col-300"><?php _e('Vimeo', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[vimeo_uid]" class="regular-text" type="text" name="strapdix_theme_options[vimeo_uid]" value="<?php if (!empty($strapdix_options['vimeo_uid'])) echo esc_url($strapdix_options['vimeo_uid']); ?>" />  
                        <label class="description" for="strapdix_theme_options[vimeo_uid]"><?php _e('Enter your Vimeo URL', 'strapdix'); ?></label>
                    </div><!-- end of .grid col-620 -->
                    
                <div class="grid col-300"><?php _e('foursquare', 'strapdix'); ?></div><!-- end of .grid col-300 -->
                    <div class="grid col-620 fit">
                        <input id="strapdix_theme_options[foursquare_uid]" class="regular-text" type="text" name="strapdix_theme_options[foursquare_uid]" value="<?php if (!empty($strapdix_options['foursquare_uid'])) echo esc_url($strapdix_options['foursquare_uid']); ?>" />  
                        <label class="description" for="strapdix_theme_options[foursquare_uid]"><?php _e('Enter your foursquare URL', 'strapdix'); ?></label>
                        <p class="submit">
						<?php submit_button( __( 'Save Options', 'strapdix' ), 'primary', 'strapdix_theme_options[submit]', false ); ?>
						<?php submit_button( __( 'Restore Defaults', 'strapdix' ), 'secondary', 'strapdix_theme_options[reset]', false ); ?>
                        </p>
                    </div><!-- end of .grid col-620 -->
                </div><!-- end of .rwd-block -->
            </div><!-- end of .rwd-container -->
            
          <div class="grid col-620 fit">
                        
                        <p class="submit">
                        <?php submit_button( __( 'Save Options', 'strapdix' ), 'primary', 'strapdix_theme_options[submit]', false ); ?>
                        <?php submit_button( __( 'Restore Defaults', 'strapdix' ), 'secondary', 'strapdix_theme_options[reset]', false ); ?>
                        </p>
                    </div><!-- end of .grid col-620 -->
          

            </div><!-- end of .grid col-940 -->
        </form>
    </div>
    <?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function strapdix_theme_options_validate($input) {

	global $strapdix_options;
	$defaults = strapdix_get_option_defaults();

	if ( isset( $input['reset'] ) ) {

		$input = $defaults;

	} else {

		// checkbox value is either 0 or 1
		foreach (array(		
			'front_page'
			) as $checkbox) {
			if (!isset($input[$checkbox]))
				$input[$checkbox] = null;
				$input[$checkbox] = ( $input[$checkbox] == 1 ? 1 : 0 );
		}		
		
	    $input['contato_uid'] = esc_url_raw($input['contato_uid']);
		$input['twitter_uid'] = esc_url_raw($input['twitter_uid']);
		$input['facebook_uid'] = esc_url_raw($input['facebook_uid']);
        $input['rss_uid'] = esc_url_raw($input['rss_uid']);
		$input['linkedin_uid'] = esc_url_raw($input['linkedin_uid']);
		$input['youtube_uid'] = esc_url_raw($input['youtube_uid']);
		$input['stumble_uid'] = esc_url_raw($input['stumble_uid']);		
		$input['google_plus_uid'] = esc_url_raw($input['google_plus_uid']);
		$input['instagram_uid'] = esc_url_raw($input['instagram_uid']);
		$input['pinterest_uid'] = esc_url_raw($input['pinterest_uid']);
		$input['yelp_uid'] = esc_url_raw($input['yelp_uid']);
		$input['vimeo_uid'] = esc_url_raw($input['vimeo_uid']);
		$input['foursquare_uid'] = esc_url_raw($input['foursquare_uid']);		
	}
	
    return $input;
}

/////////////////////////////////////////////////////////////////////
// Add DevDm Theme Options to the Appearance Menu and Admin Bar
////////////////////////////////////////////////////////////////////

    function dmbs_theme_options_menu() {
        add_theme_page( 'DevDm Theme' . __('Options','strapdix'), 'Opções do ' . __('Tema','strapdix'), 'manage_options', 'devdm-theme-options', 'devdm_theme_options' );
    }
    add_action( 'admin_menu', 'dmbs_theme_options_menu' );

    add_action( 'admin_bar_menu', 'toolbar_link_to_dmbs_options', 999 );

    function toolbar_link_to_dmbs_options( $wp_admin_bar ) {
        $args = array(
            'id'    => 'devdm_theme_options',
            'title' => __('Opções do Tema','strapdix'),
            'href'  => home_url() . '/wp-admin/themes.php?page=devdm-theme-options',
            'meta'  => array( 'class' => 'devdm-theme-options' ),
            'parent' => 'site-name'
        );
        $wp_admin_bar->add_node( $args );
    }

////////////////////////////////////////////////////////////////////
// Add admin.css enqueue
////////////////////////////////////////////////////////////////////

    function devdm_theme_style() {
        wp_enqueue_style('devdm-theme', get_template_directory_uri() . '/css/admin.css');
    }
    add_action('admin_enqueue_scripts', 'devdm_theme_style');

////////////////////////////////////////////////////////////////////
// Custom background theme support
////////////////////////////////////////////////////////////////////

    $defaults = array(
        'default-color'          => '',
        'default-image'          => '',
        'wp-head-callback'       => '_custom_background_cb',
        'admin-head-callback'    => '',
        'admin-preview-callback' => ''
    );
    add_theme_support( 'custom-background', $defaults );

////////////////////////////////////////////////////////////////////
// Custom header theme support
////////////////////////////////////////////////////////////////////

    register_default_headers( array(
        'wheel' => array(
            'url' => '%s/img/deafaultlogo.png',
            'thumbnail_url' => '%s/img/deafaultlogo.png',
            'description' => __( 'Your Business Name', 'devdmbootstrap' )
        ))

    );

    $defaults = array(
        'default-image'          => get_template_directory_uri() . '/img/deafaultlogo.png',
        'width'                  => 300,
        'height'                 => 100,
        'flex-height'            => true,
        'flex-width'             => true,
        'default-text-color'     => '000',
        'header-text'            => true,
        'uploads'                => true,
        'wp-head-callback'       => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => 'devdm_admin_header_image',
    );
    add_theme_support( 'custom-header', $defaults );

    function devdm_admin_header_image() { ?>

        <div id="headimg">
            <?php
            $color = get_header_textcolor();
            $image = get_header_image();

            if ( $color && $color != 'blank' ) :
                $style = ' style="color:#' . $color . '"';
            else :
                $style = ' style="display:none"';
            endif;
            ?>


            <?php if ( $image ) : ?>
                <img src="<?php echo esc_url( $image ); ?>" alt="" />
            <?php endif; ?>
            <div class="dm_header_name_desc">
            <h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
            <div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>

            </div>
        </div>

    <?php }

    function custom_header_text_color () {
        if ( get_header_textcolor() != 'blank' ) { ?>
            <style>
               .custom-header-text-color { color: #<?php echo get_header_textcolor(); ?> }
            </style>
    <?php }
    }

    add_action ('wp_head', 'custom_header_text_color');

////////////////////////////////////////////////////////////////////
// Register our settings options (the options we want to use)
////////////////////////////////////////////////////////////////////

    $dm_options = array(
        'author_credits' => true,
        'right_sidebar' => true,
        'right_sidebar_width' => 3,
        'left_sidebar' => false,
        'left_sidebar_width' => 3,
        'footer_sidebar' => true,
        'footer_sidebar_width' => 5,
        'show_header' => true,
        'show_postmeta' => true
    );

    $dm_sidebar_sizes = array(
        '1' => array (
            'value' => '1',
            'label' => '1'
        ),
        '2' => array (
            'value' => '2',
            'label' => '2'
        ),
        '3' => array (
            'value' => '3',
            'label' => '3'
        ),
        '4' => array (
            'value' => '4',
            'label' => '4'
        ),
        '5' => array (
            'value' => '5',
            'label' => '5'
        )

    );

    function dm_register_settings() {
        register_setting( 'dm_theme_options', 'dm_options', 'dm_validate_options' );
    }

    add_action ('admin_init', 'dm_register_settings');
    $dm_settings = get_option( 'dm_options', $dm_options );


////////////////////////////////////////////////////////////////////
// Validate Options
////////////////////////////////////////////////////////////////////

    function dm_validate_options( $input ) {

        global $dm_options, $dm_sidebar_sizes;

        $settings = get_option( 'dm_options', $dm_options );

        $prev = $settings['right_sidebar_width'];
        if ( !array_key_exists( $input['right_sidebar_width'], $dm_sidebar_sizes ) ) {
            $input['right_sidebar_width'] = $prev;
        }

        $prev = $settings['left_sidebar_width'];
        if ( !array_key_exists( $input['left_sidebar_width'], $dm_sidebar_sizes ) ) {
            $input['left_sidebar_width'] = $prev;
        }

        if ( ! isset( $input['author_credits'] ) ) {
            $input['author_credits'] = null;
        } else {
            $input['author_credits'] = ( $input['author_credits'] == 1 ? 1 : 0 );
        }

        if ( ! isset( $input['show_header'] ) ) {
            $input['show_header'] = null;
        } else {
            $input['show_header'] = ( $input['show_header'] == 1 ? 1 : 0 );
        }

        if ( ! isset( $input['right_sidebar'] ) ) {
            $input['right_sidebar'] = null;
        } else {
            $input['right_sidebar'] = ( $input['right_sidebar'] == 1 ? 1 : 0 );
        }

        if ( ! isset( $input['left_sidebar'] ) ) {
            $input['left_sidebar'] = null;
        } else {
            $input['left_sidebar'] = ( $input['left_sidebar'] == 1 ? 1 : 0 );
        }

         if ( ! isset( $input['footer_sidebar'] ) ) {
            $input['footer_sidebar'] = null;
        } else {
            $input['footer_sidebar'] = ( $input['footer_sidebar'] == 1 ? 1 : 0 );
        }




        if ( ! isset( $input['show_postmeta'] ) ) {
            $input['show_postmeta'] = null;
        } else {
            $input['show_postmeta'] = ( $input['show_postmeta'] == 1 ? 1 : 0 );
        }

        return $input;
    }

////////////////////////////////////////////////////////////////////
// Display Options Page
////////////////////////////////////////////////////////////////////

    function devdm_theme_options() {

    if ( !current_user_can( 'manage_options' ) )  {
        wp_die('You do not have sufficient permissions to access this page.');
    }

        //get our global options
        global $dm_options, $dm_sidebar_sizes, $developer_uri;

        //get our logo
        $logo = get_template_directory_uri() . '/img/logo.png'; ?>

        <div class="wrap">

        <div class="dm-logo-wrap"><a href="<?php echo $developer_uri ?>" target="_blank"><img src="<?php echo $logo; ?>" class="dm-logo" title="Created by Kadix @ DevDm.com" /></a></div>

            <div class="icon32" id="icon-options-general"></div>

            <h2><a href="<?php echo $developer_uri ?>" target="_blank">strapdix</a></h2>

               <?php

               if ( ! isset( $_REQUEST['settings-updated'] ) )

                   $_REQUEST['settings-updated'] = false;

               ?>

               <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>

               <div class='saved'><p><strong><?php _e('Options Saved!','strapdix') ;?></strong></p></div>

               <?php endif; ?>

            <form action="options.php" method="post">

                <?php
                    $settings = get_option( 'dm_options', $dm_options );
                    settings_fields( 'dm_theme_options' );
                ?>

                <table cellpadding='10'>

                    <tr valign="top"><th scope="row"><?php _e('Right Sidebar','strapdix') ;?></th>
                        <td>
                            <input type="checkbox" id="right_sidebar" name="dm_options[right_sidebar]" value="1" <?php checked( true, $settings['right_sidebar'] ); ?> />
                            <label for="right_sidebar"><?php _e('Show the Right Sidebar','strapdix') ;?></label>
                        </td>
                    </tr>

                    <tr valign="top"><th scope="row"><?php _e('Right Sidebar Size','strapdix') ;?></th>
                        <td>
                    <?php foreach( $dm_sidebar_sizes as $sizes ) : ?>
                        <input type="radio" id="<?php echo $sizes['value']; ?>" name="dm_options[right_sidebar_width]" value="<?php echo esc_attr($sizes['value']); ?>" <?php checked( $settings['right_sidebar_width'], $sizes['value'] ); ?> />
                        <label for="<?php echo $sizes['value']; ?>"><?php echo $sizes['label']; ?></label><br />
                    <?php endforeach; ?>
                        </td>
                    </tr>

                    <tr valign="top"><th scope="row"><?php _e('Left Side Bar','strapdix') ;?></th>
                        <td>
                            <input type="checkbox" id="left_sidebar" name="dm_options[left_sidebar]" value="1" <?php checked( true, $settings['left_sidebar'] ); ?> />
                            <label for="left_sidebar"><?php _e('Show the Left Sidebar','strapdix') ;?></label>
                        </td>
                    </tr>

                    <tr valign="top"><th scope="row"><?php _e('Left Sidebar Size','strapdix') ;?></th>
                        <td>
                            <?php foreach( $dm_sidebar_sizes as $sizes ) : ?>
                                <input type="radio" id="<?php echo $sizes['value']; ?>" name="dm_options[left_sidebar_width]" value="<?php echo esc_attr($sizes['value']); ?>" <?php checked( $settings['left_sidebar_width'], $sizes['value'] ); ?> />
                                <label for="<?php echo $sizes['value']; ?>"><?php echo $sizes['label']; ?></label><br />
                            <?php endforeach; ?>
                        </td>
                    </tr>

                    <tr valign="top"><th scope="row"><?php _e('Footer SideBar','strapdix') ;?></th>
                        <td>
                            <input type="checkbox" id="footer_sidebar" name="dm_options[footer_sidebar]" value="1" <?php checked( true, $settings['footer_sidebar'] ); ?> />
                            <label for="footer_sidebar"><?php _e('Show the footer Sidebar','strapdix') ;?></label>
                        </td>
                    </tr>

                    <tr valign="top"><th scope="row"><?php _e('Footer Sidebar Size','strapdix') ;?></th>
                        <td>
                            <?php foreach( $dm_sidebar_sizes as $sizes ) : ?>
                                <input type="radio" id="<?php echo $sizes['value']; ?>" name="dm_options[footer_sidebar_width]" value="<?php echo esc_attr($sizes['value']); ?>" <?php checked( $settings['footer_sidebar_width'], $sizes['value'] ); ?> />
                                <label for="<?php echo $sizes['value']; ?>"><?php echo $sizes['label']; ?></label><br />
                            <?php endforeach; ?>
                        </td>
                    </tr>





                    <tr valign="top"><th scope="row"><?php _e('Show Header','strapdix') ;?></th>
                        <td>
                            <input type="checkbox" id="show_header" name="dm_options[show_header]" value="1" <?php checked( true, $settings['show_header'] ); ?> />
                            <label for="show_header"><?php _e('Show The Main Header in the Template (logo/sitename/etc.)','strapdix') ;?></label>
                        </td>
                    </tr>

                    <tr valign="top"><th scope="row"><?php _e('Show Post Meta','strapdix') ;?></th>
                        <td>
                            <input type="checkbox" id="show_postmeta" name="dm_options[show_postmeta]" value="1" <?php checked( true, $settings['show_postmeta'] ); ?> />
                            <label for="show_postmeta"><?php _e('Show Post Meta data (author, category, date created)','strapdix') ;?></label>
                        </td>
                    </tr>

                    <tr valign="top"><th scope="row"><?php _e('Give Kadix His Credit?','strapdix') ;?></th>
                        <td>
                            <input type="checkbox" id="author_credits" name="dm_options[author_credits]" value="1" <?php checked( true, $settings['author_credits'] ); ?> />
                            <label for="author_credits"><?php _e('Show me some love and keep a link to Kadix.com.br in your footer.','strapdix') ;?></label>
                        </td>
                    </tr>

                </table>

                <p class="submit">
                    <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes','strapdix'); ?>" />
                </p>

            </form>

        </div>
<?php

}
?>
