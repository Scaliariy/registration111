<!DOCTYPE html>
<html>
<head>
	<title>ParsHref</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<main class="form-signin">
	<form action="parser.php" method="post">
	<h3 class="h3 mb-3 fw-normal text-primary text-center">Input your link:</h3>
 	<input class="form-control" name="link" type="text" >
 	<br>

    <!--**** В поле для паролей (name="password" type="password") пользователь вводит свой пароль ***** -->
    <button class="w-100 btn btn-lg btn-primary" type="submit">Scan</button>
</form>
</main>
</body>
</html>