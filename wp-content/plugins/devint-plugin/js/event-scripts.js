
jQuery(document).ready(function($){
	
	/**
	 * Dropdown table events: enviar para o mês escolhido
	 * 
	 */
	$('.table-events-dropdown').on('change', function(){
		window.top.location = $(this).val();
	});
	
	/**
	 * Dropdown list events: enviar para o ano escolhido
	 * 
	 */
	$('.month-events-dropdown').on('change', function(){
		window.top.location = $(this).val();
	});
	
	/**
	 * Mostrar popup ao clicar no evento
	 * 
	 */
	$('.event-btn-ovelay').on('click', function(){
		$('.event-popup').hide();
		$(this).closest('.single_event').find('.event-popup').fadeIn();
	});
	
	/**
	 * Botão de fechar popup
	 * 
	 */
	$('.event-btn-close').on('click', function(){
		$(this).closest('.single_event').find('.event-popup').hide();
	});
	
	/**
	 * Click outside popup
	 * @link http://stackoverflow.com/a/7385673
	 * 
	 */
	$(document).mouseup(function (e){
		var container = $('.event-popup');

		if (!container.is(e.target) // if the target of the click isn't the container...
			&& container.has(e.target).length === 0) // ... nor a descendant of the container
		{
			container.hide();
		}
	});
	
	/**
	 * Lista: abrir mês
	 * 
	 */
	$('.events-list-month-name').on('click', function(){
		var title = $(this);
		$(this).closest('.events-list-month').find('.event-list-items').stop().slideToggle(400, function(){
			if( $(this).is(':visible') ){
				title.addClass('opened');
			}
			else{
				title.removeClass('opened')
			}
		});
	});
	
	/**
	 * Lista: abrir evento individual
	 * 
	 */
	$('.event-list-item-title').on('click', function(){
		var title = $(this);
		var details = title.closest('.event-list-item').find('.event-list-item-details');
		var t = $('.dmbs-top-menu .navbar').height();
		var o = title.offset().top;
		var s = (o - t);
		//console.log(t);
		//console.log(o);
		//console.log(s);
		$('html, body').animate({
			scrollTop: s
		}, 400, 'swing', function(){
			// necessário verificação via 'data-' pois a function estava rodando duas vezes(abria e logo fechava)
			if( details.attr('data-run-toggle') == 0 ){
				details.attr('data-run-toggle', 1);
				if( details.is(':visible') ){
					details.slideUp(400, function(){
						title.removeClass('opened');
						details.attr('data-run-toggle', 0);
					});
				}
				else{
					details.slideDown(400, function(){
						title.addClass('opened');
						details.attr('data-run-toggle', 0);
					});
				}
			}
		});
	});
	
});
