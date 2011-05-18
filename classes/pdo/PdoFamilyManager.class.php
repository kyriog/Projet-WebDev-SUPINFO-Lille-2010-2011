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

    public function edit_family($family){
        $query = $this->pdo->prepare('UPDATE families SET name = :name, parentfamily = :parent_family WHERE id = :id');
        $query->bindValue(':id', $family->getId());
        $query->bindValue(':name', $family->getName());
        $query->bindValue(':parent_family', $family->getParentfamily());
        $query->execute();
    }

    public function delete_family($id){
        $query = $this->pdo->prepare('DELETE FROM families WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
    }
    
    public function retrieve_families() {
        $query = $this->pdo->prepare('SELECT * FROM families');
        $query->execute();
        $array = array();
        while($value = $query->fetch(PDO::FETCH_ASSOC)) {
            if($value['parentfamily']) {
                $subquery = $this->pdo->prepare("SELECT name FROM families WHERE id = :parentid");
                $subquery->bindValue(":parentid", $value['parentfamily']);
                $subquery->execute();
                $value2 = $subquery->fetch(PDO::FETCH_ASSOC);
                $family = new familiesModel($value['id'], $value['name'], $value2['name']);
                array_push($array, $family);

            }
            else {
            $family = new familiesModel($value['id'], $value['name'], $value['parentfamily']);
            array_push($array, $family);
            }
        }
        return $array;
    }
}
?>
