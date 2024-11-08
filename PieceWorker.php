<?php

class PieceWorker extends Employee {
    private $itemsSold;
    private $wagePerItem;

    public function __construct($name, $address, $age, $companyName, $id, $itemsSold, $wagePerItem) {
        parent::__construct($name, $address, $age, $companyName, $id);
        $this->itemsSold = $itemsSold;
        $this->wagePerItem = $wagePerItem;
    }

    public function calculateEarnings() {
        return $this->itemsSold * $this->wagePerItem;
    }

    public function __toString() {
        return "PieceWorker ID: {$this->getId()} - Name: {$this->getName()} - Earnings: {$this->calculateEarnings()}";
    }
}
?>