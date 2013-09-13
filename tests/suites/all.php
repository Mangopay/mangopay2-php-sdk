<?php
namespace MangoPay\Tests;
require_once '../simpletest/autorun.php';

/**
 * Runs all test cases
 */
class All extends \TestSuite {

    function __construct() {
        parent::__construct();
        
        $this->addFile('../cases/tokens.php');
        $this->addFile('../cases/clients.php');
        $this->addFile('../cases/configurations.php');
        $this->addFile('../cases/users.php');
        $this->addFile('../cases/wallets.php');
        $this->addFile('../cases/transfers.php');
        $this->addFile('../cases/cardRegistrations.php');
        $this->addFile('../cases/payIns.php');
        $this->addFile('../cases/refunds.php');
        $this->addFile('../cases/payOuts.php');
    }
}