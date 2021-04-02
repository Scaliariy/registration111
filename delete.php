<?php
	session_start();
	include ("bd.php");

	$delete = 'DELETE FROM users WHERE id="'.$_REQUEST['id'].'"';
	$result = mysqli_query($db,$delete);

	echo "Пользователь удален"."</br>";
	echo "<a href='php_admin.php'>Список пользователей</a>";
?>