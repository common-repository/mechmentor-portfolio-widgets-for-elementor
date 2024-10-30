/**
 * Mech Portfolio Scripts
 */

var MPT = window.MPT || {};
window.MPT = MPT;
	
(function($){
 	 "use strict";

 	MPT.getQueryVariable = function(variable) {
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
    }

    MPT.YouTubeGetID = function(url){
	  var ID = '';
	  url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
	  if(url[2] !== undefined) {
	    ID = url[2].split(/[^0-9a-z_\-]/i);
	    ID = ID[0];
	  }
	  else {
	    ID = url;
	  }
	    return ID;
	}

	MPT.singlePortfolio  = function(){

		var gridItem = $('.mpt-portfolio .grid-item');

		$(".mpt-single-portfolio").niceScroll({
			zindex: 10000,
		});

		$(".mpt-single-portfolio .mpt-media").niceScroll({
			zindex: 10000,
		});

		$(".mpt-single-portfolio .mpt-content").niceScroll({
			zindex: 10000
		});

		gridItem.each(function(){
			var title = $(this).attr('data-title'),
				content = $(this).attr('data-content'),
				images = $(this).attr('data-images'),
				video = $(this).attr('data-video'),
				audio = $(this).attr('data-audio'),
				services = $(this).attr('data-services'),
				date = $(this).attr('data-date'),
				client = $(this).attr('data-client'),
				type = $(this).attr('data-type');

			var imageArray = typeof images !== 'undefined' ? images.split('|') : [];
			var imageHTML = '';
			var detailItem = '';
			var videoHTML = '';
			var audioHTML = '';

			$(this).find('.grid-thumbnail').on('click', function(){
				$('body').css('overflow', 'hidden');
				$('.mpt-single-portfolio').addClass(type).fadeIn();
				$('.mpt-single-portfolio-overlay').fadeIn();
				$('.mpt-portfolio-title').text(title);
				$('.mpt-entry-content').text(content);

				detailItem += services !== '' ? '<p>Services: '+ services +'</p>' : '';
				detailItem += client !== '' ? '<p>Client: '+ client +'</p>' : '';
				detailItem += date !== '' ? '<p>Date: '+ date +'</p>' : '';
				$('.mpt-portfolio-details').html(detailItem);

				if(type === 'image') {
					// Insert Images
					if(imageArray.length > 0){
						for(var i in imageArray){
							imageHTML += '<img src="'+imageArray[i]+'" />';
						}
						$('.mpt-media').html(imageHTML);
					}
				}

				if(type === 'video' && video !== '') {
					// Insert Video
					var videoUrlParts = video.replace('http://','').replace('https://','').split(/[/?#]/);
					var videoSite = videoUrlParts[0];
					var videoID = '';

					if( videoSite === 'youtube.com' || videoSite === 'youtu.be' || videoSite === 'www.youtube.com'){
						videoID = MPT.YouTubeGetID(video);
					}

					videoHTML = '<div class="mpt-video-container"><iframe width="560" height="315" src="https://youtube.com/embed/'+videoID+'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
					$('.mpt-media').html(videoHTML);
				}

				if(type === 'audio' && audio !== '') {
					audioHTML = '<iframe scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='+audio+'"></iframe>';
					$('.mpt-media').html(audioHTML);
				}
			});

			$('.mpt-single-portfolio .mpt-close').on('click', function(){
				$('body').css('overflow', 'auto');
				$('.mpt-single-portfolio').removeClass(type).fadeOut();
				$('.mpt-single-portfolio-overlay').fadeOut();

				$('.mpt-portfolio-title').empty();
				$('.mpt-entry-content').empty();
				$('.mpt-media').empty();
				$('.mpt-portfolio-details').empty();
			 	imageHTML = '';
				detailItem = '';
			});
		});
	}

	MPT.infiniteScroll = function(){

		var container = $('.mpt-portfolio');

		if(container.attr('data-infinite') !== '1'){
			return false;
		}

		container.each(function(){

			var id = container.attr('id');

			if( $('.mpt-next-link').length > 0 ){

				$(this).infiniteScroll({
				  	path: '#'+$('.mpt-next-link').attr('id'),
				  	append: false,
				  	history: false,
				  	status: '.mpt-load-status'
				});

				$(this).on( 'load.infiniteScroll', function(event, response) {
					// get posts from response
					var $new_items = $(response).find('.grid-item');
					$(this).infiniteScroll('appendItems', $new_items );
					MPT.singlePortfolio();
				});
			}
		});
	}

	MPT.init = function(){
		MPT.singlePortfolio();
		MPT.infiniteScroll();
	}

	MPT.init();

})(jQuery);