<?php
/**
 * 開發者 User
 * 創建於 2022/2/2
 * 使用   PhpStorm
 * 專案名稱PK10WEB
 */
session_start();
//登出
foreach ($_SESSION as $key => $row){
    unset($_SESSION["{$key}"]);
}
$_SESSION['sys_msg']="已順利登出!";
header("location: index.php ");
exit;