<?php
class Pdo_Article extends Pdo_Manager {
    public function getArticle($id) {
        $query = $this->pdo->prepare("SELECT * FROM articles WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();
        $value = $query->fetch(PDO::FETCH_ASSOC);
        return $value;
    }
    
    public function getArticlesByFamily($id_family) {
        $query = $this->pdo->prepare("SELECT id FROM articles WHERE family = :id_family");
        $query->bindValue(":id_family", $id_family);
        $query->execute();
        $array = array();
        while($value = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new Model_Article($value['id']);
            array_push($array, $article);
        }
        return $array;
    }
}
?>
