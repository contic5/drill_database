<?php
if(isset($_REQUEST['difficulty']))
{
  $resulttext='';
  $selecteddifficulty=$_REQUEST['difficulty'];
  $selectedcategory=$_REQUEST['category'];
  $conn = mysqli_connect("localhost","cjcuser","computing","Exercises");
  $query=sprintf("SELECT * FROM Drills WHERE Difficulty LIKE '%s' AND Category LIKE '%s' AND Hidden=False ORDER BY DifficultyID,Category,Name",$selecteddifficulty,$selectedcategory);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  $totalrows=mysqli_num_rows($result);
  $lastdifficulty='';
  $lastcategory='';
  $resulttext='';
  $resulttext.='<div class="mdc-data-table"><div class="mdc-data-table__table-container">';
  $resulttext.='<table class="mdc-data-table__table"><tbody class="mdc-data-table__content">';

  $disabledtext="disabled";
  if(isset($_SESSION['username']))
  {
    $disabledtext='';
  }
  while($row=mysqli_fetch_assoc($result))
  {
    $drillname=$row['Name'];
    $difficulty=$row['Difficulty'];
    $category=$row['Category'];
    if($lastdifficulty!=$difficulty)
    {
      $lastdifficulty=$difficulty;
      $resulttext.="<tr class='mdc-data-table__row'><td class='mdc-data-table__header-cell' style='font-size:24px;' colspan='5'>$difficulty</td></tr>";
    }
    if($lastcategory!=$category)
    {
      $lastcategory=$category;
      $resulttext.="<tr class='mdc-data-table__row'><td class='mdc-data-table__header-cell' style='font-size:18px;' colspan='5'>$category</td></tr>";
    }
    $resulttext.="<tr class='mdc-data-table__row'>";
    $resulttext.="<td class='mdc-data-table__cell'>".$drillname."</td><td>".$category."</td><td>".$difficulty."</td>";
    $ID=$row['ID'];
    $buttontext='hidedrill('.$ID.')';
    $mybutton='<button onclick='.$buttontext.'>Hide Drill</button>';
    $resulttext.="<td class='mdc-data-table__cell'>".$mybutton."</td>";

    $buttontext='deletedrill('.$ID.')';
    $mybutton='<button onclick='.$buttontext.' '.$disabledtext.'>Delete Drill</button>';
    $resulttext.="<td class='mdc-data-table__cell'>".$mybutton."</td>";

    $resulttext.="</tr>";
  }
  $resulttext.='</tbody></table>';
  $resulttext.="</div></div>";
  $resulttext.='<h3>Total Drills: '.$totalrows.'</h3>';
  print($resulttext);
}
?>
