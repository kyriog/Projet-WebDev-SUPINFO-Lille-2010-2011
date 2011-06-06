<?php
class Pdo_Dynamic_Field extends Pdo_Manager {
    public function add_field($field) {
        $query = $this->pdo->prepare("INSERT INTO dynamic_fields(id_family, name) VALUES(:id_family, :name)");
        $query->bindValue(":id_family", $field->getFamily());
        $query->bindValue(":name", $field->getName());
        $query->execute();
        return $this->pdo->lastInsertId();
    }
    
    public function getDynamicField($id) {
        $query = $this->pdo->prepare("SELECT * FROM dynamic_fields WHERE id = :id");
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getFieldsByFamilyId($id) {
        $query = $this->pdo->prepare("SELECT id FROM dynamic_fields WHERE id_family=:id ORDER BY id");
        $query->bindValue(":id", $id);
        $query->execute();
        $fields = array();
        while($fetch = $query->fetch(PDO::FETCH_NUM)) {
            $fields[] = new Model_Dynamic_Field($fetch[0]);
        }
        return $fields;
    }
}
?>
