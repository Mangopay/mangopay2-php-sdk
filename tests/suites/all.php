<?php
namespace MangoPay\Tests;
require_once '../simpletest/autorun.php';
require_once '../cases/base.php';

/**
 * Runs all test cases
 */
class All extends \TestSuite {

    function __construct() {
        parent::__construct();
        $this->collect('../cases', new TestCasesCollector());
    }
}

class TestCasesCollector extends \SimpleCollector {

    protected function isHidden($filename) {

        // ignore base.php: with abstract test case class (throws Bad TestSuite [No runnable test cases] otherwise)
        if ($filename == "base.php") return true;
        
        
        //if ($filename == "payIns.php") return true;
        //if ($filename == "users.php") return true;
        //if ($filename == "wallets.php") return true;

        return parent::isHidden($filename);
    }
}