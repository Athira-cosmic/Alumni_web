<?php
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='Athi@2003';
$DATABASE='signupforms';


$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

if(!$con){
    die(mysqli_error($con));
}

?>
