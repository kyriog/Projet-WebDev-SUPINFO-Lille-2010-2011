<?php
class Pdo_Article extends Pdo_Manager {
    public function getArticle($id) {
        $query = $this->pdo->prepare("SELECT * FROM articles WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();
        $value = $query->fetch(PDO::FETCH_ASSOC);
        return $value;
    }
}
?>
