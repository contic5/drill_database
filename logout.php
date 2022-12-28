<?php
require('sessionstart.php');
session_unset();
header("Location: index.php");
?>
