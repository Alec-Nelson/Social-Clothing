<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Clothes</title>
<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/public/css/WhatToWeather.css">
<script src="<?= BASE_URL ?>/public/js/jquery-2.2.0.min.js"></script>
<script src="<?= BASE_URL ?>/public/js/weatherScripts.js"></script>
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/farbtastic.css"/>
<script src="<?= BASE_URL ?>/public/js/farbtastic.js"></script><?php
  if(strcmp($_SESSION['username'], $username) != 0)
  {
    echo '<style type="text/css">
        .node--leaf {
            pointer-events: none;
        }
        </style>';
  }
 ?>
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

<h1><?= $firstname?> Clothes</h1>
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
    if (isset($_SESSION['username']) && $_SESSION['username'] != '' )
    {
        if(strcmp($_SESSION['username'], $username) == 0)
        {
            echo '<form action="'.BASE_URL.'/posts/"><input type="submit" class="buttons" value="Post"></form>';
            echo '<form action="'.BASE_URL.'/profile/"><input type="submit" class="buttons" value="Profile"></form>';
            echo '<input id="addClothesButton" class="profileButtons buttons" type="submit" value="Add Clothes"/>';
        }
        else
        {
            echo '<div id="ProfileDiv">';
            if(!AppUser::loadByUsername($_SESSION['username'])->isFollowing($user_id))
            {
                echo '<input id="followButton"  class="profileButtons buttons" type="submit" value="Follow"/>';
            }
            else
            {
                echo '<input id="followButton" class="profileButtons buttons" type="submit" value="Unfollow"/>';
            }
            echo '<input id="hiddenId" type="hidden" value="'.$user_id.'">';
            echo '<form action="'.BASE_URL.'/profile/'.$user_id.'/"> <input id="clothesButton" type="submit"  class="profileButtons buttons" value="'.$firstname.'\'s Profile"></form></div>';
        }
    }
?>
<div id="addClothes">
  <script type="text/javascript">        
  $(document).ready(
    function()
    {
      $('#colorpicker').farbtastic('#clothingColor');
    });
  function colorFocus()
{
  $('div#colorpicker').show();
}
function colorBlur()
{
  $('div#colorpicker').hide();
}
</script>
<?php
  if(strcmp($_SESSION['username'], $username) == 0)
  {
 ?>
 <img id="exit" src="<?= BASE_URL ?>/public/img/exit.png" alt="A Weather Vein" height="12" width="12">
 <select class="dropDown" id="typeClothing" name="newClothingType">
      <option>Shirt</option>
      <option>Jacket</option>
      <option>Pants</option>
      <option>Shoes</option>
      <option>Hat</option>
    </select>
    <input id="clothingColor" name="newClothingName" class="settingsBox" type="text" value="#123456"/>
    <input id="nameClothing" class="settingsBox" type="text" placeholder="Name of Clothing" name="newClothingName"/>
    <div id="colorpicker"></div>
    <input id="clothingID" type="hidden" value="">
      <div class="but">
      <input id="submitClothingButton" class="buttons" type="submit" value="Enter Clothing"/>
      <input id="deleteClothingButton" class="buttons" type="submit" value="Delete Clothing"/>
      </div>
 <?php   
    }
  ?>
</div>


<div id="graphic">
<script src="//d3js.org/d3.v3.min.js"></script>
<script>

var margin = 20,
    diameter = 960;

var color = d3.scale.linear()
    .domain([-1, 5])
    .range(["hsl(152,80%,80%)", "hsl(228,30%,40%)"])
    .interpolate(d3.interpolateHcl);

var pack = d3.layout.pack()
    .padding(2)
    .size([diameter - margin, diameter - margin])
    .value(function(d) { return d.size; })

var svg = d3.select("body").append("svg")
    .attr("width", diameter)
    .attr("height", diameter)
  .append("g")
    .attr("transform", "translate(" + diameter / 2 + "," + diameter / 2 + ")");

d3.json("<?= BASE_URL ?>/profile/json/<?= $user_id ?>/", function(error, root) {
  if (error) throw error;

  var focus = root,
      nodes = pack.nodes(root),
      view;

  var circle = svg.selectAll("circle")
      .data(nodes)
    .enter().append("circle")
      .attr("class", function(d) { return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root"; })
      .style("fill", function(d) { return d.children ? color(d.depth) : d.color; })
      .on("click", function(d) { 
        if (focus !== d) {
          if(d.children)
          {
            zoom(d), d3.event.stopPropagation();
          }
          else
          {
            zoom(d.parent),d3.event.stopPropagation();

            leafClicked(d.id);
          }
        }
      });


  var text = svg.selectAll("text")
      .data(nodes)
    .enter().append("text")
      .attr("class", "label")
      .style("fill-opacity", function(d) { return d.parent === root ? 1 : 0; })
      .style("display", function(d) { return d.parent === root ? "inline" : "none"; })
      .text(function(d) { 
        if(!d.children && d.depth == 1)
          return "";
          else
          return d.name; });

  var node = svg.selectAll("circle,text");

  d3.select("body")
      .on("click", function() { zoom(root); });

  zoomTo([root.x, root.y, root.r * 2 + margin]);

  function zoom(d) {
    var focus0 = focus; focus = d;

    var transition = d3.transition()
        .duration(d3.event.altKey ? 7500 : 750)
        .tween("zoom", function(d) {
          var i = d3.interpolateZoom(view, [focus.x, focus.y, focus.r * 2 + margin]);
          return function(t) { zoomTo(i(t)); };
        });

    transition.selectAll("text")
      .filter(function(d) { return d.parent === focus || this.style.display === "inline"; })
        .style("fill-opacity", function(d) { return d.parent === focus ? 1 : 0; })
        .each("start", function(d) { if (d.parent === focus) this.style.display = "inline"; })
        .each("end", function(d) { if (d.parent !== focus) this.style.display = "none"; });
  }

  function zoomTo(v) {
    var k = diameter / v[2]; view = v;
    node.attr("transform", function(d) { return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")"; });
    circle.attr("r", function(d) { return d.r * k; });
  }
    function leafClicked(v)
  {
      $.get(
      'getclothing/?',
      { "clothingid": v }, "json")
      .done(function(data){
          // alert( "Data Loaded: " + data );
        if(data.success == 'success') {
          // successfully reached the server
          $("#clothingID").val(v);
          $('#addClothes').css("display", "inline-block");
          $('#deleteClothingButton').css("display", "inherit");
          $("#nameClothing").val(data.clothingname);
          $("#typeClothing").val(data.clothingtype);
          if(data.clothingcolor != '')
          {
            $('#clothingColor').val(data.clothingcolor);
          }
          else
          {
            $('#clothingColor').val('#123456');
          }
           
        } else if(data.error != '') {
          alert("Missing clothing.");
        } })
      .fail(function(jqXHR, textStatus, errorThrown){
          console.log(jqXHR);
          console.log(textStatus);
          console.log(errorThrown);
          alert("Ajax error: could not reach server. " + errorThrown );
      });
  };
});

d3.select(self.frameElement).style("height", diameter + "px");

</script>
</div>




</body>
</html>
