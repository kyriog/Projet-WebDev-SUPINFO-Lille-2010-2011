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
}
?>
