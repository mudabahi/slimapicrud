<?php 

class Post extends Database {

    function getPost(){
        $sql = "SELECT u.name AS Your_name, p.post_name FROM posts AS p ";
        $sql .= "JOIN users AS u on u.id = p.user_id";
        return $this->get($sql);    
    }

    function insertPost($post_name, $user_id){
        $sql = "INSERT INTO posts (post_name, user_id) VALUES ('$post_name', $user_id)";
        return $this->insert($sql);
    }
    function updatePost($id, $post_name){
        $sql = "UPDATE posts SET post_name = '$post_name' WHERE id = $id";
        return $this->update($sql);
    }
    function deletePost($id){
        $sql = "DELETE FROM posts WHERE id = $id";
        return $this->delete($sql);
    }

  

   
    
}


?>