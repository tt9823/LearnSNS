<?php
session_start();
require('dbconnect.php');
require('function.php');
$user_id = $_SESSION['LearnSNS']['id'];
$signin_user = getSinginUser($dbh, $user_id);

if (isset($_GET['feed_id'])) {
    $feed_id = $_GET['feed_id'];
    $feed = editGetFeed($dbh, $feed_id);
}

if (!empty($_POST)) {
    $feed_content = $_POST['feed'];
    $feed_id = $_POST['feed_id'];
    upDatePost($dbh, $feed_content, $feed_id);
    header('Location:timeline.php');
}



?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Learn SNS</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body style="margin-top: 60px;">
    <?php include('navbar.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <form class="form-group" method="post" action="edit.php">
                    <img src="user_profile_img/<?php echo $feed['img_name']; ?>" width="60">
                    <?php echo $feed['name']; ?><br>
                    <?php echo $feed['created']; ?><br>
                    <textarea name="feed" class="form-control"><?php echo $feed['feed'] ?></textarea>
                    <input type="submit" value="更新" class="btn btn-warning btn-xs">
                    <input type="hidden" name="feed_id" value="<?php echo $feed['id'] ?>">
                </form>
            </div>
        </div>
    </div>
</body>
<?php include('layouts/footer.php'); ?>
</html>