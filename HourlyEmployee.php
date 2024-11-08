<?php

require_once 'Employee.php';

class HourlyEmployee extends Employee {
    private int $hoursWorked;
    private float $rate;

    public function __construct(string $name, string $address, int $age, string $companyName, int $hoursWorked, float $rate) {
        parent::__construct($name, $address, $age, $companyName);
        $this->hoursWorked = $hoursWorked;
        $this->rate = $rate;
    }

    public function earnings(): float {
        if ($this->hoursWorked <= 40) {
            return $this->hoursWorked * $this->rate;
        } else {
            return (40 * $this->rate) + (($this->hoursWorked - 40) * $this->rate * 1.5);
        }
    }

    public function __toString(): string {
        return parent::__toString() . ", Hours Worked: {$this->hoursWorked}, Rate: {$this->rate}, Earnings: {$this->earnings()}";
    }
}