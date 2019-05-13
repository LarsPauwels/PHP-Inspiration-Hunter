<?php

    require_once("bootstrap/bootstrap.php");

    // upload profile picture part
    if (!empty($_POST["profilePic"])) {
        $file = new File();
        $file->setFile($_FILES["profilePic"]);
        $file->setType("Image");
        if ($file->uploadFile("profile_pic")) {
            User::updateProfilePic();
        }
    }

    // update description part
    if (!empty($_POST["updateDescription"])) {
        $user = new User();
        $user->setDescription($_POST["description"]);
        $user->updateDescription();
    }

    // update email part
    if (!empty($_POST["updateEmail"])) {
        $user = new User();
        $user->setEmail($_POST["email"]);
        $user->setPassword($_POST["password"]);
        $user->updateEmail();
    }

    // update password part
    if (!empty($_POST["updatePassword"])) {
        $user = new User();
        $user->setPassword($_POST["newPassword"]);
        $user->setConfirmPassword($_POST["confirmPassword"]);
        $user->setOldPassword($_POST["oldPassword"]);
        $user->updatePassword();
    }

    if (isset($_GET["user"])) {
        User::getUser($_GET["user"]);
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update email</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
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
            <li class="active">
                <a href="index">
                    <i class="fas fa-compass"></i>
                    <span class="tooltiptext">Explore</span>
                </a>
            </li>
            <li>
                <i class="fas fa-ghost"></i>
                <span class="tooltiptext">Stories</span>
            </li>
            <li>
                <i class="fas fa-user"></i>
                <span class="tooltiptext">Users</span>
            </li>
            <li>
                <i class="fas fa-map-marker-alt"></i>
                <span class="tooltiptext">Locations</span>
            </li>
        </ul>
        <ul id="submenu">
            <li>
                <i class="fas fa-cog"></i>
                <span class="tooltiptext">Settings</span>
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
            <div class="profile-pic">
                <div class="upload-new">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span class="tooltiptext">New Profile Picture</span>
                </div>
            </div>

            <div class="info-user">
                <p><?php echo $_SESSION["userDetails"]["username"]; ?></p>
                <ul>
                    <li>
                        <span><?php echo Post::getUserAmountPost($_GET["user"]); ?></span> Posts
                    </li>
                    <li>
                        <span>12k</span> Followers
                    </li>
                    <li>
                        <span>214</span> Following
                    </li>
                </ul>
                <p class="description">
                    <?php echo $_SESSION["userDetails"]["description"]; ?>
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

                if (isset($_GET["q"]) && !empty($_GET["q"])) {
                    $posts = Post::searchPost($_GET["q"], $amount);
                } else {
                    $posts = Post::getPost($amount);
                }

                if (!empty($posts)):
                    foreach ($posts as $post):
            ?>
                <div class="posts-container">
                    <article>
                        <div class="post-header">
                            <div class="user-container">
                                <div class="user" style="background-image: url(<?php echo "uploads/profile_pic/".$post["profile_pic"]; ?>);"></div>
                                <p class="name"><?php echo $post["firstname"]." ".$post["lastname"]; ?></p>
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
                        <p class="comment"><a href="#" class="username"><?php echo $post["username"]; ?></a> <?php echo $post["postDescription"]; ?></p>
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
            <!--<form action="" method="POST" enctype="multipart/form-data">
                <h2>Upload profile picture</h2>

                <div>
                    <label for="profilePic">Upload profile pic</label>
                    <input type="file" name="profilePic">
                </div>

                <div class="form__field">
                    <input  name="profilePic" type="submit" value="Upload profile pic">
                </div>

            </form>

            <form action="" method="POST">
                <h2>Update description</h2>

                <div>
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description">
                </div>

                <div class="form__field">
                    <input name="updateDescription" type="submit" value="Update description">
                </div>

            </form>
            <form action="" method="POST">
                <h2>Update email</h2>

                <div>
                   <label for="email">New email</label>
                   <input type="email" name="email" id="email">
               </div>

               <div>
                   <label for="password">Password</label>
                   <input type="password" name="password" id="password">
               </div>

               <div class="form__field">
                   <input name="updateEmail" type="submit" value="Update email">	
               </div>

           </form>
           <form action="" method="POST">
                <h2>Update password</h2>

                <div>
                    <label for="oldPassword">Current password</label>
                    <input type="password" name="oldPassword" id="oldPassword">
                </div>

                <div>
                    <label for="newPassword">New password</label>
                    <input type="password" name="newPassword" id="newPassword">
                </div>

                <div>
                    <label for="confirmPassword">Confirm new password</label>
                    <input type="password" name="confirmPassword" id="confirmPassword">
                </div>

                <div class="form__field">
                    <input name="updatePassword" type="submit" value="Update password">
                </div>
            </form>-->
        </section>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/header.js"></script>
</body>
</html>