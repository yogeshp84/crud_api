<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once __DIR__ . "/../database/connection.php";
require_once __DIR__ . "/../classes/Post.php";
require_once __DIR__ . "/../classes/User.php";
$data = [];

//get update data
$updateJSON = file_get_contents('php://input');
$updateArray = json_decode($updateJSON,true);

//check if username and postid is supplied
if(empty($updateArray['post_id']) || empty($updateArray['user_name']) || (empty($updateArray['title']) && empty($updateArray['description']))){
    header('HTTP/1.0 400 Bad Request');
    return;
}
//validate data
$userName = htmlspecialchars(strip_tags($updateArray['user_name']));
$postId   = htmlspecialchars(strip_tags($updateArray['post_id']));
if(!empty($updateArray['title'])){
    $data['title'] = htmlspecialchars(strip_tags($updateArray['title']));
}
if(!empty($updateArray['description'])){
    $data['description'] = htmlspecialchars(strip_tags($updateArray['description']));
}



//get logged user data
$userId = '';
$user = new User($dbObj);
$userData = $user->getUserById($userName);
if(!empty($userData)){
    $userId = $userData['id'];
}

//create new post
$post = new Post($dbObj);
$resp = $post->update($postId,$userId,$data);
if($resp === 'updated' || $resp === 'Nothing Updated'){
    echo json_encode(['status'=>$resp]);
}else if($resp === 'Permission denied'){   
    header('HTTP/1.0 403 Forbidden'); 
    echo json_encode(['status'=>$resp]);
}else{
    echo json_encode(['status'=>$resp]);
    header('HTTP/1.0 500 Server Error');
}

