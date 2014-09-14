
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
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
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

#idea{
	text-align:center;
}
</style>
</head>

<body>
	
<form class="inputForm" onsubmit="" action="" role="form">
	<img src="./img/ideasaurusLogo.png"/>
	<div class="input-group">
		<span class="input-group-btn">
			<input type="text" id="search" class="form-control">
			<button id="submitButton" class="btn btn-default" type="submit" value="Submit">Ideasaur!</button>
		</span>
	</div>
	
	<div class="btn-group">
		<div class="btn-group">
		  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
		    <span id="depthLabel" data-bind="label">Select Depth</span>
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu" id="depth" value="10" aria-labelledby="depth">
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="15" href="#">Deep</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="20" href="#">Deeper</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="25" href="#">Too Deep</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="30" href="#">Limbo</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="35" href="#">Turtles</a></li>
		  </ul>
		</div>

		<div class="btn-group">
		  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
		    <span id="breadthLabel" data-bind="label">Select Breadth</span>
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu" id="breadth" value="2" aria-labelledby="breadth">
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="4" href="#">Wide</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="6" href="#">Wider</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="8" href="#">Too Wide</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="10" href="#">Seriously?</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" value="12" href="#">Bannana</a></li>
		  </ul>
		</div>
	</div>
	<div class="btn-group" style="float:right;" id="outerLinks"> 
	 <button class="btn btn-default" type="button" id="googleIt" href="#" target="_blank">
		<i class="fa fa-google"></i>
	 </button>
	 <button class="btn btn-default" type="button" id="wiki" href="#" target="_blank">
		<i class="fa fa-book"></i>
	 </button>
	</div>
</form>
<div class="nodes" style="margin-top:50px;margin-left:50px;margin-right:50px;">

</div>

<script>
	$(document).ready(function(){$("#outerLinks").hide();});
   $( document.body ).on( 'click', '.dropdown-menu li', function( event ) {
		
      var $target = $( event.currentTarget );
	$target.closest( '.btn-group' )
         .find( '[data-bind="label"]' ).val($target.val());
      $target.closest( '.btn-group' )
         .find( '[data-bind="label"]' ).text( $target.text() )
            .end()
         .children( '.dropdown-toggle' ).dropdown( 'toggle' );

      return false;

   });
   
	$("#submitButton").click( function(e){
	e.preventDefault();
		$.ajax({
            type: 'POST',   
            data: 'search='+$("#search").val().replace(' ','_')+'&results='+$("#breadth").val()+'&depth='+$("#depth").val(),
			url: 'runCrawler.php',
            success: function(data){
				$("#outerLinks").show();
				$("#googleIt").attr("href","http://lmgtfy.com/?q="+$("#search").val().replace(' ','+'));
				$("#wiki").attr("href","http://en.wikipedia.com/wiki/"+$("#search").val().replace(' ','+'));
                // If you want, alert whatever your PHP script outputs
                var array = getQueryVariable(data);
				var finalText = '';
				for (x=0;x<array.length;x++){
					if (x%4==0){
					finalText+='<div class="row">'
					}
					finalText +='<div class="col-xs-3 col-md-3"><a href="#" class="thumbnail" id="idea">'+ array[x].replace('_',' ')+'</a></div>';
					if (x%4==3){
						finalText+="</div>"
					}
				}
				$(".nodes").html(finalText);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                alert("Status: " + textStatus+" Error: " + errorThrown); 
            }    
        });
	});
	
	$("#googleIt").click(function(){
		window.open( $(this).attr("href"));
	});
	
	$("#wiki").click(function(){
		window.$(this).attr("href");
	});
	
	$("#idea").click( function(e){
	alert("clocked");
	e.preventDefault();
		$.ajax({
            type: 'POST',   
            data: 'search='+$(this).text().replace(' ','_')+'&results='+$("#breadth").val()+'&depth='+$("#depth").val(),
			url: 'runCrawler.php',
            success: function(data){
                // If you want, alert whatever your PHP script outputs
                var array = getQueryVariable(data);
				var finalText = '';
				for (x=0;x<array.length;x++){
					if (x%4==0){
					finalText+='<div class="row">'
					}
					finalText +='<div class="col-xs-3 col-md-3" ><a class="thumbnail" id="idea">'+ array[x]+'</a></div>';
					if (x%4==3){
						finalText+="</div>"
					}
				}
				$(".nodes").html(finalText);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                alert("Status: " + textStatus+" Error: " + errorThrown); 
            }    
        });
	});
	
	function getQueryVariable(query) {
    var vars = query.split('&');
	var hash = [];
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
		hash.push(decodeURIComponent(pair[0]));
    }
	
	return hash;
}
</script>

</body>

</html>
