<?php
session_start();
$errors = [];
if (!empty($_POST)) {
    $name = $_POST['input_name'];
    if ($name == '') {
        $errors['name'] = 'blank';
    }
    $email = $_POST['input_email'];
    if ($email == '') {
        $errors['email'] = 'blank';
    }
    $password = $_POST['input_password'];
    $count = strlen($password);
    if ($password == '') {
        $errors['password'] = 'blank';
    } elseif ($count < 4  || $count > 16) {
        $errors['password'] = 'length';
    }
    $file_name = $_FILES['input_img_name']['name'];
    if (!empty($file_name)) {
        $file_type = substr($file_name, -3);
        $file_type = strtolower($file_type);
        if ($file_type !== 'jpg' && $file_type !=='png'  && $file_type !=='gif') {
            $errors['img_name'] = 'type';
        }
    } else {
        $errors['img_name'] = 'blank';
    }
    if (empty($errors)) {
        $date_str = date('YmdHis');
        $submit_file_name = $date_str . $file_name;
        move_uploaded_file($_FILES['input_img_name']['tmp_name'], '../user_profile_img/.$submit_file_name');
        $_SESSION['LearnSNS']['name'] = $_POST["input_name"];
        $_SESSION['LearnSNS']['email'] = $_POST["input_email"];
        $_SESSION['LearnSNS']['password'] = $_POST["input_password"];
        $_SESSION['LearnSNS']['img_name'] = $submit_file_name;
        // die();
        header('Location: check.php');
        exit();
    }
}



?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Learn SNS</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body style="margin-top: 60px">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 thumbnail">
                <h2 class="text-center content_header">アカウント作成</h2>
                <form method="POST" action="signup.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">ユーザー名</label>
                        <input type="text" name="input_name" class="form-control" id="name" placeholder="山田 太郎"
                            value="">
                        <?php if (isset($errors['name']) && $errors['name'] == 'blank') : ?>
                        <p class="text-danger">お名前を入力してください</p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="email" name="input_email" class="form-control" id="email" placeholder="example@gmail.com"
                            value="">
                        <?php if (isset($errors['email']) && $errors['email'] == 'blank') : ?>
                        <p class="text-danger">メールアドレスを入力してください</p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
                    </div>
                    <?php if (isset($errors['password']) && $errors['password'] == 'blank') : ?>
                    <p class="text-danger">パスワードを入力してください</p>
                    <?php elseif (isset($errors['password']) && $errors['password'] == 'length') : ?>
                    <p class="text-danger">4~16文字のパスワードを入力してください。</p>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="img_name">プロフィール画像</label>
                        <input type="file" name="input_img_name" id="img_name" accept="image/*">
                        <?php if (isset($errors['img_name']) && $errors['img_name'] == 'blank') : ?>
                        <p class="text-danger">画像を選択してください</p>
                        <?php elseif (isset($errors['img_name']) && $errors['img_name'] = 'type') : ?>
                        <p class="text-danger">png,jpg,gifを選択してください</p>
                        <?php endif; ?>
                    </div>
                    <input type="submit" class="btn btn-default" value="確認">
                    <span style="float: right; padding-top: 6px;">ログインは
                        <a href="../signin.php">こちら</a>
                    </span>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="../assets/js/jquery-3.1.1.js"></script>
<script src="../assets/js/jquery-migrate-1.4.1.js"></script>
<script src="../assets/js/bootstrap.js"></script>
</html>