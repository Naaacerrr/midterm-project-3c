<?php

require_once 'Employee.php';

class CommissionEmployee extends Employee {
    private $regularSalary;
    private $itemsSold;
    private $commissionRate;

    public function __construct($name, $address, $age, $companyName, $id, $regularSalary, $itemsSold, $commissionRate) {
        parent::__construct($name, $address, $age, $companyName, $id);
        $this->regularSalary = $regularSalary;
        $this->itemsSold = $itemsSold;
        $this->commissionRate = $commissionRate;
    }

    public function getRegularSalary() {
        return $this->regularSalary;
    }

    public function getItemsSold() {
        return $this->itemsSold;
    }

    public function getCommissionRate() {
        return $this->commissionRate;
    }

    public function calculateEarnings() {
        return $this->regularSalary + ($this->itemsSold * $this->commissionRate);
    }

    public function __toString() {
        return parent::__toString() . " | Regular Salary: " . $this->regularSalary . " | Items Sold: " . $this->itemsSold . " | Commission Rate: " . $this->commissionRate;
    }
}
?>