<?php
require_once __DIR__ . "/../database/connection.php";
require_once __DIR__ . "/../classes/Post.php";
require_once __DIR__ . "/../classes/User.php";
$data = [];
//get update data
$updateJSON = file_get_contents('php://input');
$updateArray = json_decode($updateJSON,true);

//check if username and postid is supplied
if(empty($updateArray['user_name'])){
    echo json_encode(['error'=>'Bad Request']);
    header('HTTP/1.0 400 Bad Request');
    return;
}
if(empty($updateArray['title']) || empty($updateArray['description'])){
    echo json_encode(['error'=>'Title or description is missing']);
    header('http/1.0 422 Unprocessable Content');
    return;
}


//validate data
$userName = htmlspecialchars(strip_tags($updateArray['user_name']));
$data['title'] = htmlspecialchars(strip_tags($updateArray['title']));
$data['description'] = htmlspecialchars(strip_tags($updateArray['description']));



//get logged user data
$userId = '';
$user = new User($dbObj);
$userData = $user->getUserById($userName);
if(!empty($userData)){
    $data['created_by'] = $userData['id'];
}

//create new post
$post = new Post($dbObj);
$resp = $post->create($data);
if($resp === 'created'){
    echo json_encode(['status'=>$resp]);
}else{
    echo json_encode(['status'=>$resp]);
    header('HTTP/1.0 500 Server Error');
}