<?php
session_start();
if (isset($_SESSION['userkey'])) {
    header("Location: admin.php");
    exit;
} else {
    foreach ($_SESSION as $key => $row) {
        if($key != "error_msg" && $key != "sys_msg"){
            unset($_SESSION["{$key}"]);
        }
    }
}
if (!isset($_SESSION['code'])) {
    $_SESSION['code'] = rand(1000, 9999);
}
//echo $_SESSION['account'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content="JackyKuo"/>
    <meta name="author" content="JackyKuo"/>
    <title>PK10 一鍵致勝</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="login/assets/favicon.ico"/>
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="login/css/styles.css" rel="stylesheet"/>
</head>
<body id="page-top">
<!-- Header-->
<header class="masthead d-flex align-items-center">
    <div class="container px-4 px-lg-5 text-center">
        <h1 class="mb-1">PK10 一鍵致勝</h1>
        <h3 class="mb-5"><em>暢享極致 一鍵致勝</em></h3>
        <form class="row" style="margin:auto; width:50%;" action="doLogin.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label"><h5 class="mb-1">使用者帳號</h5></label>
                <input type="text" class="form-control" name="username" placeholder="使用者帳號">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><h5 class="mb-1">密碼</h5></label>
                <input type="password" class="form-control" name="password" placeholder="密碼">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><h5 class="mb-1">輸入驗證碼-><?= $_SESSION['code'] ?></h5></label>
                <input type="password" class="form-control" name="verifycode" placeholder="驗證碼">
            </div>
            <?php
            if (isset($_SESSION['error_msg'])) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_SESSION['error_msg'] ?>
                </div>
            <?php }
            unset($_SESSION['error_msg']);
            ?>

            <?php
            if (isset($_SESSION['sys_msg'])) {
                ?>
                <div class="alert alert-primary" role="alert">
                    <?= $_SESSION['sys_msg'] ?>
                </div>
            <?php }
            unset($_SESSION['sys_msg']);
            ?>
            <button type="submit" class="btn btn-primary">登入</button>
        </form>
    </div>
</header>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="login/js/scripts.js"></script>
</body>
</html>
