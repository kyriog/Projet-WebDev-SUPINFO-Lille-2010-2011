<?php
include_once('PdoManager.class.php');

class PdoFamilyManager extends PdoManager {

    public function add_family($name, $parent_family = null){
        $query = $this->pdo->prepare('INSERT INTO families(name, parentfamily) VALUES (:name, :parent_family)');
        $query->bindValue(':name', $name);
        $query->bindValue(':parent_family', $parent_family);
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_family($id, $name, $parent_family){
        $query = $this->pdo->prepare('UPDATE families SET name = :name, parentfamily = :parent_family WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->bindValue(':name', $name);
        $query->bindValue(':parent_family', $parent_family);
        $query->execute();
    }

    public function delete_family($id){
        $query = $this->pdo->prepare('DELETE FROM families WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
    }
}
?>
