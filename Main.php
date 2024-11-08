<?php

require_once 'EmployeeRoster.php';
require_once 'PieceWorker.php';
require_once 'HourlyEmployee.php';
require_once 'CommissionEmployee.php';

class Main {
    private $employeeRoster;

    public function __construct() {
        $this->setRosterSize();
    }

    public function start() {
        do {
            $this->showRosterInfo();
            $this->showMenu();

            $choice = $this->getUserInput("Choose an option: ", "number");

            switch ($choice) {
                case 1:
                    $this->addEmployee();
                    break;
                case 2:
                    $this->deleteEmployee();
                    break;
                case 3:
                    $this->displayEmployees();
                    break;
                case 4:
                    $this->countEmployees();
                    break;
                case 5:
                    $this->payroll();
                    break;
                case 6:
                    echo "Exiting...\n";
                    $this->resetRoster();
                    exit;
                default:
                    echo "Invalid input. Please try again.\n";
            }
        } while (true);
    }

    private function setRosterSize() {
        $size = $this->getUserInput("Enter the size of the employee roster: ", "positive_number");
        $this->employeeRoster = new EmployeeRoster($size);
    }

    private function addEmployee() {
        if ($this->employeeRoster->countEmployees() >= $this->employeeRoster->getRosterSize()) {
            echo "Roster is full. No more employees can be added.\n";
            return;
        }

        $id = $this->getUserInput("Enter Employee ID: ", "string");
        $name = $this->getUserInput("Enter Name: ", "string");
        $address = $this->getUserInput("Enter Address: ", "string");
        $age = $this->getUserInput("Enter Age: ", "positive_number");
        $companyName = $this->getUserInput("Enter Company Name: ", "string");

        $type = $this->getUserInput("Choose employee type:\n1. PieceWorker\n2. Hourly Employee\n3. Commission Employee\n", "number");

        switch ($type) {
            case 1:
                $itemsSold = $this->getUserInput("Enter items sold: ", "positive_number");
                $wagePerItem = $this->getUserInput("Enter wage per item: ", "positive_number");
                $employee = new PieceWorker($name, $address, $age, $companyName, $id, $itemsSold, $wagePerItem);
                break;
            case 2:
                $hoursWorked = $this->getUserInput("Enter hours worked: ", "positive_number");
                $hourlyRate = $this->getUserInput("Enter hourly rate: ", "positive_number");
                $employee = new HourlyEmployee($name, $address, $age, $companyName, $id, $hoursWorked, $hourlyRate);
                break;
            case 3:
                $regularSalary = $this->getUserInput("Enter regular salary: ", "positive_number");
                $itemsSold = $this->getUserInput("Enter number of items sold: ", "positive_number");
                $commissionRate = $this->getUserInput("Enter commission rate: ", "positive_number");
                $employee = new CommissionEmployee($name, $address, $age, $companyName, $id, $regularSalary, $itemsSold, $commissionRate);
                break;
            default:
                echo "Invalid input\n";
                return;
        }

        if ($this->employeeRoster->addEmployee($employee)) {
            echo "Employee added successfully!\n";
        } else {
            echo "Roster is full, can't add employee.\n";
        }
    }

    private function deleteEmployee() {
        $id = $this->getUserInput("Enter Employee ID to delete: ", "string");
        if ($this->employeeRoster->deleteEmployee($id)) {
            echo "Employee deleted successfully!\n";
        } else {
            echo "Employee not found.\n";
        }
    }

    private function displayEmployees() {
        echo "Employee Display Options:\n";
        echo "1. Display All Employees\n";
        echo "2. Display Commission Employees\n";
        echo "3. Display Hourly Employees\n";
        echo "4. Display Piece Worker Employees\n";

        $choice = $this->getUserInput("Enter your choice: ", "number");

        switch ($choice) {
            case 1:
                $this->employeeRoster->listEmployees();
                break;
            case 2:
                $this->listSpecificEmployeeType('CommissionEmployee');
                break;
            case 3:
                $this->listSpecificEmployeeType('HourlyEmployee');
                break;
            case 4:
                $this->listSpecificEmployeeType('PieceWorker');
                break;
            default:
                echo "Invalid choice.\n";
        }
    }

    private function countEmployees() {
        echo "Employee Count Options:\n";
        echo "1. Count All Employees\n";
        echo "2. Count Commission Employees\n";
        echo "3. Count Hourly Employees\n";
        echo "4. Count Piece Worker Employees\n";

        $choice = $this->getUserInput("Enter your choice: ", "number");

        switch ($choice) {
            case 1:
                echo "Total Employees: " . $this->employeeRoster->countEmployees() . PHP_EOL;
                break;
            case 2:
                $this->countSpecificEmployeeType('CommissionEmployee');
                break;
            case 3:
                $this->countSpecificEmployeeType('HourlyEmployee');
                break;
            case 4:
                $this->countSpecificEmployeeType('PieceWorker');
                break;
            default:
                echo "Invalid input.\n";
        }
    }

    private function payroll() {
        echo "Payroll Information:\n";
        foreach ($this->employeeRoster->getEmployeeRoster() as $employee) {
            echo $employee . " | Earnings: " . $employee->calculateEarnings() . PHP_EOL;
        }
    }

    private function resetRoster() {
        unset($this->employeeRoster);
        echo "Roster reset successfully.\n";
    }

    private function getUserInput($prompt, $type) {
        echo $prompt;
        $input = trim(fgets(STDIN));

        switch ($type) {
            case "number":
                while (!is_numeric($input)) {
                    echo "Please enter a valid number: ";
                    $input = trim(fgets(STDIN));
                }
                return (int)$input;
            case "positive_number":
                while (!is_numeric($input) || $input <= 0) {
                    echo "Please enter a valid positive number: ";
                    $input = trim(fgets(STDIN));
                }
                return (int)$input;
            case "string":
                while (empty($input)) {
                    echo "This field cannot be empty. Please enter again: ";
                    $input = trim(fgets(STDIN));
                }
                return $input;
        }
        return $input;
    }

    private function showRosterInfo() {
        echo "\nCurrent Roster Size: " . $this->employeeRoster->countEmployees() . 
             " | Remaining Capacity: " . ($this->employeeRoster->getRosterSize() - $this->employeeRoster->countEmployees()) . "\n";
    }

    private function showMenu() {
        echo "\nEmployee Roster Menu\n";
        echo "1. Add Employee\n";
        echo "2. Delete Employee\n";
        echo "3. Display Employees\n";
        echo "4. Count Employees\n";
        echo "5. Payroll\n";
        echo "6. Exit\n";
    }

    private function listSpecificEmployeeType($type) {
        foreach ($this->employeeRoster->getEmployeeRoster() as $employee) {
            if ($employee instanceof $type) {
                echo $employee . PHP_EOL;
            }
        }
    }

    private function countSpecificEmployeeType($type) {
        $count = 0;
        foreach ($this->employeeRoster->getEmployeeRoster() as $employee) {
            if ($employee instanceof $type) {
                $count++;
            }
        }
        echo "$type Employees: $count\n";
    }
}

$entry = new Main();
$entry->start();

?>
