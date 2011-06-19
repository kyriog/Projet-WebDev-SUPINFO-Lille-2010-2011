<?php
class Pdo_User extends Pdo_Manager {
    

    public function add_user($user){
        $query = $this->pdo->prepare('INSERT INTO users(name, password) VALUES (:name, :password)');
        $query->bindValue(':id', $user->getId());
        $query->bindValue(':name', $user->getName());
        $query->bindValue(':password', md5($user->getPassword()));
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_user($user){
        $query = $this->pdo->prepare('UPDATE users SET name = :name, password = :password WHERE id = :id');
        $query->bindValue(':id', $user->getId());
        $query->bindValue(':name', $user->getName());
        $query->bindValue(':password', $user->getPassword());
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
}
?>
