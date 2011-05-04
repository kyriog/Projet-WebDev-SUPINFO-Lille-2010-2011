<?php
include_once('PdoManager.class.php');

class PdoUserManager extends PdoManager {
    

    public function add_user($name, $password){
        $query = $this->pdo->prepare('INSERT INTO users(name, password) VALUES (:name, :password)');
        $query->bindValue(':name', $name);
        $query->bindValue(':password', $password);
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_user(usersModel $user){
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
}
?>
