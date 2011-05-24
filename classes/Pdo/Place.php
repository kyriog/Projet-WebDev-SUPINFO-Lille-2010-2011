<?php
include_once('PdoManager.class.php');

class Pdo_Place extends Pdo_Manager {
    
    public function add_place($place){
        $query = $this->pdo->prepare('INSERT INTO places(name) VALUES (:name)');
        $query->bindValue(':id', $place->getId());
        $query->bindValue(':name', $place->getName());
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_place($place){
        $query = $this->pdo->prepare('UPDATE places SET name = :name WHERE id = :id');
        $query->bindValue(':id', $place->getId());
        $query->bindValue(':name', $place->getName());
        $query->execute();
    }

    public function delete_place($id){
        $query = $this->pdo->prepare('DELETE FROM places WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
    }
}
?>

}
?>
