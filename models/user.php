<?php 

class User extends Database {

    function userLogin($name, $email){
        $sql = "SELECT name, email FROM users WHERE name = '$name' AND email = '$email'";
        return $this->get($sql);
    }

    function getUser(){
        $sql = "SELECT * FROM users";
        return $this->get($sql);    
    }

    function insertUser($name, $email, $number){
        $sql = "INSERT INTO users (name, email, number) VALUES ('$name', '$email', $number)";
        return $this->insert($sql);
    }

    function userExist($email){
        $sql = "SELECT email FROM users WHERE email = '$email'";
        return $this->get($sql);
    }

    function deleteUser($id){
        $sql = "DELETE FROM users WHERE id = $id";
        return $this->delete($sql);    
    }

    function updateUser($id, $name, $email, $number ){
        $sql = "UPDATE users SET  name = '$name', email = '$email', number = '$number' ";
        return $this->update($sql);
    }

    function getUserById($id){
        $sql = "SELECT * FROM users WHERE id = $id";
        $user = $this->getById($sql);
        $sql = "SELECT * FROM posts WHERE user_id = $id";
        $posts = $this->get($sql);
        echo $posts;
        exit;
    }
    
}


?>