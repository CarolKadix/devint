<?php
/**
 * Template Name: Fornecedores
 *
 */
get_header(); ?>

<?php get_template_part('template-part', 'top-pages'); ?>

<!-- start content container -->
    <div class="container dmbs-fornecedores no-padding">
				<?php devint_fornecedores_list(); ?> 
    </div>
<!-- end content container -->
<?php get_footer(); ?>