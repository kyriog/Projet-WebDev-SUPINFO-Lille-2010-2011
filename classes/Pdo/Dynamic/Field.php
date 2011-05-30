<?php
class Pdo_Dynamic_Field extends Pdo_Manager {
    public function add_field($field) {
        $query = $this->pdo->prepare("INSERT INTO dynamic_fields(id_family, name) VALUES(:id_family, :name)");
        $query->bindValue(":id_family", field.getId_family());
        $query->bindValue(":name", field.getName());
        $query->execute();   
    }
    
    public function getDynamicField($id) {
        $query = $this->pdo->prepare("SELECT * FROM dynamic_fields WHERE id = :id");
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
?>
