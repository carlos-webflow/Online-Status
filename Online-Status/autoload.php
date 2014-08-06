<?php
/**/
	include_once("./classes/class.Functions.lib.php");
	include_once("./classes/class.SiteUser.lib.php");
/**/
	function autoloadClasses ($pClassName) {
			include(__DIR__ . "/classes/class." . $pClassName . ".lib.php");
	}
	spl_autoload_register("autoloadClasses");
	$F = new Functions;
	$USER = new SiteUser;
	
	if($_REQUEST['callback']=='keepAlive'){
		header('Content-type: text/json');
		die($_REQUEST['callback'].'('.json_encode($USER->online('BOT','online')).')');
	}
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PLAYING WITH OOP</title>
<script src="http://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
$().ready(function(e) {
	function keepAlive(){
		$.ajax({
			jsonpCallback:"keepAlive",
			url:document.URL,
			type:"POST",
			data:"",
			dataType:"jsonp",
			contentType:"application/json; charset=utf-8",
			success: function(users){
				$('body').html('');
				$.each(users, function(key,value){
					$('body').append('<p>['+key+']<ul>');
					$.each(value, function(key,value){
						$('body').append('<li>'+value+'</li>');
					});	
					$('body').append('</ul></p><br />');
				});
			}
		});
	}
  setInterval(keepAlive,2000);
});
</script>
</head>
<body>
</body>
</html>