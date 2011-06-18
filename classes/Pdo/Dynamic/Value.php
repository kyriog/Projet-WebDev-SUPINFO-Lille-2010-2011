<?php
class Pdo_Dynamic_Value extends Pdo_Manager {
    public function getDynamicValue($id) {
        $query = $this->pdo->prepare("SELECT * FROM dynamic_values WHERE id = :id");
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getValue($id_field, $id_article) {
        $query = $this->pdo->prepare("SELECT value FROM dynamic_values WHERE id_field = :id_field AND id_article = :id_article");
        $query->bindValue(":id_field", $id_field);
        $query->bindValue(":id_article", $id_article);
        $query->execute();
        $value = $query->fetch(pdo::FETCH_ASSOC);
        return $value['value'];
    }
    
    public function getId($id_field, $id_article) {
        $query = $this->pdo->prepare("SELECT id FROM dynamic_values WHERE id_field = :id_field AND id_article = :id_article");
        $query->bindValue(":id_field", $id_field);
        $query->bindValue(":id_article", $id_article);
        $query->execute();
        $value = $query->fetch(pdo::FETCH_ASSOC);
        return $value['id'];
    }
    
    public function add_value($value){
        $query = $this->pdo->prepare('INSERT INTO dynamic_values(id_field, id_article, value) VALUES (:id_field, :id_article, :value)');
        $query->bindValue(':id_field', $value->getId_field());
        $query->bindValue(':id_article', $value->getId_article());
        $query->bindValue(':value', $value->getValue());
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_value($value){
        $query = $this->pdo->prepare('UPDATE dynamic_values SET id_field = :id_field, id_article = :id_article, value = :value WHERE id = :id');
        $query->bindValue(':id', $value->getId());
        $query->bindValue(':id_field', $value->getId_field());
        $query->bindValue(':id_article', $value->getId_article());
        $query->bindValue(':value', $value->getValue());
        $query->execute();
    }
}
?>
