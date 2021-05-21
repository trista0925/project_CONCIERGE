<?php

//$page變數是負責中央內容的檔案
$page = '';
if (isset($_GET['page']) && $_GET['page'] != '') {$page = $_GET['page'];}
session_start();
?>

<?php
if ($page == '') {
    include 'webpage/index_content.php';
} else {
    include 'webpage/' . $page . '.php';
}
?>

