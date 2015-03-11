
jQuery(document).ready(function($){
	
	/**
	 * Abas dos vídeos
	 * 
	 */
	if( $('#video-tabs-contents').length ){
		$('#video-tabs-contents .video-action').on('click', function(){
			var video = $(this).closest('.video-item');
			if( video.is('.playing') ){
				return;
			}
			var new_video = video.attr('data-video-src');
			if( new_video != '' ){
				$('#video-tabs-contents .video-item').removeClass('playing');
				video.addClass('playing');
				$('#video-large-embed iframe').attr( 'src', new_video );
				$('#video-large-title').text( video.find('h3').text() );
				$('#video-large-date').text( video.find('.video-date').text() );
				$('#video-large-category').text( video.attr('data-video-category') );
				$('#video-large-desc').html( video.find('.video-desc').html() );
			}
		});
	}
	
	
	/**
	 * Vídeo flutuante
	 * 
	 */
	// salvar medidas originais do vídeo
	var original_video_width = $('#column-video-large').width();
	var original_video_height = $('#column-video-large').height();
	$('#video-large-embed-inner').css('height', original_video_height);
	var video_animating = false;
	
	function video_position() {
		var adjust = 200;
		var menu1 = $('.dmbs-top-menu:first .navbar-fixed-top:first').outerHeight();
		var menu2 = $('.dmbs-header:first').outerHeight();
		var video_container = $('.dmbs-videos-featured:first').height();
		var limit = (menu1 + menu2 + video_container - adjust);
		console.log( 'menu1: ' + menu1 + ' | menu2: ' + menu2 + ' : ' + (menu1 + menu2));
		
		//console.log('scrollTop: ' + $(window).scrollTop() + ' <> ' + limit + ' limit');
		if( video_animating === true ){
			return;
		}
		
		if( $(window).scrollTop() > limit && $('#video-large-embed').width() > 400 ){
			//console.log('animation start');
			video_animating = true;
			$('#video-large-embed').css({
				'position' : 'fixed',
				'top' : menu1 + menu2
			}).animate({
				'width' : 400
			}, 500, function(){
				video_animating = false;
				//console.log('animation end');
			});
		}
		else if( $(window).scrollTop() < limit && $('#video-large-embed').width() < original_video_width ){
			//console.log('animation start');
			video_animating = true;
			$('#video-large-embed').css({
				'position' : 'relative',
				'top' : 0
			}).animate({
				'width' : original_video_width
			}, 500, function(){
				video_animating = false;
				//console.log('animation end');
			});
		}
	};

	$(window).scroll(function() {
		video_position();
	});
	
});
