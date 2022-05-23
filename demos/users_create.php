<?php
// require include only one file
require_once '../vendor/autoload.php';

try {
    // create object to manage MangoPay API
    $api = new MangoPay\MangoPayApi();
    // use test client credentails (REPLACE IT BY YOUR CLIENT ONES!)
    $api->Config->ClientId = 'sdk_example';
    $api->Config->ClientPassword = 'Vfp9eMKSzGkxivCwt15wE082pTTKsx90vBenc9hjLsf5K46ciF';
    $api->Config->TemporaryFolder = '/a/writable/folder/somewhere/ideally-out-of-reach-of-your-root/';
    
    // CREATE NATURAL USER
    $naturalUser = new MangoPay\UserNatural();
    $naturalUser->Email = 'test_natural@testmangopay.com';
	$naturalUser->FirstName = "Bob";
	$naturalUser->LastName = "Briant";
	$naturalUser->Birthday = 121271;
	$naturalUser->Nationality = "FR";
	$naturalUser->CountryOfResidence = "ZA";
    $naturalUserResult = $api->Users->Create($naturalUser);
    // display result
    MangoPay\Libraries\Logs::Debug('CREATED NATURAL USER', $naturalUserResult);
    
    // CREATE LEGAL USER
    $legalUser = new MangoPay\UserLegal();
    $legalUser->Name = 'Name Legal Test';
    $legalUser->LegalPersonType = \MangoPay\LegalPersonType::Business;
    $legalUser->Email = 'legal@testmangopay.com';
	$legalUser->LegalRepresentativeFirstName = "Bob";
	$legalUser->LegalRepresentativeLastName = "Briant";
	$legalUser->LegalRepresentativeBirthday = 121271;
	$legalUser->LegalRepresentativeNationality = "FR";
	$legalUser->LegalRepresentativeCountryOfResidence = "ZA";
    $legalUserResult = $api->Users->Create($legalUser);
    // display result
    MangoPay\Libraries\Logs::Debug('CREATED LEGAL USER', $legalUserResult);
    
} catch (MangoPay\Libraries\ResponseException $e) {
    
    MangoPay\Libraries\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
    MangoPay\Libraries\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Libraries\Logs::Debug('Details', $e->GetErrorDetails());
    
} catch (MangoPay\Libraries\Exception $e) {
    
    MangoPay\Libraries\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
}


