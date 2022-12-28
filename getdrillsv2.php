<?php
if(isset($_REQUEST['difficulty']))
{
  $resulttext='';
  $selecteddifficulty=$_REQUEST["difficulty"];
  $selectedcategory=$_REQUEST["category"];
  $conn = mysqli_connect("localhost","cjcuser","computing","Exercises");
  $query=sprintf("SELECT * FROM Drills WHERE Difficulty LIKE '%s' AND Category LIKE '%s' AND Hidden=False ORDER BY DifficultyID,Category,Name",$selecteddifficulty,$selectedcategory);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  $totalrows=mysqli_num_rows($result);
  
  $disabledtext="disabled";

  $drills=[];
  $difficulties=[];
  $categories=[];
  $ids=[];

  if(isset($_SESSION['username']))
  {
    $disabledtext='';
  }
  while($row=mysqli_fetch_assoc($result))
  {
    $drillname=$row['Name'];
    $difficulty=$row['Difficulty'];
    $category=$row['Category'];
    $id=$row["ID"];
    
    array_push($drills,$drillname);
    array_push($difficulties,$difficulty);
    array_push($categories,$category);
    array_push($ids,$id);
  }

  $maxid=0;
  $query=sprintf("SELECT ID FROM Drills ORDER BY ID DESC LIMIT 1");
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  while($row=mysqli_fetch_assoc($result))
  {
    $maxid=$row["ID"];
  }

  $res=array("drills"=>$drills,"difficulties"=>$difficulties,"categories"=>$categories,"ids"=>$ids,"maxid"=>$maxid);
  $res_json=json_encode($res);
  print($res_json);
}
?>
