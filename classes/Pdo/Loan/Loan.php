<?php
class Pdo_Loan extends Pdo_Manager {
    
    public function add_loan($loan){
        $query = $this->pdo->prepare('INSERT INTO loans(customer, begindate, enddate, reason) VALUES (:customer, :begindate, :enddate, :resaon)');
        $query->bindValue(':customer', $loan->getCustomer());
        $query->bindValue(':begindate', $loan->getBegindate());
        $query->bindValue(':enddate', $loan->getEnddate());
        $query->bindValue(':reason', $loan->getReason());
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_loan($loan){
        $query = $this->pdo->prepare('UPDATE loans SET customer = :customer, begindate = :begindate, enddate = :enddate, reason = :reason WHERE id = :id');
        $query->bindValue(':id', $loan->getId());
        $query->bindValue(':customer', $loan->getCustomer());
        $query->bindValue(':begindate', $loan->getBegindate());
        $query->bindValue(':enddate', $loan->getEnddate());
        $query->bindValue(':reason', $loan->getReason());
        $query->execute();
    }

    public function delete_loan($id){
        $query = $this->pdo->prepare('DELETE FROM loans WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
    }
}
?>
