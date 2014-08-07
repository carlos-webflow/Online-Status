<?php
/**
 * LIST OF THINGS STILL TO DO
 * TODO: Make sure @anonymous turns into diferent unique object{@id,@name}
 * TODO: Add @id to @user->data
 */
session_start();
function autoloadClasses($pClassName)
{
	include(__DIR__ . "/classes/class." . $pClassName . ".lib.php");
}

spl_autoload_register("autoloadClasses");
$func = new Functions;
$user = new SiteUser;

if (!isset($_REQUEST['user'])) {
	$_REQUEST['user'] = '@nonymous';
}

if (empty($_SESSION['user'])) {
	$user->login($_REQUEST['user'], time());
	$_SESSION['user'] = $user->data;
	$user->online($_SESSION['user']['name'] . '.' . $_SESSION['user']['id'], 'online');
}

if (isset($_REQUEST['callback']) && ($_REQUEST['callback'] == 'away' || $_REQUEST['callback'] == 'online')) {
	header('Content-type: text/json');
	echo($_REQUEST['callback']);?>(<?php
	echo(json_encode($user->online($_SESSION['user']['name'] . '.' . $_SESSION['user']['id'], $_REQUEST['callback'])));
	?>);<?php
	die();
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Working with OOP</title>
	<script src="http://code.jquery.com/jquery-2.1.0.min.js" type="text/javascript"></script>
	<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js" type="text/javascript"></script>
	<script type="text/javascript">
		$().ready(function () {
			setInterval(setStatus, 60000, 'away');
			setStatus('online');
		});

		function setStatus(status) {
			$.ajax({
				url: document.URL,
				type: "POST",
				data: "",
				contentType: "application/json; charset=utf-8",
				dataType: "jsonp",
				jsonpCallback: status,
				success: function (users) {
					console.log(users);
					onlineNow = '<ul>';
					$.each(users['onlineNow'], function (index, value) {
						name = value.split('.')[0];
						id = value.split('.')[1];
						onlineNow += '<li title="' + id + '">' + name + '</li>';
					});
					onlineNow += '</ul>';
					$('#online_users_list').html(onlineNow);

					awayNow = '<ul>';
					$.each(users['awayNow'], function (index, value) {
						name = value.split('.')[0];
						id = value.split('.')[1];
						awayNow += '<li title="' + id + '">' + name + '</li>';
					});
					awayNow += '</ul>';
					$('#away_users_list').html(awayNow);

				}
			})
			return "Status is now [" + status + "]"
		}

	</script>
</head>
<body>
<div id="online_users" style="color:#00AD7A; font-family:Helvetica, Arial, sans-serif;">
	<span style="font-weight:bolder;">[Online Users]</span>
	<span id="online_users_list">...</span>
</div>
<br>

<div id="away_users" style="color:#C8B400; font-family:Helvetica, Arial, sans-serif;">
	<span style="font-weight:bolder;">[Away Users]</span>
	<span id="away_users_list">...</span>
</div>
</body>
</html>