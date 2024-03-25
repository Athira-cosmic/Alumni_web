<?php
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
	include 'connect.php';
	$reg_no=$_POST['reg_no'];
	$password=$_POST['password'];

	$sql="Select * from `registration` where
	reg_no='$reg_no' and password='$password'";

	$result=mysqli_query($con,$sql);
	$row=mysqli_fetch_array($result);
	if(is_array($row)){
		$_SESSION["reg_no"] = $row["reg_no"];
		$_SESSION["password"] = $row["password"];
	}else{
		echo '<script type = "text/javascript">';
		echo 'alert("Invalid Register no. or password")';
		echo 'window.location.href = "signin.php"';
		echo '</script>';
	}
}
if(isset($_SESSION["reg_no"])){
	header("Location:dashboard.php");
}

?>