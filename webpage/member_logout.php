<?php
require_once 'shared/conn_PDO.php';
session_start();

$_SESSION['mem_id'] = '';
$_SESSION['mem_name'] = '';
$_SESSION['mem_level'] = '';
$_SESSION['mem_mail'] = '';

unset($_SESSION['mem_id']);
unset($_SESSION['mem_name']);
unset($_SESSION['mem_level']);
unset($_SESSION['mem_mail']);

header('Location: ./');
