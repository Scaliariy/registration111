<?php
session_start();
include 'Classes.php';
Logger::getLogger('root')->log($_SESSION['login'].' -- пользователь вышел из аккаунта');
session_destroy();
header('Location: index.php');
exit;