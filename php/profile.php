<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection=$client->guvi->userdata;

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$functionName=$_POST['functionName'];
$userid=$_POST['userid'];
$search=array(
    "userid" => $userid,
);
$fetch=$collection->findOne($search);
if($functionName=="automatic"){
    automatic();
}
else if($functionName=="update"){
    update();
}
else if($functionName=="logout"){
    logout();
}
function logout(){
    global $redis;
    $redis->del('id');
    $redis->close();
}
function automatic(){
    global $fetch,$redis;
    if($redis->exists('id')==1){
        if ($fetch){
            echo json_encode(array(
                'success' => true,
                'userid' => $fetch['userid'],
                "fname" => $fetch['fname'],
                "lname" => $fetch['lname'],
                "email" => $fetch['email'],
                "gender" => $fetch['gender'],
                "number" => $fetch['number'],
                "dob" => $fetch['dob'] 
            ));
        }
    } 
    else{
        $redis->close();
        echo json_encode(array(
            'success' => 'logout'));
    } 
}

function update(){
    global $fetch,$collection,$userid,$redis;
    $redis->setex('id',300,$userid);
    
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $gender=$_POST['gender'];
    $number=$_POST['number'];
    $dob=$_POST['dob'];
    $data=array(
        "userid" => $userid,"fname" => $fname,"lname" => $lname,
        "email" => $email,"gender" => $gender,"number" => $number,"dob" => $dob 
    );
    if ($fetch){
        $updateResult = $collection->updateOne(
           [ "userid" => $userid ],
           [ '$set' => [ 
               'fname' => $fname,
               'lname' => $lname,
               'email' => $email,
               'gender' => $gender,
               'number' => $number,
               'dob' => $dob
           ]]
       );
   }
   else{
       $insert = $collection->insertOne($data);
   }
    
}



?>