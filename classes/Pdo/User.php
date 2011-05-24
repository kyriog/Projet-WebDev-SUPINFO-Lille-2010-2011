<?php
class Pdo_User extends Pdo_Manager {
    

    public function add_user($user){
        $query = $this->pdo->prepare('INSERT INTO users(name, password) VALUES (:name, :password)');
        $query->bindValue(':id', $user->getId());
        $query->bindValue(':name', $user->getName());
        $query->bindValue(':password', $user->getPassword());
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
    
    public function login($user) {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE username=:name AND password=:password');
        $query->bindValue(':name', $user->getName());
        $query->bindValue(':password', md5($user->getPassword()));
        $query->execute();
        if($value = $query->fetchColumn(PDO::FETCH_ASSOC))
        {
            return new Model_User($value['id'], $value['username'], $value['password']);
        }
    }
}
?>
