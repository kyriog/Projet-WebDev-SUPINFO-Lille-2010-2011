<?php
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
    
    public function getPlace($id){
        $query = $this->pdo->prepare('SELECT * FROM places WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
        $value = $query->fetch(PDO::FETCH_ASSOC);
        return $value;
    }
    
    public function getAllPlaces() {
        $query = $this->pdo->prepare("SELECT * FROM places");
        $query->execute();
        $array = array();
        while($value = $query->fetch(PDO::FETCH_ASSOC))
        {
            $place = new Model_Place($value['id']);
            array_push($array, $place);
        }
        return $array;
    }

}
?>
