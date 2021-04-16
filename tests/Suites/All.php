<?php

namespace MangoPay\Tests\Suites;

require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../../vendor/simpletest/simpletest/autorun.php';

/**
 * Runs all test cases
 */
class All extends \TestSuite {

    function __construct() {
        parent::__construct();
        $this->collect(__DIR__.'/../Cases', new TestCasesCollector());
    }
}

class TestCasesCollector extends \SimpleCollector {

    protected function isHidden($filename) {

        // ignore Base.php: with abstract test case class (throws Bad TestSuite [No runnable test cases] otherwise)
        if ($filename == "Base.php" || $filename == "index.php")
            return true;

        return parent::isHidden($filename);
    }
}

