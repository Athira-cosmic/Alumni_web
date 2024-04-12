<?php
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='chinnu11';
$DATABASE='alumni';


$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

if(!$con){
    die(mysqli_error($con));
}

?>
