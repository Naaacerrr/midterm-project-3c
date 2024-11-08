<?php
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class EmployeeRoster {
    private $roster;

    public function __construct($rosterSize) {
        $this->roster = array_fill(0, $rosterSize, null);
    }

    public function add($employee) {
        for ($i = 0; $i < count($this->roster); $i++) {
            if ($this->roster[$i] === null) {
                $this->roster[$i] = $employee;
                return;
            }
        }
    }

    public function remove($employeeNumber) {
        if (isset($this->roster[$employeeNumber])) {
            $this->roster[$employeeNumber] = null;
        }
    }

    public function count() {
        return count(array_filter($this->roster, fn($e) => $e !== null));
    }

    public function countCE() {
        return count(array_filter($this->roster, fn($e) => $e instanceof CommissionEmployee));
    }

    public function countHE() {
        return count(array_filter($this->roster, fn($e) => $e instanceof HourlyEmployee));
    }

    public function countPE() {
        return count(array_filter($this->roster, fn($e) => $e instanceof PieceWorker));
    }

    public function display() {
        foreach ($this->roster as $employee) {
            if ($employee !== null) {
                echo $employee . "\n";
            }
        }
    }

    public function displayCE() {
        foreach ($this->roster as $employee) {
            if ($employee instanceof CommissionEmployee) {
                echo $employee . "\n";
            }
        }
    }

    public function displayHE() {
        foreach ($this->roster as $employee) {
            if ($employee instanceof HourlyEmployee) {
                echo $employee . "\n";
            }
        }
    }

    public function displayPE() {
        foreach ($this->roster as $employee) {
            if ($employee instanceof PieceWorker) {
                echo $employee . "\n";
            }
        }
    }

    public function payroll() {
        foreach ($this->roster as $employee) {
            if ($employee !== null) {
                echo $employee . ", Earnings: " . $employee->earnings() . "\n";
            }
        }
    }
}
?>
