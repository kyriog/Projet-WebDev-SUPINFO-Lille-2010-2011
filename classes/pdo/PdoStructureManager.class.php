<?php
include_once('PdoManager.class.php');

class PdoStructureManager extends PdoManager {
    
    public function add_structure($name){
        $query = $this->pdo->prepare('INSERT INTO structures(name) VALUES (:name)');
        $query->bindValue(':name', $name);
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_structure(placesModel $structures){
        $query = $this->pdo->prepare('UPDATE structures SET name = :name WHERE id = :id');
        $query->bindValue(':id', $structures->getId());
        $query->bindValue(':name', $structures>getName());
        $query->execute();
    }

    public function delete_structure($id){
        $query = $this->pdo->prepare('DELETE FROM structures WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
    }
}
?>
