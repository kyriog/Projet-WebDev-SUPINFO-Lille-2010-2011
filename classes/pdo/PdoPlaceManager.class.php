<?php
include_once('PdoManager.class.php');

class PdoPlaceManager extends PdoManager {
    
    public function add_place($name){
        $query = $this->pdo->prepare('INSERT INTO places(name) VALUES (:name)');
        $query->bindValue(':name', $name);
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_place($places){
        $query = $this->pdo->prepare('UPDATE places SET name = :name WHERE id = :id');
        $query->bindValue(':id', $places->getId());
        $query->bindValue(':name', $places>getName());
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
