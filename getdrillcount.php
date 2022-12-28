<?php
$conn = mysqli_connect("localhost","cjcuser","computing","Exercises");
$query=sprintf("SELECT * FROM Drills");
$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
$rows = mysqli_num_rows($result);
print($rows);
?>
