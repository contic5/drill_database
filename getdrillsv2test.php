<html>
<head></head>
<body>
<?php
if(true)
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

  if(isset($_SESSION['username']))
  {
    $disabledtext='';
  }
  while($row=mysqli_fetch_assoc($result))
  {
    $drillname=$row['Name'];
    $difficulty=$row['Difficulty'];
    $category=$row['Category'];
    
    array_push($drills,$drillname);
    array_push($difficulties,$difficulty);
    array_push($categories,$category);
  }
  $res=array("drills"=>$drills,"difficulties"=>$difficulties,"categories"=>$categories);
  $res_json=json_encode($res);
  print($drills[0]);
}
?>
</body>
</html>
