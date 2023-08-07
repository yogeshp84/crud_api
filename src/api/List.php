<?php
require_once __DIR__ . "/../database/connection.php";
require_once __DIR__ . "/../classes/Post.php";
require_once __DIR__ . "/../classes/User.php";
require_once __DIR__ . "/../config/cache.php";



//get logged user data
$userId = '';
$user = new User($dbObj);
$userData = $user->getUserById($param['user_name']);
if(!$userData){
    header('HTTP/1.0 403 Forbidden'); 
    echo json_encode(['status'=>'Access Denied']);
    return;
}

//check for pagination
$start  = !empty($param['start']) ? $param['start'] : 0;
$end    = !empty($param['end']) ? $param['end'] : 10;
//check for search string
$searchKeyword = !empty($param['keyword']) ? $param['keyword'] :'';
//create new post
$key = 'list_'.$userData['id'].'_'.$start.'_'.$end;
$cacheInstance = $cache->getItem($key);
$resp = $cacheInstance->get(); 
//$resp = null;
if(is_null($resp) || !$resp){
    $post = new Post($dbObj);
    $resp = $post->list($userData['id'], $searchKeyword, $start, $end);
    $cacheInstance->set($resp)->expiresAfter(300);
    $cache->save($cacheInstance);
}
echo json_encode($resp);
