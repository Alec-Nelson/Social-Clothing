<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Profile</title>
<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/public/css/WhatToWeather.css">
<script src="<?= BASE_URL ?>/public/js/jquery-2.2.0.min.js"></script>
<script src="<?= BASE_URL ?>/public/js/weatherScripts.js"></script>
</head>
<body>

<ul>
    <li><a href="<?= BASE_URL ?>/about/">About  </a></li>
    <li><a href="<?= BASE_URL ?>/settings/">Settings</a></li>
    <li><a href="<?= BASE_URL ?>/profile/">Profile </a></li>
    <li><a href="<?= BASE_URL ?>/">Home</a></li>
    <li hidden id="weather" ><a id="wtext"></a></li>
</ul>

<h1><?= $firstname?> <?= $lastname ?>(<?= $username ?>)</h1>
<?php 
    if (isset($_SESSION['username']) && $_SESSION['username'] != '' ) 
    {
        if(strcmp($_SESSION['username'], $username) == 0)
        {
            echo '<form action="'.BASE_URL.'/posts/"><input type="submit" class="buttons" value="Post"></form>';
            echo '<form action="'.BASE_URL.'/profile/graphic/"><input type="submit" class="buttons" value="Your Clothes"></form>';
        }
        else 
        {
            echo '<div id="profileButtons">';
            if(!AppUser::loadByUsername($_SESSION['username'])->isFollowing($user_id))
            {
                echo '<input id="followButton" class="profileButtons buttons" type="submit" value="Follow"/>';
            }
            else
            {
                echo '<input id="followButton" class="profileButtons buttons" type="submit" value="Unfollow"/>';
            }
            echo '<input id="hiddenId" type="hidden" value="'.$user_id.'">';
            echo '<form action="'.BASE_URL.'/profile/'.$user_id.'/graphic"> <input id="clothesButton" type="submit" class="profileButtons buttons" value="'.$firstname.'\'s Clothes"></form></div>';
        }
    }
    ?>
<?php
    if( isset($_SESSION['username']) && $_SESSION['username'] != '') {
        echo '<h2 id=feed>'.$firstname.'\'s Feed</h2>';
        echo '<div class="feed">';
        if(empty($posts))
        {
            echo '<h3>No posts to display</h3>';
        }
        else
        {
            for($i = 0; $i < count($posts) && $i < 3; ++$i) {
                echo '<div class="post"><span>'.$clothingString[$i].' </span>';
                echo '<p class="post">'.$posts[$i]->get('message').'</p>';
                echo '<span>Posted By: </span>';
                echo '<a href="'.BASE_URL.'/profile/'.$authors[$i]->get('id').'">'.$authors[$i]->get('username').'</a>';
                echo '<span>  On: '.date("F j, Y", strtotime($posts[$i]->get('date_created'))).'</span></div>';
            }
        }
        echo '</div>';
    }
?>


<span id="error">
    <?php
            if(isset($_SESSION['error']))
            {
                if($_SESSION['error'] != '')
                {
                    echo $_SESSION['error'];
                    $_SESSION['error'] = '';
                }
            }
        ?>
</span>

<?php
    if( !isset($_SESSION['username']) || $_SESSION['username'] == '') {
?>
<p id="userStatus" class="userStatus"></p>
<form id="register" method="POST" action="<?= BASE_URL ?>/signup/user">
<div class="textBox">
    <input id="email" type="text" placeholder=" Email" name="email"/>
    <input id="uname" type="text" placeholder=" Username" name="uname" />
    <input id="pass" type="password" placeholder=" Password" name="pass"/>
    <input id="pass2" type="password" placeholder=" Confirm Password" name="pass2"/>
</div>
<div class="but">
    <input id="signUpButton" class="buttons" type="submit" value="Sign Up" />
</div>
</form>

        <?php
            } else {
        ?>

            <p>Logged in as <strong><?= $_SESSION['username'] ?></strong>. <a href="<?= BASE_URL ?>/logout">Log out?</a></p>

        <?php
            }
        ?>

<p class="description">
<!-- Making an account will allow you to recieve messages and texts, and will allow you personalize your clothing for the weather you like it at. -->
</p>

</body>
</html>
