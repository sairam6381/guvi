<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
$connect=mysqli_connect("localhost","root","","guvi");

if(isset($_POST['action']) && $_POST['action']=='login' ){
    
    $username=$_POST['username'];
    $password=$_POST['password'];   
    $stmt = $connect->prepare("select * FROM register WHERE username = ? and password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if($connect->affected_rows<=0){
        echo json_encode(array('success' => false));
    }
    else{
        $userid = $row['id'];
        $username=$row['username'];

        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->setex('id',300,$row['id']);
        $redis->close();
        echo json_encode(array(
            'success' => true,
            'userid' => $userid,
            'username' => $username
          ));
    }
}