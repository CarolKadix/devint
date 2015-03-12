<div class="dmbs-header navbar-fixed-top">
  <div class="container">

	    <div class="col-md-4">
   
	       <?php if (is_search() )
	       echo '<h2 class="page-header">Busca</h2>';?>
           
           <?php if (is_category('publicacoes') )
	       echo '<h2 class="page-header">Publicações</h2>';?>

	       <?php if (is_category('makup') )
	       echo '<h2 class="page-header">Teste</h2>';?>	    </div> 

	    <!-- NEWSLETTER-->  
	    <div id="news" class="col-md-8 no-padding-right">

			<div class="col-md-5 no-padding-right">
			  <p>Cadastre-se gratuitamente e receba as melhores dicas e atualizações</p>
			</div> 

			<div class="col-md-5 no-padding">  					
				<input type="text" class="envelope form-control"  name="s" id="s" placeholder="E-mail..."/></span>  
			</div>

			<div class="col-md-2">
				     <a class="btn btn-warning btn-lg">Cadastrar</a> 
			</div>
		</div>  
	 
  </div>
</div> 
  
