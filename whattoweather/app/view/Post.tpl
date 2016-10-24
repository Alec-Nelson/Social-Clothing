<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Post Clothes</title>
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
<img class="Umbrella" src="<?= BASE_URL ?>/public/img/weatherVein.jpg" alt="A Weather Vein" height="100" width="100">

<h1>Post Clothes</h1>
<span id="error"></span>
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

<form id="postClothing"  method="POST" action="<?= BASE_URL ?>/posts/submit">
<select class="dropDown" name="chosenShirt" id="Shirts">
	<option>Shirt</option>
	<?php
	echo '<option value="0">None</option>';
	if (sizeof($clothes) >= 1) {

	foreach($clothes as $clothing) {
			$clothingID = $clothing->get('id');
			$clothingName = $clothing->get('clothingname');
			$clothingType = $clothing->get('clothingtype');
			if ($clothingType == 'Shirt')
			{
				echo '<option value="'.$clothingID.'">'.$clothingName.'</option>';
			}
	}
	}
	?>
</select>
<select class="dropDown" name="chosenJacket" id="Jackets" >
	<option>Jacket</option>
	<?php
	echo '<option value="0">None</option>';
	if (sizeof($clothes) >= 1) {

	foreach($clothes as $clothing) {
			$clothingID = $clothing->get('id');
			$clothingName = $clothing->get('clothingname');
			$clothingType = $clothing->get('clothingtype');
			if ($clothingType == 'Jacket')
			{

				echo '<option value="'.$clothingID.'">'.$clothingName.'</option>';
			}
	}
	}
	?>
</select>
<select class="dropDown" name="chosenPants" id="Pants">
	<option>Pants</option>
	<?php
	echo '<option value="0">None</option>';
	if (sizeof($clothes) >= 1) {

	foreach($clothes as $clothing) {
			$clothingID = $clothing->get('id');
			$clothingName = $clothing->get('clothingname');
			$clothingType = $clothing->get('clothingtype');
			if ($clothingType == 'Pants')
			{
				echo '<option value="'.$clothingID.'">'.$clothingName.'</option>';
			}
	}
	}
	?>
</select>
<select class="dropDown" name="chosenShoes" id="Shoes" >
	<option>Shoes</option>
	<?php
	echo '<option value="0">None</option>';
	if (sizeof($clothes) >= 1) {

	foreach($clothes as $clothing) {
			$clothingID = $clothing->get('id');
			$clothingName = $clothing->get('clothingname');
			$clothingType = $clothing->get('clothingtype');
			if ($clothingType == 'Shoes')
			{
				echo '<option value="'.$clothingID.'">'.$clothingName.'</option>';
			}
	}
	}
	?>
</select>
<select class="dropDown" name="chosenHat" id="Hats" >
	<option>Hat</option>
	<?php
	echo '<option value="0">None</option>';
	if (sizeof($clothes) >= 1) {

	foreach($clothes as $clothing) {
			$clothingID = $clothing->get('id');
			$clothingName = $clothing->get('clothingname');
			$clothingType = $clothing->get('clothingtype');
			if ($clothingType == 'Hat')
			{
				echo '<option value="'.$clothingID.'">'.$clothingName.'</option>';
			}
	}
	}
	?>
</select>
<!-- <input id="tempMin" class="settingsBox" type="text" placeholder="Min Temp F -->
<!-- <input id="nameClothing" class="settingsBox" type="text" placeholder="Name of Clothing" name="newClothingName"/> -->
<div class="but">
	<input id="postClothingButton" class="buttons" type="submit" value="Post Clothing"/>
	</div>
	<textarea id="message"  name="message" class="settingsBox" placeholder = "Tell the world about your weather!"></textarea>

</div>
	<input type = "hidden" id="location" name = "location" value="">
</form>



</body>
</html>
