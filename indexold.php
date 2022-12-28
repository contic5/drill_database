<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel='stylesheet' href="material-components-web.min.css">
  <link rel='stylesheet' href="mystyle.css">
</head>
<body>
<?php
require("sessionstart.php");
?>
<h1>Drill Database</h1>
<?php
if(isset($_SESSION['username']))
{
  print("<p><a href='logout.php'>Log Out</a></p>");
}
else
{
  print("<p><a href='login.php'>Log In</a></p>");
}
?>
<h2>View Drills</h2>
<div id='drills' style='max-width:800px !important'></div>
<br>
<h3>Filter</h3>
<p>Difficulty:
<select name='selecteddifficulty' id='selecteddifficulty'>
<option value='%'>Any</option>
<option value='Easy'>Easy</option>
<option value='Medium'>Medium</option>
<option value='Hard'>Hard</option>
</select>
</p>

<p>
Category:
<select name='selectedcategory' id='selectedcategory'>
<option value='%'>Any</option>
<option value='Upper Body'>Upper Body</option>
<option value='Lower Body'>Lower Body</option>
<option value='Cardio'>Cardio</option>
<option value='Core'>Core</option>
<option value='Kicking'>Kicking</option>
<option value='Boxing'>Boxing</option>
<option value='Other'>Other</option>
</select>
</p>

<h3>Action Result</h3>
<div id='result'></div>
<?php
if(isset($_SESSION['username']))
{
?>
<form method='post' action='index.php'>
<h2>Add Drills</h2>
<p>Enter Drill Name:<br>
<input name='drillname' id='drillname' size=32></input>
</p>
Difficulty:
<select name='difficulty' id='difficulty'>
<option value='Easy'>Easy</option>
<option value='Medium'>Medium</option>
<option value='Hard'>Hard</option>
</select>

Category:
<select name='category' id='category'>
  <option value='Upper Body'>Upper Body</option>
  <option value='Lower Body'>Lower Body</option>
  <option value='Cardio'>Cardio</option>
  <option value='Core'>Core</option>
  <option value='Kicking'>Kicking</option>
  <option value='Boxing'>Boxing</option>
  <option value='Other'>Other</option>
</select>



</form>
<p><button onclick='adddrill()'>Add Drill</button></p>
<?php
}
?>
<p><button onclick='showalldrills()'>Show All Drills</button></p>

<script>
function getupdateddrills()
{
  var xmlhttp = new XMLHttpRequest();
  var selecteddifficulty=document.getElementById('selecteddifficulty').value;
  var selectedcategory=document.getElementById('selectedcategory').value;

  //alert(selecteddifficulty);
  xmlhttp.onreadystatechange = function()
  {
      if (this.readyState == 4 && this.status == 200)
      {
          //alert(this.responseText);
          document.getElementById('drills').innerHTML=this.responseText;
      }
  };
  xmlhttp.open("GET", "getdrills.php?difficulty="+selecteddifficulty+'&category='+selectedcategory, true);
  xmlhttp.send();
}

function adddrill()
{
  var drillname=document.getElementById('drillname').value;
  var difficulty=document.getElementById('difficulty').value;
  var category=document.getElementById('category').value;
  var xmlhttp2 = new XMLHttpRequest();
  xmlhttp2.onreadystatechange = function()
  {
      if (this.readyState == 4 && this.status == 200)
      {
        document.getElementById("result").innerHTML = this.responseText;
        getupdateddrills();
      }
  };
  xmlhttp2.open("POST", "adddrill.php?drillname=" + drillname+'&difficulty='+difficulty+'&category='+category, true);
  xmlhttp2.send();
}
function deletedrill(drillid)
{
  var xmlhttp2 = new XMLHttpRequest();
  xmlhttp2.onreadystatechange = function()
  {
      if (this.readyState == 4 && this.status == 200)
      {
        document.getElementById("result").innerHTML = this.responseText;
        getupdateddrills();
      }
  };
  xmlhttp2.open("POST", "deletedrill.php?drillid=" + drillid, true);
  xmlhttp2.send();
}

function hidedrill(drillid)
{
  var xmlhttp2 = new XMLHttpRequest();
  xmlhttp2.onreadystatechange = function()
  {
      if (this.readyState == 4 && this.status == 200)
      {
        document.getElementById("result").innerHTML = this.responseText;
        getupdateddrills();
      }
  };
  xmlhttp2.open("POST", "hidedrill.php?drillid=" + drillid, true);
  xmlhttp2.send();
}

function showalldrills()
{
  var xmlhttp2 = new XMLHttpRequest();
  xmlhttp2.onreadystatechange = function()
  {
      if (this.readyState == 4 && this.status == 200)
      {
        getupdateddrills();
      }
  };
  xmlhttp2.open("POST", "showalldrills.php", true);
  xmlhttp2.send();
}

function checkdrillcount()
{
  var xmlhttp3 = new XMLHttpRequest();
  xmlhttp3.onreadystatechange = function()
  {
      if (this.readyState == 4 && this.status == 200)
      {
        curdrillcount=this.responseText;
        if(curdrillcount!=newdrillcount)
        {
          getupdateddrills();
        }
        newdrillcount=curdrillcount;
      }
  };
  xmlhttp3.open("POST", "getdrillcount.php", true);
  xmlhttp3.send();
}
$(document).ready(function()
{
  $('#selecteddifficulty').change(function()
  {
       getupdateddrills();
   });
   $('#selectedcategory').change(function()
   {
     getupdateddrills();
   });
});
showalldrills();
getupdateddrills();
//var myVar = setInterval(getupdateddrills, 1000);
var drill_div_new='';
var curdrillcount=0;
var newdrillcount=0;
</script>
</form>
</body>
</html>
