<?php

require_once 'EmployeeRoster.php';
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class Main {

    private EmployeeRoster $roster;
    private $size;
    private $repeat;

    public function start() {
        $this->clear();
        $this->repeat = true;
        $this->size = readline("Enter the size of the roster: ");

        if ($this->size < 1) {
            echo "Invalid input. Please try again.\n";
            readline("Press \"Enter\" key to continue...");
            $this->start();
        } else {
            $this->roster = new EmployeeRoster($this->size);
            $this->entrance();
        }
    }

    public function entrance() {
        $choice = 0;

        while ($this->repeat) {
            $this->clear();
            $this->menu();
            $choice = readline("Enter your choice: ");

            switch ($choice) {
                case 1:
                    $this->addMenu();
                    break;
                case 2:
                    $this->deleteMenu();
                    break;
                case 3:
                    $this->otherMenu();
                    break;
                case 0:
                    $this->repeat = false;
                    break;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" key to continue...");
                    break;
            }
        }
        echo "Process terminated.\n";
    }

    public function menu() {
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    public function addMenu() {
        $name = readline("Enter Employee's name: ");
        $address = readline("Enter Employee's address: ");
        $age = readline("Enter Employee's age: ");
        $companyName = readline("Enter Employee's company name: ");
        
        $this->empType($name, $address, $age, $companyName);
    }

    public function empType($name, $address, $age, $companyName) {
        $this->clear();
        echo "--- Employee Details ---\n";
        echo "[1] Commission Employee\n[2] Hourly Employee\n[3] Piece Worker\n";
        $type = readline("Type of Employee: ");

        switch ($type) {
            case 1:
                $this->addOnsCE($name, $address, $age, $companyName);
                break;
            case 2:
                $this->addOnsHE($name, $address, $age, $companyName);
                break;
            case 3:
                $this->addOnsPE($name, $address, $age, $companyName);
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                $this->empType($name, $address, $age, $companyName);
                break;
        }
    }

    public function addOnsCE($name, $address, $age, $companyName) {
        $regularSalary = readline("Enter regular salary: ");
        $itemsSold = readline("Enter number of items sold: ");
        $commissionRate = readline("Enter commission rate: ");

        $employee = new CommissionEmployee($name, $address, $age, $companyName, $regularSalary, $itemsSold, $commissionRate);
        $this->roster->add($employee);
        $this->repeat();
    }

    public function addOnsHE($name, $address, $age, $companyName) {
        $hoursWorked = readline("Enter hours worked: ");
        $rate = readline("Enter hourly rate: ");

        $employee = new HourlyEmployee($name, $address, $age, $companyName, $hoursWorked, $rate);
        $this->roster->add($employee);
        $this->repeat();
    }

    public function addOnsPE($name, $address, $age, $companyName) {
        $numberItems = readline("Enter number of items: ");
        $wagePerItem = readline("Enter wage per item: ");

        $employee = new PieceWorker($name, $address, $age, $companyName, $numberItems, $wagePerItem);
        $this->roster->add($employee);
        $this->repeat();
    }

    public function deleteMenu() {
        $this->clear();
        echo "*** List of Employees in the Current Roster ***\n";
        $this->roster->display();

        $employeeNumber = readline("\nEnter employee number to delete or 0 to return: ");
        if ($employeeNumber == 0) return;
        $this->roster->remove($employeeNumber - 1);
    }

    public function otherMenu() {
        $this->clear();
        echo "[1] Display\n";
        echo "[2] Count\n";
        echo "[3] Payroll\n";
        echo "[0] Return\n";
        $choice = readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->displayMenu();
                break;
            case 2:
                $this->countMenu();
                break;
            case 3:
                $this->roster->payroll();
                readline("\nPress \"Enter\" key to continue...");
                break;
            case 0:
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                break;
        }
    }

    public function displayMenu() {
        $this->clear();
        echo "[1] Display All Employees\n";
        echo "[2] Display Commission Employees\n";
        echo "[3] Display Hourly Employees\n";
        echo "[4] Display Piece Workers\n";
        echo "[0] Return\n";
        $choice = readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->roster->display();
                break;
            case 2:
                $this->roster->displayCE();
                break;
            case 3:
                $this->roster->displayHE();
                break;
            case 4:
                $this->roster->displayPE();
                break;
            case 0:
                return;
            default:
                echo "Invalid Input!\n";
                break;
        }

        readline("\nPress \"Enter\" key to continue...");
    }

    public function countMenu() {
        $this->clear();
        echo "[1] Count All Employees\n";
        echo "[2] Count Commission Employees\n";
        echo "[3] Count Hourly Employees\n";
        echo "[4] Count Piece Workers\n";
        echo "[0] Return\n";
        $choice = readline("Select Menu: ");

        switch ($choice) {
            case 1:
                echo "Total Employees: " . $this->roster->count() . "\n";
                break;
            case 2:
                echo "Commission Employees: " . $this->roster->countCE() . "\n";
                break;
            case 3:
                echo "Hourly Employees: " . $this->roster->countHE() . "\n";
                break;
            case 4:
                echo "Piece Workers: " . $this->roster->countPE() . "\n";
                break;
            case 0:
                return;
            default:
                echo "Invalid Input!\n";
                break;
        }

        readline("\nPress \"Enter\" key to continue...");
    }

    public function clear() {
        system('clear');
    }

    public function repeat() {
        echo "Employee Added!\n";
        if ($this->roster->count() < $this->size) {
            $continue = readline("Add more? (press 1 to continue): ");
            if (strtolower($continue) == '1')
                $this->addMenu();
            else
                $this->entrance();
        } else {
            echo "Roster is full.\n";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
        }
    }
}

$main = new Main();
$main->start();
?>
