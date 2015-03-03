<?php
// require include only one file
require_once '../vendor/autoload.php';

try {
    // create object to manage MangoPay API
    $api = new MangoPay\MangoPayApi();
    // use test client credentails (REPLACE IT BY YOUR CLIENT ONES!)
    $api->Config->TemporaryFolder = __dir__;
    $api->Config->ClientId = 'sdk_example';
    $api->Config->ClientPassword = 'Vfp9eMKSzGkxivCwt15wE082pTTKsx90vBenc9hjLsf5K46ciF';

    // CREATE NATURAL USER
    $naturalUser = new MangoPay\Entities\UserNatural();
    $naturalUser->Email = 'test_natural@testmangopay.com';
	$naturalUser->FirstName = "Bob";
	$naturalUser->LastName = "Briant";
	$naturalUser->Birthday = 121271;
	$naturalUser->Nationality = "FR";
	$naturalUser->CountryOfResidence = "ZA";
    $naturalUserResult = $api->Users->Create($naturalUser);
    // display result
    MangoPay\Tools\Logs::Debug('CREATED NATURAL USER', $naturalUserResult);

    // CREATE LEGAL USER
    $legalUser = new MangoPay\UserLegal();
    $legalUser->Name = 'Name Legal Test';
    $legalUser->LegalPersonType = 'BUSINESS';
    $legalUser->Email = 'legal@testmangopay.com';
	$legalUser->LegalRepresentativeFirstName = "Bob";
	$legalUser->LegalRepresentativeLastName = "Briant";
	$legalUser->LegalRepresentativeBirthday = 121271;
	$legalUser->LegalRepresentativeNationality = "FR";
	$legalUser->LegalRepresentativeCountryOfResidence = "ZA";
    $legalUserResult = $api->Users->Create($legalUser);
    // display result
    MangoPay\Tools\Logs::Debug('CREATED LEGAL USER', $legalUserResult);

} catch (MangoPay\Types\Exceptions\ResponseException $e) {

    MangoPay\Tools\Logs::Debug('MangoPay\Types\Exceptions\ResponseException Code', $e->GetCode());
    MangoPay\Tools\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Tools\Logs::Debug('Details', $e->GetErrorDetails());

} catch (MangoPay\Types\Exceptions\Exception $e) {

    MangoPay\Tools\Logs::Debug('MangoPay\Types\Exceptions\Exception Message', $e->GetMessage());
}
