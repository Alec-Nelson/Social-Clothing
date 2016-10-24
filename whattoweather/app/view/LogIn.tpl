<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Log In Page</title>
<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/public/css/WhatToWeather.css">
<script src="<?= BASE_URL ?>/public/js/jquery-2.2.0.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/public/js/weatherScripts.js"></script>
</head>
<body>
<ul>
    <li><a href="<?= BASE_URL ?>/about/">About  </a></li>
    <li><a href="<?= BASE_URL ?>/settings/">Settings</a></li>
    <li><a href="<?= BASE_URL ?>/profile/">Profile </a></li>
    <li><a href="<?= BASE_URL ?>/">Home</a></li>
    <li hidden id="weather" ><a id="wtext"></a></li>
</ul>
<h1>What to Weather</h1>

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


	<form method="POST" action="<?= BASE_URL ?>/login">
	<div class="textBox">
		<input id="logInUserName" type="text" placeholder=" User Name" name="uname" />
		<input id="logInPassword" type="password" placeholder=" Password" name="pass"	/>
	</div>

	<div class="but">
		<input id="logInButton" class ="buttons" type="submit" value="Log In" name="submit"/>
	</div>
	</form>

	<form method="POST" action="<?= BASE_URL ?>/signup">
	<div class="but">
		<input id="signUpButton" class ="buttons" type="submit" value="Sign Up"/>
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
	Let the world know what the weather is near you and what your recommended outfit is! View live feed of the weather near other users around the world!
</p>

<p id="linkToAbout">
	<a href="<?= BASE_URL ?>/about">What is What to Weather About?</a>
</p>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<?php
	if( isset($_SESSION['username']) && $_SESSION['username'] != '') {
		echo '<h2 id=feed>My Feed</h2>';
		echo '<form action="'.BASE_URL.'/posts/"><input type="submit" class="buttons" id="homepost" value="Post"></form>';
		echo '<div id="tabs"><h3 id="global" class="tab">Global</h3>';
		echo '<h3 id="following" class="tab">Following</h3></div>';
		echo '<div class="feed"><div id="global">';
		
		for($i = 0; $i < count($posts) && $i < 5; ++$i) {
				echo '<div class="post"><span>'.$clothingString[$i].' </span>';
	    		echo '<p class="post">'.$posts[$i]->get('message').'</p>';
	    		echo '<span>Posted By: </span>';
    		echo '<a href="'.BASE_URL.'/profile/'.$posts[$i]->get('author_id').'">'.$authors[$i]->get('username').'</a>';
    		echo '<span>  On: '.date("F j, Y", strtotime($posts[$i]->get('date_created'))).'</span>';
    		if($posts[$i]->get('location') != ''){
    			echo '<span> Location: '.$posts[$i]->get('location');
    		}
    		if(($_SESSION['admin'] == 0 && ($_SESSION['username'] != $authors[$i]->get('username'))) ){
    			echo '<form method="POST" action="'.BASE_URL.'/ban/"> <input type="hidden" name="id" value="'.$posts[$i]->get('author_id').'"> <input type="submit" value="Ban"> </form>';
		}
		echo '</div>';
		}
		echo '</div><div id="following">';
        if(count($followingPosts) == 0)
        {
            echo '<span>No posts to display</span>';
        }
        else {
    		for($i = 0; $i < count($followingPosts) && $i < 5; ++$i) {
    			echo '<div class="post"><span>'.$followingClothingString[$i].' </span>';
        		echo '<p class="post">'.$followingPosts[$i]->get('message').'</p>';
        		echo '<span>Posted By: </span>';
        		echo '<a href="'.BASE_URL.'/profile/'.$followingPosts[$i]->get('author_id').'">'.$followingAuthors[$i]->get('username').'</a>';
        		echo '<span>  On: '.date("F j, Y", strtotime($followingPosts[$i]->get('date_created'))).'</span>';
        		if($posts[$i]->get('location') != ''){
    				echo '<span> Location: '.$followingPosts[$i]->get('location');
    			}
        		if(($_SESSION['admin'] == 0 && ($_SESSION['username'] != $followingAuthors[$i]->get('username'))) ){
        			echo '<form method="POST" action="'.BASE_URL.'/ban/"> <input type="hidden" name="id" value="'.$followingPosts[$i]->get('author_id').'"> <input type="submit" value="Ban"> </form>';
        		}
        		echo '</div>';
    		}
        }

		echo '</div></div>';
	}
?>
</body>
</html>
