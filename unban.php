<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
    session_start();
    ?>
    <!DOCTYPE html>
<html>
<head>
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<main id="banned">
		<div class="menu">
<?php
	session_start();
	include ("bd.php");
	$query4 = 'UPDATE users SET banned=0 WHERE id="'.$_REQUEST['id'].'"';
	$result = mysqli_query($db,$query4);
	echo "<p class='fs-3 text-center'>Пользователь разбанен</p>"."</br>";
	echo "<a class='w-100 btn btn-lg btn-primary' role='button' href='php_admin.php'>Список пользователей</a>";
?>
</div>
</main>
</body>
</html>