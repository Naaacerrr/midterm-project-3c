<?php

require_once 'Employee.php';

class PieceWorker extends Employee {
    private int $numberItems;
    private float $wagePerItem;

    public function __construct(string $name, string $address, int $age, string $companyName, int $numberItems, float $wagePerItem) {
        parent::__construct($name, $address, $age, $companyName);
        $this->numberItems = $numberItems;
        $this->wagePerItem = $wagePerItem;
    }

    public function earnings(): float {
        return $this->numberItems * $this->wagePerItem;
    }

    public function __toString(): string {
        return parent::__toString() . ", Number of Items: {$this->numberItems}, Wage per Item: {$this->wagePerItem}, Earnings: {$this->earnings()}";
    }
}