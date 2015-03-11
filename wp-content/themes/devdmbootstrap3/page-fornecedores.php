<?php 

/**
 * Template Name: Fornecedores
 *
 */

get_header(); ?>

<?php get_template_part('template-part', 'top-pages'); ?>

<!-- start content container -->
<div class="container">
<div class="row dmbs-content">

     <div class="col-md-4 row pull-right">
         categorias listar dinamicamente aqui
    </div>

    <div class="col-md-8 dmbs-paginas">

          <!-- FORNECEDORES EM DESTAQUE -->
          <?php $the_query = new WP_Query( array(
                   'post_type' => 'fornecedor',  
                   'order' => 'DESC',
                   'posts_per_page' => '6'));
                   ?> 

                    <?php if (get_field('tipo') == 'destacado'): ?>                        
                         <h2>Veja as condições exclusivas</h2>

                        <?php while ( $the_query->have_posts() ) : $the_query->the_post();  ?>
                         <p><?php the_field('texto_promocional');?></p>
                        
                            <?php $image = get_field('logo_fornecedor'); 
                               if( !empty($image) ): ?> 
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="logo" /> 
                             <?php endif; ?> 
                        
                       
                        <?php  endwhile;
                        wp_reset_postdata();
                        endif; ?> 


          <!-- FORNECEDORES COMUM -->
          <?php $the_query = new WP_Query( array(
                   'post_type' => 'fornecedor',  
                   'order' => 'DESC',
                   'posts_per_page' => '-1'));
                    while ( $the_query->have_posts() ) : $the_query->the_post(); ?> 

                     <?php if (get_field('tipo') == 'comum'): ?>

                         <h2>Veja mais fornecedores na categoria "puxar dinâmicamente categoria aqui" </h2>
                               
                            <div>
                            <h4><?php the_title();?></h4>
                            <p><?php $terms_as_text = get_the_term_list( $post->ID,'categoria');?> 
                             <?php the_field('estado');?></p>
                            <p><?php the_field('url_fornecedor_comum');?></p>
                            <p><?php the_field('telefone');?></p>
                            <p><?php the_field('url_fornecedor_destaque');?></p>                           
                        </div>  

                       <?php else : ?>

                        <h2> nenhum fornecedor </h2>
                        <?php endif; 
                           endwhile; 
                        wp_reset_postdata();?> 
    </div>
  

</div>
<!-- end content container -->
</div>
<?php get_footer(); ?>



 

    