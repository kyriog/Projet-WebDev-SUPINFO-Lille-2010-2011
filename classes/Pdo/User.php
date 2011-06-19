<?php
class Pdo_User extends Pdo_Manager {
    

    public function add_user($user){
        $query = $this->pdo->prepare('INSERT INTO users(lname, fname, phone, password) VALUES (:lname, :fname, :phone, :password)');
        $query->bindValue(':id', $user->getId());
        $query->bindValue(':lname', $user->getLname());
        $query->bindValue(':fname', $user->getFname());
        $query->bindValue(':phone', $user->getPhone());
        $query->bindValue(':password', md5($user->getPassword()));
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_user($user){
        $query = $this->pdo->prepare('UPDATE users SET lname = :lname, fname = :fname, phone = :phone, password = :password WHERE id = :id');
        $query->bindValue(':id', $user->getId());
        $query->bindValue(':lname', $user->getLname());
        $query->bindValue(':fname', $user->getFname());
        $query->bindValue(':phone', $user->getPhone());
        $query->bindValue(':password', md5($user->getPassword()));
        $query->execute();
    }

    public function delete_user($id){
        $query = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
    }
    
    public function login($id, $password) {
        $query = $this->pdo->prepare('SELECT id FROM users WHERE id=:id AND password=:password');
        $query->bindValue(':id', $id);
        $query->bindValue(':password', md5($password));
        $query->execute();
        if($value = $query->fetch(PDO::FETCH_ASSOC))
        {
            return new Model_User($value['id']);
        }
    }
    
    public function getUser($id) {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();
        $value = $query->fetch(PDO::FETCH_ASSOC);
        return $value;
    }
    
    public function getAllUsers() {
        $query = $this->pdo->prepare("SELECT id FROM users");
        $query->execute();
        $array = array();
        while($value = $query->fetch(PDO::FETCH_ASSOC)) {
            $user = new Model_User($value['id']);
            array_push($array, $user);
        }
        return $array;
    }
}
?>
