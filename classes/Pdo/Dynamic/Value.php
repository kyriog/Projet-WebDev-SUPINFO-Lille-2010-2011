<?php
class Pdo_Dynamic_Value extends Pdo_Manager {
    public function getDynamicValue($id) {
        $query = $this->pdo->prepare("SELECT * FROM dynamic_values WHERE id = :id");
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
?>
