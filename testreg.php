<?php
//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
session_start();
define('CAPTCHA_COOKIE', 'imgcaptcha_');
include 'Classes.php';
?>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<main class="form-signin">
    <?php
    if (isset($_POST['login'])) {
        $login = $_POST['login'];
        if ($login == '') {
            unset($login);
        }
    } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
        if ($password == '') {
            unset($password);
        }
    }
    //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную

    if (empty($login) or empty($password)) {
        die ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
    }

    //если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);
    //удаляем лишние пробелы
    $login = trim($login);
    $password = trim($password);
    // подключаемся к базе
    include("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь
    $query = "SELECT * FROM users WHERE login='$login'";
    $result = mysqli_query($db, $query); //извлекаем из базы все данные о пользователе с введенным логином
    $myrow = mysqli_fetch_array($result);
    if (empty($myrow['password'])) {
        //если пользователя с введенным логином не существует
        Logger::getLogger('root')->log('Неверные данные при авторизации');
        die ("Извините, введённый вами login или пароль неверный.");

    } else {
        //если существует, то сверяем пароли
        if ($myrow['password'] == $password) {
            //если пароли совпадают, то запускаем пользователю сессию! Можете его поздравить, он вошел!
            $_SESSION['login'] = $myrow['login'];
            $_SESSION['id'] = $myrow['id'];
            $_SESSION['status'] = $myrow['status'];
            $_SESSION['banned'] = $myrow['banned'];
            $_SESSION['rdate'] = $myrow['rdate'];
            //эти данные очень часто используются, вот их и будет "носить с собой" вошедший пользователь
        } else {
            //если пароли не сошлись
            die ("Извините, введённый вами login или пароль неверный.");
        }
        if ($_SESSION['banned'] == 1) {
            Logger::getLogger('root')->log('Забаненый пользователь '.$_SESSION['login'].' пытается авторизоватся');
            unset($_SESSION['login']);
            unset($_SESSION['password']);
            die ("Вы забанены!");
        } elseif ($_SESSION['status'] != 10) {
            Logger::getLogger('root')->log($_SESSION['login'].' -- пользователь авторизовался');
            echo "<h1 class='h3 mb-3 fw-normal text-center'>Вы успешно вошли на сайт!</h1> <br>
    <a class='w-100 btn btn-lg btn-primary' role='button' href='index.php'>Главная страница</a> <br><br>
    <a class='w-100 btn btn-lg btn-primary' role='button' href='php.php'>Список пользователей</a>";
        } elseif ($_SESSION['status'] == 10) {
            //если авторизовался администратор
            Logger::getLogger('root')->log($_SESSION['login'].' -- пользователь авторизовался');
            echo "<h1 id='hello' class='h3 mb-3 fw-normal text-center'>Добро пожаловать, Администратор!</h1><br>
    <a class='w-100 btn btn-lg btn-primary' role='button' href='index.php'>Главная страница</a> <br><br>
    <a class='w-100 btn btn-lg btn-primary' role='button' href='php_admin.php'>Список пользователей</a>";
        }
    }
    ?>
</main>
</body>
</html>