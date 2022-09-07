<?php

namespace MangoPay\Tests\Cases;

/**
 * Tests basic methods for report requests
 */
class RegulatoryTest extends Base
{
    public function test_getCountryAuthorizations()
    {
        $countryAuthorizations = $this->_api->Regulatory->GetCountryAuthorizations("FR");

        $this->assertNotNull($countryAuthorizations);
        $this->assertNotNull($countryAuthorizations->CountryCode);
        $this->assertNotNull($countryAuthorizations->CountryName);
        $this->assertNotNull($countryAuthorizations->LastUpdate);
        $this->assertNotNull($countryAuthorizations->Authorization);

        $this->assertNotNull($countryAuthorizations->Authorization->BlockBankAccountCreation);
        $this->assertNotNull($countryAuthorizations->Authorization->BlockPayout);
        $this->assertNotNull($countryAuthorizations->Authorization->BlockUserCreation);
    }

    public function test_getAllCountriesAuthorizations()
    {
        $countryAuthorizations = $this->_api->Regulatory->GetAllCountryAuthorizations();

        $this->assertNotNull($countryAuthorizations);
        $this->assertTrue(count($countryAuthorizations) > 0);

        foreach ($countryAuthorizations as $authorization) {
            $this->assertNotNull($authorization->CountryCode);
            $this->assertNotNull($authorization->CountryName);
            $this->assertNotNull($authorization->LastUpdate);
            $this->assertNotNull($authorization->Authorization);

            $this->assertNotNull($authorization->Authorization->BlockBankAccountCreation);
            $this->assertNotNull($authorization->Authorization->BlockPayout);
            $this->assertNotNull($authorization->Authorization->BlockUserCreation);
        }
    }
}
