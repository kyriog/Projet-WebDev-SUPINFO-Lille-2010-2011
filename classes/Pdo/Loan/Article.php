<?php
class Pdo_Loan_Article extends Pdo_Manager {
    
    public function add_loan_article($loan_article){
        $query = $this->pdo->prepare('INSERT INTO loans_articles(loan, article, quantity, begindate, enddate) VALUES (:loan, :article, :quantity, :begindate, :enddate)');
        $query->bindValue(':loan', $loan_article->getLoan());
        $query->bindValue(':article', $loan_article->getArticle());
        $query->bindValue(':quantity', $loan_article->getQuantity());
        $query->bindValue(':begindate', Helper_Date::timestampToMysql($loan_article->getBegindate()));
        $query->bindValue(':enddate', Helper_Date::timestampToMysql($loan_article->getEnddate()));
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_loan_article($loan_article){
        $query = $this->pdo->prepare('UPDATE loans_articles SET loan = :loan, article = :article, quantity = :quantity, begindate = :begindate, enddate = :enddate WHERE id = :id');
        $query->bindValue(':id', $loan_article->getId());
        $query->bindValue(':loan', $loan_article->getLoan());
        $query->bindValue(':article', $loan_article->getArticle());
        $query->bindValue(':quantity', $loan_article->getQuantity());
        $query->bindValue(':begindate', Helper_Date::timestampToMysql($loan_article->getBegindate()));
        $query->bindValue(':enddate', Helper_Date::timestampToMysql($loan_article->getEnddate()));
        $query->execute();
    }

    public function delete_loan_article($id){
        $query = $this->pdo->prepare('DELETE FROM loans_articles WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
    }
        
    public function getLoanArticle($id) {
        $query = $this->pdo->prepare("SELECT * FROM loans_articles WHERE id = :id");
        $query->bindValue(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAllArticlesByLoanId($id) {
        $query = $this->pdo->prepare("SELECT article FROM loans_articles WHERE loan = :id");
        $query->bindValue(':id', $id);
        $query->execute();
        $array = array();
        while($value = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new Model_Article($value['article']);
            array_push($array, $article);
        }
        return $array;
    }
}
?>
