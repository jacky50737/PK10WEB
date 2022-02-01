<?php
/**
 * 開發者 User
 * 創建於 2022/1/29
 * 使用   PhpStorm
 * 專案名稱PK10WEB
 */
header("Content-type:text/html;charset=UTF-8");
session_start();        //開啓會話一獲取到服務器端驗證碼
if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['verifycode'])){
    $_SESSION['error_msg']="帳號或密碼為空";
    unset($_SESSION['code']);
    header("Location: index.php");
    exit;
}
$username=$_POST['username'];
$password=$_POST['password'];
$verifycode=$_POST['verifycode'];
$code=$_SESSION['code'];    //獲取服務器生成的驗證碼

$server = "localhost";         # MySQL/MariaDB 伺服器
$dbuser = "pjtvqdla_jacky50737";       # 使用者帳號
$dbpassword = "Aa174677178508123"; # 使用者密碼
$dbname = "pk10web";    # 資料庫名稱
# 連接 MySQL/MariaDB 資料庫
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connection = new mysqli($server, $dbuser, $dbpassword, $dbname);

/*
 * 首先進行判空操作，通過後進行驗證碼驗證，通過後再進行數據庫驗證。
 * */
if(checkEmpty($username,$password,$verifycode)){
    if(checkVerifycode($verifycode,$code)){
        if(checkUser($username,$password,$connection)){
            $_SESSION['username']=$username; //保存此時登錄成功的用戶名
            header("location: admin.php ");      //全部驗證都通過之後跳轉到首頁
            exit;
        }
    }
}
//方法：判斷是否爲空
function checkEmpty($username,$password,$verifycode){
    if($username==null||$password==null||$verifycode==null){
        $_SESSION['error_msg']="帳號或密碼為空";
        unset($_SESSION['code']);
        header("Location: index.php");
        exit;
    }
    return true;
}
//方法：檢查驗證碼是否正確
function checkVerifycode($verifycode,$code){
    if($verifycode==$code){
        return true;
    }else{
        $_SESSION['error_msg']="驗證碼錯誤";
        unset($_SESSION['code']);
        header("Location: index.php");
        exit;
    }
}
//方法：查詢用戶是否在數據庫中並設定使用者金鑰
function checkUser($username,$password,$connection){
    $conn= $connection;
    $query = sprintf("SELECT PK10SSS_ID,NICKNAME FROM user WHERE ACCOUNT='%s' AND PASSWORD='%s'",
        $conn->real_escape_string($username),$conn->real_escape_string(md5($password)));
    $result = mysqli_query($conn, $query);
    $conn->close();
    var_dump($result);
    if($result->num_rows){
        $data = $result->fetch_row();
        $_SESSION['userkey'] = $data[0];
        $_SESSION['nickname'] = $data[1];
        return true;
    }
    else{
        $_SESSION['error_msg']="用戶不存在";
        unset($_SESSION['code']);
        header("Location: index.php");
        exit;
    }
}