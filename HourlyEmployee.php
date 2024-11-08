<?php

require_once 'Employee.php';

class HourlyEmployee extends Employee {
    private $hoursWorked;
    private $hourlyRate;

    public function __construct($name, $address, $age, $companyName, $id, $hoursWorked, $hourlyRate) {
        parent::__construct($name, $address, $age, $companyName, $id);
        $this->hoursWorked = $hoursWorked;
        $this->hourlyRate = $hourlyRate;
    }

    public function getHoursWorked() {
        return $this->hoursWorked;
    }

    public function getHourlyRate() {
        return $this->hourlyRate;
    }

    public function calculateEarnings() {
        return $this->hoursWorked * $this->hourlyRate;
    }

    public function __toString() {
        return parent::__toString() . " | Hours Worked: " . $this->hoursWorked . " | Hourly Rate: " . $this->hourlyRate;
    }
}
?>