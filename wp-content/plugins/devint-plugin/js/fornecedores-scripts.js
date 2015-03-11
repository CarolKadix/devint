
jQuery(document).ready(function($){
	
	$(window).load(function(){
		if( $('#formulario').is('.show-modal') ){
			$('#myModal').modal('show');
		}
	});
	
	$('#myModal').on('hidden.bs.modal', function () {
		if( $('#myModal form').is('.form_success') ){
			window.location.href = $("link[rel='canonical']").attr('href');
		}
	})
	
});
