<?php
require_once __DIR__ . "/../database/connection.php";
require_once __DIR__ . "/../classes/Post.php";
require_once __DIR__ . "/../classes/User.php";
$data = [];

//check if username and postid is supplied
if(empty($param['post_id']) || empty($param['user_name'])){
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad Request';
    return;
}


//validate data
$userName = htmlspecialchars(strip_tags($param['user_name']));
$postId   = htmlspecialchars(strip_tags($param['post_id']));


//get logged user data
$userId = '';
$user = new User($dbObj);
$userData = $user->getUserById($userName);
if(!empty($userData)){
    $userId = $userData['id'];
}

//create new post
$post = new Post($dbObj);
$resp = $post->postData($postId,$userId);
if($resp === false){
    echo json_encode(['status'=>'error']);
    header('HTTP/1.0 500 Server Error');
}else if($resp === 'Permission denied'){   
    header('HTTP/1.0 403 Forbidden'); 
    echo json_encode(['status'=>$resp]);
}else if($resp === 'Not Found'){   
    header('HTTP/1.0 404 Not Found'); 
    echo json_encode(['status'=>$resp]);
}else{
    echo json_encode($resp);
    
}