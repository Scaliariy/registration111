<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Регистрация</title>
</head>
<body>
<main class="form-signin">
    <h3 class="mb-3 fw-normal text-center text-primary">Регистрация</h3><br>
    <form action="save_user.php" method="post">
        <!--**** save_user.php - это адрес обработчика.  То есть, после нажатия на кнопку "Зарегистрироваться", данные из полей  отправятся на страничку save_user.php методом "post" ***** -->
        <h5 id="reg2" class="mb-3 fw-normal">Ваш логин:<br></h5>
        <input id="reg2" type="text" id="inputLogin" class="form-control" name="login" size="15" maxlength="15" required
               autofocus placeholder="Login"><br>
        <!--**** В текстовое поле (name="login" type="text") пользователь вводит свой логин ***** -->
        <div class="mb-3">
            <h5 id="reg2" class="mb-3 fw-normal">Ваша почта:<br></h5>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required
                   placeholder="Email">
            <div id="emailHelp" class="form-text">Мы никогда никому не передадим вашу электронную почту.</div>
        </div>
        <h5 id="reg2" class="mb-3 mt-3 fw-normal">Ваш пароль:<br></h5>
        <input id="reg2" class="form-control" name="password" type="password" size="15" maxlength="15" required
               placeholder="Password"><br>
        <!--**** В поле для паролей (name="password" type="password") пользователь вводит свой пароль ***** -->
        <!--**** Кнопочка (type="submit") отправляет данные на страничку save_user.php ***** -->
        Введите код с картинки: <input name="captcha" id="reg2" class="form-control"><br>
        <img id="reg2" title="Щёлкните для нового кода" alt="Капча" src="jcaptcha.php" style="border: 1px solid #0066ff"
             onclick="this.src='jcaptcha.php?id=' + (+new Date());"><br><br>
        <button id="regb" class="btn btn-lg btn-primary" type="submit">Зарегистрироватся</button>
    </form>
</main>
</body>
</html>