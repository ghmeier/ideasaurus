<?php include "runCrawler.php"; ?>
<!DOCTYPE HTML>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="stylesheet.css">

<style>
body {
	height:100%;
	width:100%;
	background-color:#33ccff;
}

.inputForm{
	display:block;
	width:50%;
	margin-left:auto;
	margin-right:auto;
	max-width:500px;
}

.inputForm img{
	display:block;
	margin-left:auto;
	margin-right:auto;
	margin-bottom:10px;
}

.selections{
	margin-top:5px;
	display:block;
	margin-left:auto;
	margin-right:auto;
	
}
</style>
</head>

<body>
	
<form class="inputForm" onsubmit="getIdea()" action="" role="form">
	<img src="./img/ideasaurusLogo.png"/>
	<div class="input-group">
		<span class="input-group-btn">
			<input type="text" id="search" class="form-control">
			<button class="btn btn-default"  type="submit" value="Submit">Ideasaur!</button>
		</span>
	</div>
	
	<div class="btn-group">
		<div class="btn-group">
		  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
		    <span id="depthLabel" data-bind="label">Select Depth</span>
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu" id="depth" aria-labelledby="depth">
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="1" href="#">Deep</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="2" href="#">Deeper</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="3" href="#">Too Deep</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="4" href="#">Limbo</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="5" href="#">Turtles</a></li>
		  </ul>
		</div>

		<div class="btn-group">
		  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
		    <span id="breadthLabel" data-bind="label">Select Breadth</span>
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu" id="breadth" aria-labelledby="breadth">
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="1" href="#">Wide</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="2" href="#">Wider</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="3" href="#">Too Wide</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="4" href="#">Seriously?</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="5" href="#">Bannana</a></li>
		  </ul>
		</div>
	</div>
</form>

<script>
   $( document.body ).on( 'click', '.dropdown-menu li', function( event ) {

      var $target = $( event.currentTarget );

      $target.closest( '.btn-group' )
         .find( '[data-bind="label"]' ).text( $target.text() )
            .end()
         .children( '.dropdown-toggle' ).dropdown( 'toggle' );

      return false;

   });

	function getIdea(){
		var w = $.get("runCrawler.php", function(data){ alert(data) });
		//alert("submitted " + $("input").val() + " "+ $("#depthLabel").text() + " "+ $("#breadthLabel").text());
	}
</script>

</body>

</html>
