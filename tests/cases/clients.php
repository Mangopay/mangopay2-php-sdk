<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Test class for Client API
 */
class Clients extends Base {
    
   function test_ClientsCreateClient() {        
        $id = rand(1000000000, 10000000000);
        $client = $this->_api->Clients->create($id, "test",  "test@o2.pl");
        $this->assertTrue("test" == $client->Name);
        $this->assertTrue(strlen($client->Passphrase) > 0);
    }
    
    function test_Clients_TryCreateInvalidClient() {
        // invalid id
        $this->expectException('MangoPay\ResponseException');
        $client = $this->_api->Clients->create("0", "test",  "test@o2.pl");
        $this->assertTrue($client == null);
    }
}
