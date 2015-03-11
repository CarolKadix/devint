
jQuery(document).ready(function($){
	
	$('#box_fornecedor_tipo input[name=fornecedor_tipo]').each(function(){
		if( $(this).is(':checked') ){
			check_supplier_options( $(this) );
		}
	});
	
	$('#box_fornecedor_tipo input[name=fornecedor_tipo]').on('change', function(){
		check_supplier_options( $(this) );
	});
	
	function check_supplier_options( obj ){
		if( obj.val() == 'comum' ){
			$('#supplier_info_box_inner .destacado').hide();
		}
		else{
			$('#supplier_info_box_inner .destacado').show();
		}
	}
	
});
