<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>About</title>
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
<img class="Umbrella" src="<?= BASE_URL ?>/public/img/weatherVein.jpg" alt="A weather Vein" height="100" width="100">
<h1>What to Weather</h1>
<h2>What can What to Weather do </h2>
<img id="duckPondImage" src="<?= BASE_URL ?>/public/img/rain.jpg" alt="Rain" height="300" width="500">
<p id="aboutDesc">
	What to Weather is your social media weather app! After giving permission to access your location, our app will let you know what the weather is near you. Use What to Weather to keep the world updated on the weather around you, and to find out what people are wearing with the weather near them. Users can follow other users to display the feed just from their followed users, or just check the global feed. Save your entire wardrobe in order to make posting a breeze! It's Twitter for Weather! Make an account today.
</p>
<?php
	if( !isset($_SESSION['username'])){
?>

<form method="POST" action="<?= BASE_URL ?>/signup">
	<div class="but">
		<input class="buttons" id="aboutButton" type="submit" value="Get Started"/>
	</div>
</form>
<?php
	}
?>
</body>
</html>
