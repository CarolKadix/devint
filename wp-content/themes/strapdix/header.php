<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="description" content="<?php echo esc_attr(get_bloginfo('description')); ?>" />
    
  
    <title><?php wp_title( '&#124;', true, 'right' ); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800,300' rel='stylesheet' type='text/css'>

        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">  

        <!-- FONT AWESOME CDN: <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/hover-min.css" rel="stylesheet" media="all">

    <?php wp_head(); ?>
     
     <!-- Go to www.addthis.com/dashboard to customize your tools -->
     <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54f749c07ede55a1" async="async"></script>


</head>
<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">


<?php global $dm_settings; ?>

<?php get_template_part('template-part', 'topnav'); ?>

