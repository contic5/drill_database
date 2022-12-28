<?php
print('Drill deleted');
$conn = mysqli_connect("localhost","cjcuser","computing","Exercises");
$query=sprintf("UPDATE Drills SET Hidden=0 WHERE 1");
$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
?>
