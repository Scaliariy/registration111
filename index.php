<?php
include 'Classes.php';
$session = new Session();
$session->start();
include 'count.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Главная страница</title>
</head>
<body>
<main class="form-signin">
    <!--<form action="testreg.php" method="post">-->
    <?php
    $form = new Form();
    $smartform = new SmartForm();
    echo $form->open(['action' => 'testreg.php', 'method' => 'POST']);
    ?>
    <img id="img" class="mb-4" src="../img2.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 fw-normal text-primary">Главная страница</h1><br>
    <!--****  testreg.php - это адрес обработчика. То есть, после нажатия на кнопку  "Войти", данные из полей отправятся на страничку testreg.php методом  "post" ***** -->
    <label for="inputLogin" class="visually-hidden">Login</label>
    <?
    echo $smartform->input(['type' => 'text', 'id' => 'inputLogin', 'class' => 'form-control', 'name' => 'login', 'size' => '15', 'maxlength' => '15', 'required autofocus', 'placeholder' => 'Login']);
    ?>
    <!--<input type="text" id="inputLogin" class="form-control" name="login" size="15" maxlength="15" required autofocus placeholder="Login">-->
    <!--**** В текстовое поле (name="login" type="text") пользователь вводит свой логин ***** -->
    <label for="inputPassword" class="visually-hidden">Password</label>
    <?
    echo $smartform->input(['type' => 'password', 'id' => 'inputPassword', 'class' => 'form-control', 'name' => 'password', 'size' => '15', 'maxlength' => '15', 'required', 'placeholder' => 'Password']);
    ?>
    <!--<input id="inputPassword" class="form-control" name="password" type="password" size="15" maxlength="15" required placeholder="Password">-->
    <!--**** В поле для паролей (name="password" type="password") пользователь вводит свой пароль ***** -->
    <?
    echo $form->submit(['class'=>'w-100 btn btn-lg btn-primary', 'value'=>'Войти']);
    ?>
    <!--<button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>-->
    <!--**** Кнопочка (type="submit") отправляет данные на страничку testreg.php ***** -->
    <br><br>
    <!--**** ссылка на регистрацию, ведь как-то же должны гости туда попадать ***** -->
    <a class="w-100 btn btn-lg btn-primary" href="reg.php" role="button">Зарегистрироваться</a><br><br>

    <?php
    // Проверяем, пусты ли переменные логина и id пользователя
    if (empty($a1 = $session->get('login')) or empty ($a2 = $session->get('id'))) {
        // Если пусты, то мы не выводим ссылку
        echo "Вы вошли на сайт, как гость<br><a id='line' class='w-100 btn btn-lg btn-primary' role='button' href='#'>Список пользователей</a>";
    } elseif ($_SESSION['status'] != 10) {
        // Если не пусты, то мы выводим ссылку
        echo "Вы вошли на сайт, как: " . $_SESSION['login'] . "<br><br><a class='w-100 btn btn-lg btn-primary' role='button' href='php.php'>Список пользователей</a>";
    } elseif ($_SESSION['status'] == 10) {

        echo "Вы вошли на сайт, как Администратор: " . $_SESSION['login'] . "<br><br><a class='w-100 btn btn-lg btn-primary' role='button' href='php_admin.php'>Список пользователей</a>";
    }

    include 'show_stats.php';
    echo $form->close();
    ?>
    <!-- <br><p><a href="mailto:scaliariy1@gmail.com">scaliariy1@gmail.com</a></p> -->
    <!--</form>-->
    <a class="w-100 btn btn-lg btn-primary" href="out.php" role="button">Выйти</a><br><br>
    <a class="w-100 btn btn-lg btn-primary" href="parshref.php" role="button">Parser</a><br><br>
</main>

</body>
</html>