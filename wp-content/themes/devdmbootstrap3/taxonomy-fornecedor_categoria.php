<?php 

/**
 * Template Name: Lista de Fornecedores
 *
 */

get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<?php get_template_part('template-part', 'topnav'); ?>


<!-- start content container -->
<div class="container dmbs-fornecedores">
	<div class="col-md-12">
		<?php  devint_fornecedores_list(); ?>        
	</div>
</div>
</div>
<!-- end content container -->
<?php get_footer(); ?>
