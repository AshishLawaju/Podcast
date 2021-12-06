 (function($) {

     "use strict";
	 
     $(document).ready(function() {
			
		var player = $('.wp-block-audio audio, .powerpress_player audio, audio.wp-audio-shortcode');
		player.mediaelementplayer({
			 'classPrefix': 'mejs-',				 
			 'isVideo': false,
			 'setDimensions': false,
			 'preload': 'none',
			 'pauseOtherPlayers': true,
			 'alwaysShowControls': true,
		 //  'audioVolume': 'vertical', // add into customizer?
			 'startVolume': 0.8,
			 'skipBackInterval': 30,
			 'jumpForwardInterval': 30,
			 'timeAndDurationSeparator': '<span> / </span>',
			 'features': ['skipback', 'playpause', 'jumpforward', 'current', 'progress', 'duration', 'tracks', 'volume', 'speed'],
			 'speeds': ['2', '1.5', '1.25', '0.75'],
			 'defaultSpeed': '1',
			 success: function (mediaElement) { mediaElement.pause(); }           
		})
	 
		var video = $('.powerpress_player video, video.wp-video-shortcode'); 
		video.mediaelementplayer({
			 'classPrefix': 'mejs-',				 
			 'isVideo': true,
			 'setDimensions': true,
			 'preload': 'none',
			 'pauseOtherPlayers': true,
			 'alwaysShowControls': false,
			 'audioVolume': 'vertical', 
			 'startVolume': 0.8,
			 'timeAndDurationSeparator': '<span> / </span>',
			 'features': ['playpause', 'current', 'progress', 'duration', 'volume', 'fullscreen'],               
			 success: function (mediaElement) { mediaElement.pause(); }           
		})		


		$('.wp-playlist:not(:has(.mejs-container))').each(function() {
			$(this).addClass('secondline_playlist');	
			var playlist_script = $(this).find('.wp-playlist-script');
			var secondline_audio_playlist = $(playlist_script).html();	
			var json = $.parseJSON(secondline_audio_playlist);
			var tracks = json.tracks;
			var self = $(this).find('audio');
			self.attr('controls="controls"');
			$(tracks).each(function() {
				if(this !== null) {	
					var source = this.src;
					var length = this.meta.length_formatted;			
					var artist = this.meta.artist;			
					var album = this.meta.album;			
					var genre = this.meta.genre;			
					var year = this.meta.year;	
					var type = this.type;			
					var title = this.title;	
					if(this.thumb) {
						if(this.thumb.src == null || this.thumb.src.indexOf('wp-includes/images/media/audio.png') >= 0) {
							var thumbnail = '';
						} else {						
							var thumbnail = this.thumb.src;
						}
					} else {
						var thumbnail = '';
					}
					var description = this.description;
					description = description.replace(/\"/g,'');					
								
					jQuery(self).append('<source class="wp-playlist-item" src="' + source + '" type="' + type + '" title="' + title + '" data-playlist-description="' + description + '" data-playlist-thumbnail="' + thumbnail + '" year="' + year + '" genre="' + genre + '" album="' + album + '" artist="' + artist + '" length="' + length + '">');
				}
											
			})

			$(this).find('audio').mediaelementplayer({
				'classPrefix': 'mejs-',
				'isVideo': false,
				'playlist': true,
				playlistposition: 'bottom',
				features: ['playlistfeature', 'prevtrack', 'playpause', 'nexttrack', 'current', 'progress', 'duration', 'volume', 'skipback', 'jumpforward', 'speed', 'playlist'],
				prevText: 'Previous',
				nextText: 'Next',
				playlistTitle: '',
				currentMessage: '',
			})
			
			
			$(this).find('ul.mejs-playlist-selector-list').each(function() {
				$(this).addClass('wp-playlist-tracks');
				$(this).find('li.mejs-playlist-selector-list-item').addClass('wp-playlist-item');
				$(this).find('.mejs-playlist-selector-label').addClass('wp-playlist-item-title');								
			});
			
			var playlistHeight = $(this).find('.mejs-layers ul.mejs-playlist-selector-list').height();
			$(this).height(playlistHeight + 200);
			$(this).find('.mejs-controls').append('<button class="playlist-toggle"><i class="fas fa-bars"></i></button>');
			$(this).find('.wp-playlist-item .mejs-playlist-item-inner:not(:has(.mejs-playlist-item-thumbnail))').prepend( '<i class="no-thumb-slt fas fa-image"></i></button>' );
			$(this).find('.playlist-toggle').on("click", function() {
				$(this).parents('.secondline_playlist').find('.mejs-container').toggleClass('playlist_hidden');			
				$(this).parents('.secondline_playlist').toggleClass('fluid_playlist_height');
			});					
			
			
		});		
		
	});
 })(jQuery);