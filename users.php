<?php

session_start();
require('dbconnect.php');
require('function.php');

if (!isset($_SESSION['LearnSNS']['id'])) {
    header('Location:signin.php');
}

$user_id = $_SESSION['LearnSNS']['id'];
$signin_user = getSinginUser ($dbh, $user_id);

$users = getAllusers($dbh);

?>

<?php include('layouts/header.php'); ?>
<body style="margin-top: 60px; background: #E4E6EB;">
    <?php include('navbar.php'); ?>
    <div class="container">
        <?php foreach ($users as $user) : ?>
        <?php $feed_cnt = getUsersFeedCnt($dbh, $user); ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="thumbnail">
                        <div class="row">
                            <div class="col-xs-2">
                                <img src="user_profile_img/<?php echo $user['img_name']; ?>" width="80px">
                            </div>
                            <div class="col-xs-10">
                                名前 <a href="profile.php" style="color: #7f7f7f;"><?php echo $user['name'] ?></a>
                                <br>
                                <?php echo $user['created'] ?>からメンバー
                            </div>
                        </div>
                        <div class="row feed_sub">
                            <div class="col-xs-12">
                                <span class="comment_count">つぶやき数：<?php echo $feed_cnt["cnt"]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
<?php include('layouts/footer.php'); ?>
</html>
