<?php 

class Db {
    
    private const TABLE_POSTS = 'posts';
    private const TABLE_USERS = 'users';
    public $connection;

    /**
     * Connect to database (make a connection)
     * @return boolean Return true for connected / false for not connected
     */
    public function connect($host,$user,$pass,$dbname) {
        

        $this->host     = $host;
        $this->username = $user;
        $this->password = $pass;
        $this->database = $dbname;
        try{
            $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        }catch(Exception $e){
            exit('Error connecting to database');
        }
    } 

    public function list($userId,$start,$end,$searchKeyword){
        //get totl count
        $count = $this->getTotalPostCount($userId,$searchKeyword);
        //prepare query 
        if($searchKeyword === ''){
            $sql = "Select * from ". self::TABLE_POSTS ." where created_by = ? ORDER BY id DESC LIMIT ?,?";
        }else{
            $sql = "Select * from ". self::TABLE_POSTS ." where created_by = ? and title like ? ORDER BY id DESC LIMIT ?,?";
        
        }
        $stmt= $this->connection->prepare($sql);
        if($searchKeyword === ''){
            $stmt->bind_param("sss",$userId,$start,$end);
        }else{
            $searchParam = "%{$searchKeyword}%";
            $stmt->bind_param("isii",$userId,$searchParam,$start,$end);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $numRows = $result->num_rows;
        if($numRows === 0) return false;
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return ['count'=>$count,'items'=>$data];

    }
    public function insert(array $data){
        //count number of inputs
        $numValues = count($data);

        //get all column names
        $columns = implode(',',array_keys($data));

        //get all values
        $values = array_values($data);

        //prepare query
        $sql = "INSERT INTO ". self::TABLE_POSTS ." (".$columns.") VALUES (".trim(str_repeat('?,',$numValues),',').")";
        $stmt= $this->connection->prepare($sql);
        $stmt->bind_param(str_repeat('s',$numValues), ...$values);
        $return = "";
        if ($stmt->execute()) {
            $return = 'created';
        } else {
            $return =  $this->connection->error;;
        }
        $stmt->close();
        return $return;
    }

    public function update(int $id, array $data){
        //count number of inputs
        $numValues = count($data);

        //get all column names
        $columns="";
        foreach($data as $k=>$v){
            $columns .= $k." = ?,";
        }
        //get all values
        $values = array_values($data);

        //add id
        array_push($values,$id);

        //prepare query
        $sql = "Update ". self::TABLE_POSTS ." set ".trim($columns,',')." where id = ?";
        $stmt= $this->connection->prepare($sql);
        $stmt->bind_param(str_repeat('s',$numValues).'i', ...$values);
        $stmt->execute();
        $affectedRow  = $stmt->affected_rows;
        $return = "";
        if ($affectedRow > 0) {
            $return = 'updated';
        } else {
            $return = "nothing updated";
        }
        $stmt->close();
        return $return;
        
    }

    public function delete($postId){
        //prepare query
        $sql = "Delete from ". self::TABLE_POSTS ." where id = ? ";
        $stmt= $this->connection->prepare($sql);
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $affectedRow  = $stmt->affected_rows;
        $return = "";
        if ($affectedRow > 0) {
            $return = 'deleted';
        } else {
            $return = "nothing deleted";
        }
        $stmt->close();
        return $return;
    }
    
    public function getPostById($id){
        //prepare query
        $sql = "Select * from ". self::TABLE_POSTS ." where id = ? ";
        $stmt= $this->connection->prepare($sql);
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) return false;
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;

    }

    public function getUserById($id){
        //prepare query
        $sql = "Select * from ". self::TABLE_USERS ." where user_name = ? ";
        $stmt= $this->connection->prepare($sql);
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) return false;
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;

    }

    private function getTotalPostCount($userId,$searchKeyword){
        
            //prepare query 
            if($searchKeyword === ''){
                $sql = "Select * from ". self::TABLE_POSTS ." where created_by = ? ";
            }else{
                $sql = "Select * from ". self::TABLE_POSTS ." where created_by = ? and title like ? ";
            
            }
            $stmt= $this->connection->prepare($sql);
            if($searchKeyword === ''){
                $stmt->bind_param("i",$userId);
            }else{
                $searchParam = "%{$searchKeyword}%";
                $stmt->bind_param("is",$userId,$searchParam);
            }
            
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows;
            
    
        
    }
}

