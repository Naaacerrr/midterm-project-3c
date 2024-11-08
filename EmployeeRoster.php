<?php

require_once 'Employee.php';

class EmployeeRoster {
    private $roster = [];
    private $maxSize;
    private $currentSize = 0;

    public function __construct($maxSize) {
        $this->maxSize = $maxSize;
    }

    public function addEmployee($employee) {
        if ($this->currentSize < $this->maxSize) {
            $this->roster[$employee->getId()] = $employee;
            $this->currentSize++;
            return true;
        } else {
            return false;
        }
    }

    public function deleteEmployee($id) {
        if (isset($this->roster[$id])) {
            unset($this->roster[$id]);
            $this->currentSize--;
            return true;
        }
        return false;
    }

    public function listEmployees() {
        foreach ($this->roster as $employee) {
            echo $employee . PHP_EOL;
        }
    }

    public function countEmployees() {
        return count($this->roster);
    }

    public function getEmployee($id) {
        return isset($this->roster[$id]) ? $this->roster[$id] : null;
    }

    public function getRosterSize() {
        return $this->maxSize - $this->currentSize;  
    }

    public function getEmployeeRoster() {
        return $this->roster;
    }
}

?>