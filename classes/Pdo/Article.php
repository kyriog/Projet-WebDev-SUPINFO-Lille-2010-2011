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
    
    public function deleteArticle($id) {
        $query = $this->pdo->prepare("DELETE FROM articles WHERE id = :id");
        $query->bindValue(":id", $id);
        return $query->execute();
    }
    
    public function add_article($article){
        $query = $this->pdo->prepare('INSERT INTO articles(barcode, family, quantity, description, state, place) VALUES (:barcode, :family, :quantity, :description, :state, :place)');
        $query->bindValue(':barcode', $article->getBarcode());
        $query->bindValue(':family', $article->getFamily());
        $query->bindValue(':quantity', $article->getQuantity());
        $query->bindValue(':description', $article->getDescription());
        $query->bindValue(':state', $article->getState());
        $query->bindValue(':place', $article->getPlace());
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_article($article){
        $query = $this->pdo->prepare('UPDATE articles SET barcode = :barcode, family = :family, quantity = :quantity, description = :description, state = :state, place = :place WHERE id = :id');
        $query->bindValue(':id', $article->getId());
        $query->bindValue(':barcode', $article->getBarcode());
        $query->bindValue(':family', $article->getFamily());
        $query->bindValue(':quantity', $article->getQuantity());
        $query->bindValue(':description', $article->getDescription());
        $query->bindValue(':state', $article->getState());
        $query->bindValue(':place', $article->getPlace());        
        $query->execute();
    }
    
    public function getAllArticles() {
        $query = $this->pdo->prepare('SELECT id FROM articles');
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
