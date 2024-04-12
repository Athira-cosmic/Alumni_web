<?php
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='root';
$DATABASE='signupforms';


$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

if(!$con){
    die(mysqli_error($con));
}

?>
