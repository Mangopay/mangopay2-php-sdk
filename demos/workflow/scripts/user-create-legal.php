<?php
$User = new MangoPay\UserLegal();
$User->Name = "Name Legal Test";
$User->LegalPersonType = \MangoPay\LegalPersonType::Business;
$User->Email = "legal@testmangopay.com";
$User->LegalRepresentativeFirstName = "Bob";
$User->LegalRepresentativeLastName = "Briant";
$User->LegalRepresentativeBirthday = 121271;
$User->LegalRepresentativeNationality = "FR";
$User->LegalRepresentativeCountryOfResidence = "ZA";
$User->CompanyNumber = 'LU123456';
$User->UserCategory = 'Owner';

$address = new \MangoPay\Address();
$address->AddressLine1 = 'Rue des plantes';
$address->AddressLine2 = '2nd floor';
$address->City = 'Paris';
$address->Country = 'FR';
$address->PostalCode = '75000';
$address->Region = 'IDF';

$User->HeadquartersAddress = $address;
$result = $mangoPayApi->Users->Create($User);

//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["UserLegal"] = $result->Id;