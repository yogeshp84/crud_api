<?php

class Post{

    private $dbCon;
    public function __construct($db){
        $this->dbCon = $db;
    }

    public function postData($postId,$userId){
        $post = $this->dbCon->getPostById($postId);
        if(!$post){
            return 'Not Found';
        }
        $isAllowed = $this->checkAccess($postId,$userId);
        if($isAllowed === true){
            if(!$post){
                return 'Not Found';
            }
            return $post ;
        }else{
            return "Permission denied";
        }
    }
    public function List($user_id, $searchKeyword, $start=0, $end=10)
    {
           return $this->dbCon->list($user_id,$start,$end,$searchKeyword);
    }

    public function create($data){
        return $this->dbCon->insert($data);
    }

    public function update($postId,$userId,$data){
        $isAllowed = $this->checkAccess($postId,$userId);
        if($isAllowed === true){
            $finalResp = '';
           $resp = $this->dbCon->update($postId,$data);
            return $resp === 'updated' ? 'updated' : 'Nothing Updated';
        }else{
            return "Permission denied";
        }
        
    }

    public function delete($postId,$userId){
        $post = $this->dbCon->getPostById($postId);
        if(!$post){
            return 'Not Found';
        }
        $isAllowed = $this->checkAccess($postId,$userId);
        if($isAllowed === true){
            $finalResp = '';
           $resp = $this->dbCon->delete($postId);
            return $resp ;
        }else{
            return "Permission denied";
        }
    }

    private function checkAccess($postId,$userId){
        $post = $this->dbCon->getPostById($postId);
        if($post){
            return $post['created_by'] === $userId ? true : false;
        }
        return false;
    }
}