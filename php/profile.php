<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection=$client->guvi->userdata;

$functionName=$_POST['functionName'];
$userid=$_POST['userid'];
$search=array(
    "userid" => $userid,
);
$fetch=$collection->findOne($search);
if($functionName=="automatic"){
    automatic();
}
if($functionName=="update"){
    update();
}
function automatic(){
    global $fetch;
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
    else{
        echo 0;
    }    
}

function update(){
    global $fetch,$collection,$userid;
    
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
