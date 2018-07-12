@extends('mainBody')
@section('section')
	<div id="ytplayer"></div>
	<form class="inputSection" action="/larKurs/triger/video">
		<input type="text" id="lenght" name="lenght" value="0" style="display: none;">
		<input type="submit" class="button1" value="Next">
	</form>
@endsection


@section('head')
	<script>
		var status = -1;
		var endVideo = false;
		var lenght = 0;
		
		
		var tag = document.createElement('script');
		tag.src = "https://www.youtube.com/player_api";
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
		
		var player;
		function onYouTubePlayerAPIReady() {
			player = new YT.Player('ytplayer', {
				height: '360',
				width: '640',
				videoId: 'RDpOB-OXypQ',
				playerVars: {'fs': 0, 'rel': 0, 'showinfo': 0 },
				events: {
					'onReady': onPlayerReady,
					'onStateChange': function(s) { status = s.data; }
				}
			});
		}
		function onPlayerReady(event) {
			event.target.setVolume(100);
			event.target.playVideo();
		}
		setInterval(function() {
			if (status == 1)
				lenght += 0.1;
			if (!endVideo && status == 0)
				endVideo = true;
			if (endVideo)
				document.getElementById('lenght').setAttribute('value', Math.round(lenght).toString());
		}, 100);
	</script>
@endsection