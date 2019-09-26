<?php
session_start();
require('dbconnect.php');
require('function.php');



if (!isset($_SESSION['LearnSNS']['id'])) {
    header('Location:signin.php');
}

$signin_user_id = $_SESSION['LearnSNS']['id'];
$signin_user = getSinginUser ($dbh, $signin_user_id);
$img_name = $signin_user['img_name'];

$user_id = $_GET['user_id'];

$user = getTargetUser($dbh, $user_id);

$is_follower = swithFollowButton($dbh, $user_id, $signin_user_id);

// var_dump($is_follower);
$followed = [];
$followed = getfollowers($dbh, $user_id);
$followings = getFollowings($dbh, $user_id);


?>
<?php include('layouts/header.php'); ?>
<body style="margin-top: 60px; background: #E4E6EB;">
    <?php include("navbar.php"); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-3 text-center">
                <img src="user_profile_img/<?php echo $user['img_name'] ?>" class="img-thumbnail" />
                <h2><?php echo $user['name'] ?></h2>
                <?php if ($signin_user_id !== $user_id) : ?>
                    <?php if ($is_follower == false) :  ?>
                        <a href="follow.php?following_id=<?php echo $user['id']; ?>">
                            <button class="btn btn-default btn-block">フォローする</button>
                        </a>
                    <?php else :  ?>
                    <a href="follow.php?following_id=<?php echo $user['id']; ?>">
                            <button class="btn btn-default btn-block">フォロー解除する</button>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="col-xs-9">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab1" data-toggle="tab">Followers</a>
                    </li>
                    <li>
                        <a href="#tab2" data-toggle="tab">Following</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab1" class="tab-pane fade in active">
                        <?php foreach ($followed as $follower) : ?>
                            <div class="thumbnail">
                                <div class="row">
                                    <div class="col-xs-2">
                                        <img src="user_profile_img/<?php echo $follower['img_name']; ?>" width="80px">
                                    </div>
                                    <div class="col-xs-10">
                                        名前 <a href="profile.php?user_id=<?php echo $follower['id']; ?>" style="color: #7F7F7F;"><?php echo $follower['name']; ?></a>
                                        <br>
                                        <?php echo $follower['created']; ?>からメンバー
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div id="tab2" class="tab-pane fade">
                        <?php foreach ($followings as $following) : ?>
                            <div class="thumbnail">
                                <div class="row">
                                    <div class="col-xs-2">
                                        <img src="user_profile_img/<?php echo $following['img_name']; ?>" width="80px">
                                    </div>
                                    <div class="col-xs-10">
                                        名前 <a href="profile.php?user_id=<?php echo $following['id']; ?>" style="color: #7F7F7F;"><?php echo $following['name']; ?></a>
                                        <br>
                                        <?php echo $following['created']; ?>からメンバー
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include('layouts/footer.php'); ?>
</html>