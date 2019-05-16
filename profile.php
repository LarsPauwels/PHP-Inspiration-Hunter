<?php

    require_once("bootstrap/bootstrap.php");

    // upload profile picture part
    if (isset($_POST["profilePic"])) {
        $file = new File();
        $file->setFile($_FILES["profilePic"]);
        $file->setType("Image");
        if ($file->uploadFile("profile_pic")) {
            User::updateProfilePic();
        }
    }

    if (isset($_GET["user"])) {
        User::getUser($_GET["user"]);
    } else {
        header("Location: index");
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cssgram-cssgram.netdna-ssl.com/cssgram.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
</head>
<body>

    <header>
        <a href="index">
            <img src="images/full_logo.png" class="logo">
        </a>
    </header>

    <nav>
        <a href="index">
            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
        </a>

        <ul id="menu">
            <a href="index">
                <li>
                    <i class="fas fa-compass"></i>
                    <span class="tooltiptext">Explore</span>
                </li>
            </a>
            <a href="locations">
                <li>
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="tooltiptext">Locations</span>
                </li>
            </a>
            <a href="profile?user=<?php echo htmlspecialchars($_SESSION['user']['username']);?>">
                <li class="active">
                    <i class="fas fa-user"></i>
                    <span class="tooltiptext">Users</span>
                </li>
            </a>
        </ul>
        <ul id="submenu">
            <li>
                <a href="settings">
                    <i class="fas fa-cog"></i>
                    <span class="tooltiptext">Settings</span>
                </a>
            </li>
            <li>
                <a href="logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="tooltiptext">Log Out</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="banner">
        <div class="gradient">
            
        </div>
        <div class="center-profile">
            <div class="profile-pic" style="background-image: url(<?php echo "uploads/profile_pic/" . $_SESSION["userDetails"]["profile_pic"] ?>);">
                <?php if ($_GET["user"] == $_SESSION["user"]["username"]): ?>
                    <form method="post" action enctype="multipart/form-data">
                        <label class="upload-new" for="upload">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span class="tooltiptext">New Profile Picture</span>
                        </label>
                        <input type="file" name="profilePic" id="upload">
                        <div class="bottom-content">
                            <button id="btn" name="profilePic">Send</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>

            <div class="info-user">
                <p><?php echo htmlspecialchars($_SESSION["userDetails"]["username"]); ?></p>
                <ul>
                    <li>
                        <span><?php echo Post::getUserAmountPost($_GET["user"]); ?></span> Posts
                    </li>
                    <li>
                        <span><?php echo User::getFollowers($_GET["user"]); ?></span> Followers
                    </li>
                    <li>
                        <span><?php echo User::getFollowing($_GET["user"]); ?></span> Following
                    </li>
                </ul>
                <p class="description">
                    <?php echo htmlspecialchars($_SESSION["userDetails"]["description"]); ?>
                </p>
            </div>
        </div>
    </div>

    <div id="reload">
        <section>
            <?php
                if (isset($_POST["amount"])) {
                    $amount = $_POST["amount"];
                } else {
                    $amount = 20;
                }

                if (isset($_GET["user"]) && !empty($_GET["user"])) {
                    $posts = Post::getPostUser($_GET["user"], $amount);
                }

                if (!empty($posts)):
                    foreach ($posts as $post):
            ?>
                <div class="posts-container">
                    <article>
                        <div class="post-header">
                            <div class="user-container">
                                <div class="user" style="background-image: url(<?php echo "uploads/profile_pic/".$post["profile_pic"]; ?>);"></div>
                                <p class="name"><?php echo htmlspecialchars($post["username"]); ?></p>
                                <span>
                                    <?php echo Date::getTimePast($post["postTimestamp"]); ?>
                                </span>
                            </div>
                        </div>
                        <div class="post-image <?php echo $post['class']?>" style="background-image: url(<?php echo "uploads/feed/".$post["image"] ?>);"></div>
                        <ul class="info">
                            <li>
                                <a href="#" data-id="<?php echo $post['postId']?>">
                                    <i class="fas fa-heart like <?php if(!Like::alreadyLiked($_SESSION['user']['id'], $post['postId'])) { echo 'already-liked'; } ?>"></i>
                                </a>
                                <span class="likes"><?php echo Like::getLikes($post['postId']); ?></span>
                            </li>
                            <li>
                                <i class="fas fa-comment"></i>
                                <span class="comments"><?php echo Comment::countComments($post['postId']); ?></span>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fas fa-share-alt"></i>
                                </a>
                            </li>
                            <li class="right">
                                <a href="#" data-post="<?php echo $post['postId']; ?>">
                                    <i class="fas fa-times delete"></i>
                                </a>
                            </li>
                        </ul>
                        <p class="comment"><a href="profile?user=<?php echo htmlspecialchars($post['username']); ?>" class="username"><?php echo htmlspecialchars($post["username"]); ?></a> <?php echo htmlspecialchars($post["postDescription"]); ?></p>
                        <div class="chat">
                            <div class="load-comments" data-post="<?php echo $post['postId']?>">

                            </div>
                            <hr>
                            <div class="message-container">
                                <input type="text" name="message" placeholder="Add a comment..." class="message" data-post="<?php echo $post['postId']; ?>">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                        </div>
                    </article>
                    </div>
                <?php
                    endforeach;
                        if(sizeof($posts) < Post::getAmountPost()[0]):
                ?>
                    <div class="load-more-container">
                        <button type="button" class="load-more">Load More</button>
                    </div>
                <?php
                        endif;
                    else:
                ?>
                    <div class="empty-state">
                        <img src="images/empty.png">
                        <h1>No entry found!</h1>
                        <p>There are no posts with this tag. So this tag can be for you alloon. <a href="upload">Wan't to use it?</a></p>
                    </div>
                <?php
                    endif;
                ?>
        </section>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/header.js"></script>
    <script src="js/like_post.js"></script>
    <script src="js/load_more.js"></script>
    <script src="js/comment_post.js"></script>
    <script src="js/profile.js"></script>
</body>
</html>