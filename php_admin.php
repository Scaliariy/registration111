<?php
//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
session_start();
$load_time_start = microtime();
include 'Classes.php';
?>
<!DOCTYPE html>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<main class="form-signin1">

    <?php

    if (isset($_GET['size'])) {
        // Если да то переменной $pageno присваиваем его
        $size = $_GET['size'];
    } else { // Иначе
        // Присваиваем $pageno один
        $size = 5;
    }
    // Поверка, есть ли GET запрос
    if (isset($_GET['pageno'])) {
        // Если да то переменной $pageno присваиваем его
        $pageno = $_GET['pageno'];
    } else { // Иначе
        // Присваиваем $pageno один
        $pageno = 1;
    }
    // Поверка, есть ли ORDER BY запрос
    if (isset($_GET['sort'])) {
        // Если да то переменной $name присваиваем его
        $name1 = $_GET['sort'];
    } else { // Иначе
        // Присваиваем $name1 один
        $name1 = 'login';
    }
    if (isset($_GET['sort2'])) {
        // Если да то переменной $name присваиваем его
        $param = $_GET['sort2'];
    } else { // Иначе
        // Присваиваем $name1 один
        $param = 'ASC';
    }
    if (isset($_GET['searching'])) {
        // Если да то переменной $name присваиваем его
        $search = $_GET['searching'];
    } else { // Иначе
        // Присваиваем $name1 один
        $search = '%';
    }
    // Назначаем количество данных на одной странице
    $size_page = $size;
    // Вычисляем с какого объекта начать выводить
    $offset = ($pageno - 1) * $size_page;

    include("bd.php");

    // SQL запрос для получения количества элементов
    $count_sql = "SELECT COUNT(*) FROM `users`";
    // Отправляем запрос для получения количества элементов
    $result = mysqli_query($db, $count_sql);
    // Получаем результат
    $total_rows = mysqli_fetch_array($result)[0];
    // Вычисляем количество страниц
    $total_pages = ceil($total_rows / $size_page);
    // Создаём SQL запрос для получения данных
    $sql = "SELECT * FROM `users` WHERE login LIKE '%$search%' ORDER BY $name1 $param LIMIT $offset, $size_page";
    // Отправляем SQL запрос
    $res_data = mysqli_query($db, $sql);
    ?>
    <table class="users">
        <div class="menu">
            <a class='w-100 btn btn-lg btn-primary' role='button' href='index.php'>Главная страница</a><br><br>
        </div>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                Sorting
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="?sort2=asc&size=<?php echo $size ?>&pageno=<?php echo $pageno ?>">
                        sort by name asc</a></li>
                <li><a class="dropdown-item" href="?sort2=desc&size=<?php echo $size ?>&pageno=<?php echo $pageno ?>">
                        sort by name desc </a></li>
            </ul>
        </div>
        <table class="table table-hover">
            <tr>
                <th class="column">ID</th>
                <th class="column">NAME</th>
                <th class="column">PASSWORD</th>
                <th class="column">STATUS</th>
                <th class="column">BAN</th>
                <th class="column" colspan="3"></th>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($res_data)) {
                ?>
                <tr>
                <td><?php
                    echo $row['id'] . ' ';
                    $rid = $row['id'] ?></td>
                <td><?php
                    echo $row['login'] . ' '; ?></td>
                <td><?php
                    echo $row['password'] . ' '; ?></td>
                <td><?php
                    echo $row['status'] . ' '; ?></td>
                <td><?php
                    echo $row['banned'] . '</br>'; ?></td>
                <td><?php
                    if ($row['banned'] == 0) {
                        echo "<a class='w-100 btn btn-sm btn-primary' role='button' href=ban.php?id=$rid>BAN/UNBAN</a>";
                    } else {
                        echo "<a class='w-100 btn btn-sm btn-primary' role='button' href=unban.php?id=$rid>BAN/UNBAN</a>";
                    }
                    ?></td>
                <td><?php
                    echo "<a class='w-100 btn btn-sm btn-primary' role='button' href=delete.php?id=$rid>DELETE</a>"; ?></td>

                </tr><?php
            } ?>
        </table><?php
        // Закрываем соединение с БД
        mysqli_close($db);
        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <nav id='pag' aria-label="Pagination">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link"
                                                     href="?size=<?php echo $size ?>&pageno=1&sort2=<?php echo $param ?>">
                                    First&nbsp </a></li>
                            <li class="page-item<?php if ($pageno <= 1) {
                                echo 'disabled';
                            } ?>">
                                <a class="page-link" href="<?php if ($pageno <= 1) {
                                    echo '#';
                                } else {
                                    echo "?size=$size&sort=$name1&sort2=$param&pageno=" . ($pageno - 1);
                                } ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-arrow-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                              d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                    </svg>
                                </a>
                            </li>
                            <li class="page-item<?php if ($pageno >= $total_pages) {
                                echo 'disabled';
                            } ?>">
                                <a class="page-link" href="<?php if ($pageno >= $total_pages) {
                                    echo '#';
                                } else {
                                    echo "?size=$size&sort=$name1&sort2=$param&pageno=" . ($pageno + 1);
                                } ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-arrow-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                              d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link"
                                                     href="?pageno=<?php echo $total_pages; ?>&size=<?php echo $size ?>&sort2=<?php echo $param ?>">
                                    Last&nbsp </a></li>
                        </ul>
                    </nav>

                </div>
                <div class="col-sm">

                    <form method="GET">
                        <input type="number" id="inputSize" class="form-control" name="size" required
                               placeholder="size">
                </div>
                <div class="col-sm">
                    <input type="text" id="Search" class="form-control" name="searching" placeholder="search">
                </div>
                <div class="col-sm">
                    <input id="searchButton" class="form-control" type="submit" value="Search">
                </div>
            </div>
        </div>
        <br>

    </table>
    <?php

    include("bd.php");
    include("ua_date.php");
    $u_id = $_SESSION['id'];
    $date_query = "SELECT rdate FROM `users` WHERE id='$u_id'";
    $result = mysqli_query($db, $date_query);
    $myrow = mysqli_fetch_array($result);
    //echo date("Y-m-d H:i:s", strtotime($myrow[0]));
    $timereg = strtotime($myrow[0]);
    $time = time();
    //echo "<br>".$timereg;
    $timereg = $time - $timereg;
    $hours = $timereg / 3600;
    $minutes = $timereg / 60;
    $days = $timereg / 86400;
    $monthes = $timereg / 2.628e+6;
    $years = $timereg / 3.154e+7;

    echo "Пройшло часу з реєстрації: " . date($timereg) . " секунд " . round($minutes) . " хвилин " . round($hours) . " годин " . round($days) .
        " днів " . round($monthes) . " місяців " . round($years) . " років";
    //echo "<br>".date_format($timereg,"Y-m-d H:i:s");
    echo " <br>Сьогодні: " . getDateRus() . ", " . getDayRus();
    $load_time = microtime() - $load_time_start;
    echo "<br>Час завантаження сторінки: " . $load_time;
    ?>

</main>
</body>
</html>