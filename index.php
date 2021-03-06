<?php  ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Bootstrap contact form with PHP example by BootstrapBay.com.">
	<meta name="author" content="BootstrapBay.com">
	<title>C &amp; R Downloader</title>
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="css/bootstrap-3.3.7.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="Absolute-Center is-Responsive">
				<div class="col-sm-12 col-md-10 col-md-offset-1">
				<h2>Grab Product Comments and Reviews with ease</h2>
					<form id="download_form" class="download_form">
						<div class="form-group input-group">

							<input class="form-control type_selector" type="radio" checked value="youtube" name="content_type" id="youtube_radio" onChange="radioListener(this)"/>
							<label for='youtube_radio'><img height="28" src="images/icons/youtube.png"/>Youtube Comments</label>
							
							<input class="form-control type_selector" type="radio" checked value="apple" name="content_type" id="apple_radio" onChange="radioListener(this)"/>
							<label for='apple_radio'><img height="28" src="images/icons/apple.png"/>Apple Store Reviews</label>
							
							<input class="form-control type_selector" type="radio" checked value="play" name="content_type" id="play_radio" onChange="radioListener(this)"/>
							<label for='play_radio'><img height="28" src="images/icons/play.jpeg"/>Play Store Reviews</label>

							<input class="form-control type_selector" type="radio" value="amazon" name="content_type" id="amazon_radio" onChange="radioListener(this)"/>
							<label for='amazon_radio'><img height="28" src="images/icons/amazon.png"/>Amazon Reviews</label>

						</div>
						<div class="form-group input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
							<input class="form-control url_input" type="text" name='web_url' placeholder="Enter Url..."/>
						</div>
						<div class="form-group input-group email_container" style="display: none;">
							<span class="input-group-addon"><i class="glyphicon glyphicon-cloud-download"></i></span>
							<input class="form-control email_input" type="text" name='email' placeholder="Email..."/>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-def btn-block submit_but"><img class="loader_image" height="17" src="images/icons/Preloader_3.gif"/> <span class="submit_text">Submit</span></button>
						</div>
					</form>
					<div class="message_alert"><span class="msg_text">Download completed successfully</span> <a class="action_button">Download</a>
					</div>

				</div>
			</div>
		</div>
	</div>


	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap-3.3.7.js"></script>

	<script type="text/javascript">
		$( '.download_form' ).submit( function () {

			//first check the type of data the user wants to load
			if ( $( "input[type='radio'][name='content_type']:checked" ).val() == 'youtube' ) {
				var urlCheck = checkYoutubeUrl( $( '.url_input' ).val() );
				if ( urlCheck != "error" ) //check if the url is a valid youtube url and extrack the video id from the url
				{
					getDataAsync("loadYoutube",urlCheck,"" );
				} else {
					alert( 'The url you entered is invalid' );
				}
			} 
			else if ( $( "input[type='radio'][name='content_type']:checked" ).val() == 'amazon' ) 
			{
				var urlCheck = checkAmazonUrl( $( '.url_input' ).val() );
				if ( urlCheck != "error" ) //check if the url is a valid amazon url and extrack the product id from the url
				{
					var _mail = $('.email_input').val();
					getDataAsync("loadAmazon",urlCheck,_mail );
				} else {
					alert( 'The url you entered is invalid' );
				}
			}
			else if ( $( "input[type='radio'][name='content_type']:checked" ).val() == 'apple' ) 
			{
				var urlCheck = checkAppleUrl( $( '.url_input' ).val() );
				if ( urlCheck != "error" ) //check if the url is a valid amazon url and extrack the product id from the url
				{
					//alert(urlCheck);
					getDataAsync("loadApple",urlCheck,"" );
					
				} else {
					alert( 'The url you entered is invalid' );
				}
			}
			else if ( $( "input[type='radio'][name='content_type']:checked" ).val() == 'play' ) 
			{
				var urlCheck = $.urlParam('id', $('.url_input').val());
				if ( urlCheck != null ) //check if the url is a valid play store url and extrack the product id from the url
				{
					getDataAsync("loadPlay",urlCheck,"" );
					
				} else {
					alert( 'The url you entered is invalid' );
				}
			}
			return false;
		});
		
		function radioListener( _this ) //switch the placeholder when the user toggles btw youtube comments and amazon reviews
		{
			if ( $( _this ).val() == "youtube" ) {
				$( '.url_input' ).attr( "placeholder", "Enter Video Url..." );
				$( '.email_container' ).slideUp();
			} else if ( $( _this ).val() == "amazon" ) {
				$( '.url_input' ).attr( "placeholder", "Enter Product Url..." );
				$( '.email_container' ).slideDown();
			}
			else{
				$( '.url_input' ).attr( "placeholder", "Enter Product Url..." );
				$( '.email_container' ).slideUp();
			}
		}

		function checkYoutubeUrl( _url ) //checks if the url is valid and returns the video id
		{
			var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]{11,11}).*/;
			var match = _url.match( regExp );
			if ( match ) {
				if ( match.length >= 2 ) {
					return match[ 2 ];
				} else {
					return "error";
				}
			} else {
				return "error";
			}
		}
		
		function checkAmazonUrl( _url ) //checks if the url is valid and returns the video id
		{
			var regExp = /(?:dp|product|o|gp|-)\/(B[0-9]{2}[0-9A-Z]{7}|[0-9]{9}(?:X|[0-9]))/;
			var match = _url.match( regExp );
			if ( match ) {
				if ( match.length >= 1 ) {
					return match[ 1 ];
				} else {
					return "error";
				}
			} else {
				return "error";
			}
		}
		
		function checkAppleUrl( _url ) //checks if the url is valid and returns the video id
		{
			var regExp = /id(\d+)/;
			var match = _url.match( regExp );
			//console.log(match);
			if ( match ) {
				if ( match.length >= 1 ) {
					return match[ 1 ];
				} else {
					return "error";
				}
			} else {
				return "error";
			}
		}

		function getDataAsync( _action,_vid,_e ) {
			$( '.loader_image' ).show();
			$( '.submit_text' ).html( 'Fetching.....' );
			$.ajax( {
				url: './api/api_control.php?action='+_action+'&vid=' + _vid+'&e='+_e,
				async: false,
				cache: false,
				success: function ( data ) {
					
					var jdata = JSON.parse(data);
					$( '.loader_image' ).hide();
					$( '.submit_text' ).html( 'Submit' );
					
					if ( jdata.msg == 'success' ) {
						$( '.msg_text' ).html( "Data retrieved successfully" );
						$( '.message_alert' ).slideDown();
						$( '.action_button' ).show();
						$( '.action_button' ).click(function(){window.location =  document.location+jdata.rurl;});
					} else if( jdata.msg == 'failed' ) {
						$( '.msg_text' ).html( "Data retrieval failed" );
						$( '.action_button' ).hide();
						$( '.message_alert' ).slideDown();
					}
				},
				error: function ( result ) {
					$( '.loader_image' ).hide();
					$( '.submit_text' ).html( 'Submit' );
					$( '.msg_text' ).html( "An error occured while processing your request please check your connection and try again" );
					$( '.message_alert' ).slideDown();
					$( '.action_button' ).hide();
				}
			} );

		}
		
		$.urlParam = function(name,url){
		 var results = new RegExp('[\?&]'+name+'=([^&#]*)').exec(url);
		 if(results==null){
			 return null;
		 }
		 else{
			 return results[1]||0;
		 }
	 	}
		
		$(document).ready(function(){
			if($('.type_selector').val() == "amazon"){
				$( '.email_container' ).slideDown();
			}
			else{
				$( '.email_container' ).slideUp();
			}
		});
	</script>
</body>

</html>