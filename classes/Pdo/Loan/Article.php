<?php
class Pdo_Loan_Article extends Pdo_Manager {
    
    public function add_loan_article($loan_article){
        $query = $this->pdo->prepare('INSERT INTO loans_articles(loan, article, begindate, enddate) VALUES (:loan, :article, :begindate, :enddate)');
        $query->bindValue(':customer', $loan_article->getLoan());
        $query->bindValue(':article', $loan_article->getArticle());
        $query->bindValue(':begindate', $loan_article->getBegindate());
        $query->bindValue(':enddate', $loan_article->getEnddate());
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_loan_article($loan){
        $query = $this->pdo->prepare('UPDATE loans_articles SET loan = :loan, article = :article, begindate = :begindate, enddate = :enddate WHERE id = :id');
        $query->bindValue(':id', $$loan->getId());
        $query->bindValue(':customer', $loan_article->getLoan());
        $query->bindValue(':article', $loan_article->getArticle());
        $query->bindValue(':begindate', $loan_article->getBegindate());
        $query->bindValue(':enddate', $loan_article->getEnddate());
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
}
?>
