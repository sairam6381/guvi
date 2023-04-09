<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
$connect=mysqli_connect("localhost","root","","guvi");

$username=$_POST['username'];
$password=$_POST['password'];



$query="select * FROM register WHERE username='$username'";
$test=mysqli_query($connect,$query);
$repeat=mysqli_num_rows($test);
if($repeat==0){

$stmt="insert into register(username,password) values(?,?)";
$stmt=$connect ->prepare($stmt);
$stmt->bind_param('ss',$username,$password);
$stmt->execute();
$stmt->close();
$connect->close();
echo 1;
}
else{
    echo 0;
}

?>