
 <div class="container">
  
        <div class="col-md-10 row">

                <div class="col-md-3 row">
                <h5>MeuSite</h5>
                <?php 
                    wp_nav_menu( array(
                            'theme_location'    => 'vivacorretor_menu',
                            'depth'             => 2,                            
                            'container'         => 'div',
                            'container_class'   => '',                          
                            'menu_class'        => 'dmbs-footer',
                            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                            'walker'            => new wp_bootstrap_navwalker())
                    );
                    ?>
                </div>

                <div class="col-md-3 texto dmbs-ajuste">
			        <div><h5>Contato</h5>
			        <p><a href="#">contato@site.com.br</a></p>
                    <p><a href="">www.site.com.br</a></p>
                    <p>Av Paulista, 1300 São Paulo / SP</p>
			        </div>   
			    </div> 

			    <div class="col-md-3">   
                <h5>Sobre</h5>
                 <?php
                    wp_nav_menu( array(
                            'theme_location'    => 'sobre_menu',
                            'depth'             => 2,
                            'container'         => 'div',
                            'container_class'   => '',
                            'menu_class'        => 'dmbs-footer',
                            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                            'walker'            => new wp_bootstrap_navwalker())
                    );
                    ?>
                </div>

                 <div class="col-md-3 texto-cinza">
                    <div><h5>Anuncie</h5>
                    <p class="cinza">O site não é uma imobiliária, mas você encontra várias delas aqui :)</p>
                    </div> 
                </div>    
        </div>         

                <!--/* SEARCH FORM */-->
                <div class="col-md-2 footer_search no-padding right">			
        			<h5> Pesquise no MeuSite</h5>
        			<form method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">   		
        	            <div class="icon-addon addon-lg">
        	                    <input type="text" placeholder="<?php _e( 'Busca', 'strapdix' ); ?>" class="form-control search" id="search">	                    
        	            </div>         
        	        </form>
                </div>
            


 
</div>
