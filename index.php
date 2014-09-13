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

</head>

<body>

<form class="inputForm">
	<img src="./img/ideasaurusLogo.png"/>
	<div class="input-group">
		<span class="input-group-btn">
			<input type="text" class="form-control">
			<button class="btn btn-default" type="submit">Ideasaur!</button>
		</span>
	</div>
	
	<div class="btn-group">
		<div class="btn-group">
		  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
		    Depth
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu" aria-labelledby="depth">
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Deep</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Deeper</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Too Deep</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Limbo</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Turtles</a></li>
		  </ul>
		</div>

		<div class="btn-group">
		  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
		    Breadth
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu" aria-labelledby="breadth">
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Wide</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Wider</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Too Wide</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Seriously?</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Bannana</a></li>
		  </ul>
		</div>
	</div>
</form>
</body>

</html>