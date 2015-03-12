<?php
/*
 * Template Name: FAQ
 *
 */

 get_header(); ?>

<?php get_template_part('template-part', 'top-pages'); ?>

<!-- start content container -->
<div class="container">


<div class="row dmbs-faq">

     <div class="col-md-4">
       categorias
    </div>
 
    
    <div class="col-md-8">
    <?php // theloop
        if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

           <h2> <?php the_subtitle(); ?></h2>          
            <?php the_content(); ?>            

        <?php endwhile; ?>
        <?php else: ?>
            <?php get_404_template(); ?>
        <?php endif; ?>

    </div>

    
</div>
<!-- end content container -->
</div>
<?php get_footer(); ?>
