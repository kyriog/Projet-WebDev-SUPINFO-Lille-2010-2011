<?php
class Pdo_Loan extends Pdo_Manager {
    
    public function add_loan($loan){
        $query = $this->pdo->prepare('INSERT INTO loans(customer, begindate, enddate, reason) VALUES (:customer, :begindate, :enddate, :reason)');
        $query->bindValue(':customer', $loan->getCustomer());
        $query->bindValue(':begindate', Helper_Date::timestampToMysql($loan->getBegindate()));
        $query->bindValue(':enddate', Helper_Date::timestampToMysql($loan->getEnddate()));
        $query->bindValue(':reason', $loan->getReason());
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_loan($loan){
        $query = $this->pdo->prepare('UPDATE loans SET customer = :customer, begindate = :begindate, enddate = :enddate, reason = :reason WHERE id = :id');
        $query->bindValue(':id', $loan->getId());
        $query->bindValue(':customer', $loan->getCustomer());
        $query->bindValue(':begindate', Helper_Date::timestampToMysql($loan->getBegindate()));
        $query->bindValue(':enddate', Helper_Date::timestampToMysql($loan->getEnddate()));
        $query->bindValue(':reason', $loan->getReason());
        $query->execute();
    }

    public function delete_loan($id){
        $query = $this->pdo->prepare('DELETE FROM loans WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
    }
    
    public function getLoan($id) {
        $query = $this->pdo->prepare("SELECT * FROM loans WHERE id = :id");
        $query->bindValue(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAllLoans() {
        $query = $this->pdo->prepare("SELECT id FROM loans");
        $query->execute();
        $array = array();
        while($value = $query->fetch(PDO::FETCH_ASSOC)) {
            $loan = new Model_Loan($value['id']);
            array_push($array, $loan);
        }
        return $array;
    }
}
?>
