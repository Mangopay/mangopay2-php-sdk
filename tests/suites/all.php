<?php

namespace MangoPay\Tests;

if (getenv('TRAVIS')) {
    $options['curl'][CURLOPT_SSLVERSION] = CURL_SSLVERSION_TLSv1_1;
}

require_once '../simpletest/autorun.php';

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
        if ($filename == "base.php" || $filename == "index.php")
            return true;

        return parent::isHidden($filename);
    }
}

