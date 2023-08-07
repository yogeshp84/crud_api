<?php
require_once __DIR__ . "/../database/connection.php";
require_once __DIR__ . "/../classes/Post.php";
require_once __DIR__ . "/../classes/User.php";
$data = [];
//get update data
$updateJSON = file_get_contents('php://input');
$updateArray = json_decode($updateJSON,true);

//check if username and postid is supplied
if(empty($updateArray['post_id']) || empty($updateArray['user_name'])){
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad Request';
    return;
}


//validate data
$userName = htmlspecialchars(strip_tags($updateArray['user_name']));
$postId   = htmlspecialchars(strip_tags($updateArray['post_id']));


//get logged user data
$userId = '';
$user = new User($dbObj);
$userData = $user->getUserById($userName);
if(!empty($userData)){
    $userId = $userData['id'];
}

//create new post
$post = new Post($dbObj);
$resp = $post->delete($postId,$userId);
if($resp === 'deleted'){
    echo json_encode(['status'=>$resp]);
}else if($resp === 'Permission denied'){   
    header('HTTP/1.0 403 Forbidden'); 
    echo json_encode(['status'=>$resp]);
}else if($resp === 'Not Found'){   
    header('HTTP/1.0 404 Not Found'); 
    echo json_encode(['status'=>$resp]);
}else{
    echo json_encode(['status'=>$resp]);
    header('HTTP/1.0 500 Server Error');
}