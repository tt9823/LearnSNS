<?php
session_start();
require('dbconnect.php');
require('function.php');



if (!isset($_SESSION['LearnSNS']['id'])) {
    header('Location:signin.php');
}

$user_id = $_SESSION['LearnSNS']['id'];
$signin_user = getSinginUser ($dbh, $user_id);
// var_dump($signin_user);
$img_name = $signin_user['img_name'];


$errors = [];
if (!empty($_POST)) {
    $feed = $_POST['feed'];
    if (!empty($_POST)) {
        if ($feed !== '') {
            createFeed($dbh, $feed, $user_id, $img_name);
            header('Location:timeline.php');
        } else {
            $errors['feed'] = 'blank';
        }
    }
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

const CONTENT_PER_PAGE = 5;
$content_per_page = CONTENT_PER_PAGE;
$page = max($page, 1);
$records_cnt = feedsCnt($dbh);
$last_page = ceil($records_cnt['cnt']/$content_per_page);
$page = min($page, $last_page);
$start = ($page - 1) * $content_per_page;

$feeds = getAllFeeds($dbh, $content_per_page, $start);


?>
<?php include('layouts/header.php'); ?>
<body style="margin-top: 60px; background: #E4E6EB;">
    <?php include('navbar.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="timeline.php?feed_select=news">新着順</a></li>
                    <li><a href="timeline.php?feed_select=likes">いいね！済み</a></li>
                </ul>
            </div>
            <div class="col-xs-9">
                <div class="feed_form thumbnail">
                    <form method="POST" action="timeline.php">
                        <div class="form-group">
                            <textarea name="feed" class="form-control" rows="3" placeholder="Happy Hacking!" style="font-size: 24px;"></textarea><br>
                        </div>
                        <?php if(isset($errors['feed']) && $errors['feed'] == 'blank') : ?>
                        <p class="text-danger">投稿を入力してください</p>
                        <?php endif; ?>
                        <input type="submit" value="投稿する" class="btn btn-primary">
                    </form>
                </div>
                <?php if(isset($feeds)) : ?>
                <?php foreach ($feeds as $feed) : ?>
                <?php $comment = getComment($dbh, $feed); ?>
                <?php $comment_cnt = getCommentcnt($dbh, $feed); ?>
                <?php var_dump($feed); ?>
                <div class="thumbnail">
                    <div class="row">
                        <div class="col-xs-1">
                            <img src="user_profile_img/<?php echo $feed['img_name'] ?>" width="40px">
                        </div>
                        <div class="col-xs-11">
                            <a href="profile.php" style="color: #7f7f7f;"><?php echo $feed['name'] ?></a>
                            <?php echo $feed['created']; ?>
                        </div>
                    </div>
                    <div class="row feed_content">
                        <div class="col-xs-12">
                            <span style="font-size: 24px;"><?php echo $feed['feed']; ?></span>
                        </div>
                    </div>
                    <div class="row feed_sub">
                        <div class="col-xs-12">
                            <button class="btn btn-default">いいね！</button>
                            いいね数：
                            <span class="like-count">10</span>
                            <?php if ($signin_user['id'] !== $feed['user_id']) : ?>
                                <a href="#collapseComment<?php echo $feed['id']; ?>" data-toggle="collapse" aria-expanded="false"><span>コメントする</span></a>
                            <?php endif; ?>
                            <span class="comment-count">コメント数：<?php echo $comment_cnt['cnt'] ?></span>
                            <?php if ($feed['name'] == $signin_user['name']) : ?>
                            <a href="edit.php?feed_id=<?php echo $feed['id']; ?>" class="btn btn-success btn-xs">編集</a>
                            <a onclick="return confirm('ほんとに消すの？');" href="delete.php?feed_id=<?php echo $feed['id']; ?>" class="btn btn-danger btn-xs">削除</a>
                            <?php endif; ?>
                        </div>
                        <?php include('comment_view.php'); ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                <div aria-label="Page navigation">
                    <ul class="pager">
                        <?php if($page == 1) : ?>
                            <li class="previous disabled"><a><span aria-hidden="true">&larr;</span> Newer</a></li>
                        <?php else : ?>
                            <li class="previous"><a href='timeline.php?page=<?php echo $page - 1; ?>'><span aria-hidden="true">&larr;</span> Newer</a></li>
                        <?php endif; ?>
                        <?php if($page == $last_page) : ?>
                            <li class="next disabled"><a>Older <span aria-hidden="true">&rarr;</span></a></li>
                        <?php else : ?>
                            <li class="next"><a href='timeline.php?page=<?php echo $page + 1; ?>'>Older <span aria-hidden="true">&rarr;</span></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include('layouts/footer.php'); ?>
</html>
