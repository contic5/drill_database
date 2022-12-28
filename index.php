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
$username="";
if(isset($_SESSION['username']))
{
  $username=$_SESSION['username'];
  print("<h2>Hello ".$_SESSION["username"]."</h2>");
  print("<p><a href='logout.php'>Log Out</a></p>");
}
else
{
  print("<h2>Hello Guest</h2>");
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
<p><button onclick='showalldrills()'>Show All Drills</button></p>

<h3>Action Result</h3>
<div id='result'></div>
<?php
if(isset($_SESSION['username']))
{
?>
<form method='post' action='index.php'>
<h2>Add Drills</h2>
<p>Enter Drill Name:<br>
<input name='drillname' id='drillname' size=32>
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
function displaydrills()
{
  let lastdifficulty="";
  let lastcategory="";

  let result=document.getElementById("result");
  if(result.childNodes[0])
  {
    result.removeChild(result.childNodes[0]); 
  }

  let outerdiv=document.createElement("div");
  outerdiv.classList.add("mdc-data-table");

  let innerdiv=document.createElement("div");
  innerdiv.classList.add("mdc-data-table__table-container");
  outerdiv.appendChild(innerdiv);

  let table=document.createElement("table");
  table.classList.add("mdc-data-table__table");
  innerdiv.appendChild(table);

  let tbody=document.createElement("tbody");
  tbody.id="tbody";
  tbody.classList.add("mdc-data-table_content");
  table.appendChild(tbody);
  for(let i=0;i<drills.length;i++)
  {
    let drill=drills[i];
    let difficulty=dr_difficulties[i];
    let category=dr_categories[i];
    let id=ids[i];
    let hidden=hidden_arr[i];

    if(!hidden)
    {
      if(lastdifficulty!=difficulty)
      {
        //"<tr class='mdc-data-table__row'><td class='mdc-data-table__header-cell' style='font-size:24px;' colspan='5'>$difficulty</td></tr>";
        let difficultyrow=document.createElement("tr");
        tbody.classList.add('mdc-data-table__row');
        tbody.appendChild(difficultyrow);

        let difficultytd=document.createElement("td");
        difficultytd.classList.add("mdc-data-table__cell");
        difficultytd.classList.add("difficultyrowcell");
        difficultytd.innerHTML=difficulty;
        difficultyrow.appendChild(difficultytd);
      }
      if(lastcategory!=category)
      {
        let categoryrow=document.createElement("tr");
        tbody.classList.add('mdc-data-table__row');
        tbody.appendChild(categoryrow);

        let categorytd=document.createElement("td");
        categorytd.classList.add("mdc-data-table__cell");
        categorytd.classList.add("categoryrowcell");
        categorytd.innerHTML=category;
        categoryrow.appendChild(categorytd);
      }

      let row=document.createElement("tr");
      row.classList.add("mdc-data-table__row");
      row.id=id;

      let drill_td=document.createElement("td");
      drill_td.innerHTML=drill;
      drill_td.classList.add("mdc-data-table__cell");
      row.appendChild(drill_td);

      let difficulty_td=document.createElement("td");
      difficulty_td.innerHTML=difficulty;
      difficulty_td.classList.add("mdc-data-table__cell");
      row.appendChild(difficulty_td);

      let category_td=document.createElement("td");
      category_td.innerHTML=category;
      category_td.classList.add("mdc-data-table__cell");
      row.appendChild(category_td);

      let hide_td=document.createElement("td");
      hide_td.classList.add("mdc-data-table__cell");
      row.appendChild(hide_td);

      let hidebutton=document.createElement("button");
      hidebutton.innerHTML="Hide";
      hidebutton.onclick=function()
      {
        console.log("Hide row "+i);
        hidden_arr[i]=true;
        displaydrills();
      }
      hide_td.appendChild(hidebutton);

      if(username!="")
      {
        let delete_td=document.createElement("td");
        delete_td.classList.add("mdc-data-table__cell");
        row.appendChild(delete_td);

        let deletebutton=document.createElement("button");
        deletebutton.innerHTML="Delete";
        deletebutton.onclick=function()
        {
          deletedrill(id);
        }
        delete_td.appendChild(deletebutton);
      }

      tbody.appendChild(row);

      lastcategory=category;
      lastdifficulty=difficulty;
    }
  }
  result.appendChild(outerdiv);
}

function adddrilltotable(id,drill,difficulty,category)
{
  let tbody=document.getElementById("tbody");
  console.log(tbody!=null);

  let row=document.createElement("tr");
  row.classList.add("mdc-data-table__row");
  row.id=id;

  let drill_td=document.createElement("td");
  drill_td.innerHTML=drill;
  drill_td.classList.add("mdc-data-table__cell");
  row.appendChild(drill_td);

  let difficulty_td=document.createElement("td");
  difficulty_td.innerHTML=difficulty;
  difficulty_td.classList.add("mdc-data-table__cell");
  row.appendChild(difficulty_td);

  let category_td=document.createElement("td");
  category_td.innerHTML=category;
  category_td.classList.add("mdc-data-table__cell");
  row.appendChild(category_td);

  let hide_td=document.createElement("td");
  hide_td.classList.add("mdc-data-table__cell");
  row.appendChild(hide_td);

  let hidebutton=document.createElement("button");
  hidebutton.innerHTML="Hide";
  hidebutton.onclick=function()
  {
    console.log("Hide row "+i);
    hidden_arr[i]=true;
    displaydrills();
  }
  hide_td.appendChild(hidebutton);

  if(username!="")
  {
    let delete_td=document.createElement("td");
    delete_td.classList.add("mdc-data-table__cell");
    row.appendChild(delete_td);

    let deletebutton=document.createElement("button");
    deletebutton.innerHTML="Delete";
    deletebutton.onclick=function()
    {
      deletedrill(id);
    }
    delete_td.appendChild(deletebutton);
  }
  tbody.appendChild(row);
}

function hiderow(i)
{
  console.log("Hide row "+i);
  hidden_arr[i]=true;
  displaydrills();
}

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
          console.log("Ready response changed");
          //alert(this.responseText);
          let res=JSON.parse(this.responseText)
          drills=res.drills;
          dr_difficulties=res.difficulties;
          dr_categories=res.categories;
          ids=res.ids;
          
          hidden_arr=[];
          for(let i=0;i<drills.length;i++)
          {
            hidden_arr.push(false);
          }

          console.log("Getting updated drills");
          displaydrills();
      }
  };
  xmlhttp.open("GET", "getdrillsv2.php?difficulty="+selecteddifficulty+'&category='+selectedcategory, true);
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
        //document.getElementById("result").innerHTML = this.responseText;
        //getupdateddrills();
        maxid+=1;
        adddrilltotable(maxid,drillname,difficulty,category);
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
        //document.getElementById("result").innerHTML = this.responseText;
        //getupdateddrills();

        let row = document.getElementById(drillid);
        row.parentNode.removeChild(row);
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
  for(let i=0;i<hidden_arr.length;i++)
  {
    hidden_arr[i]=false;
  }
  displaydrills();
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

//var myVar = setInterval(getupdateddrills, 1000);
var drill_div_new='';
var curdrillcount=0;
var newdrillcount=0;

let drills=[];
let dr_difficulties=[];
let dr_categories=[];
let hidden_arr=[];
let ids=[];
let maxid=0;

let username="<?php echo $username;?>";
console.log("Username= "+username);
getupdateddrills();
</script>
</form>
</body>
</html>
