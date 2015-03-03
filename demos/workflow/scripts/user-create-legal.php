<?php
$User = new MangoPay\Entities\UserLegal();
$User->Name = 'Name Legal Test';
$User->LegalPersonType = 'BUSINESS';
$User->Email = 'legal@testmangopay.com';
$User->LegalRepresentativeFirstName = "Bob";
$User->LegalRepresentativeLastName = "Briant";
$User->LegalRepresentativeBirthday = 121271;
$User->LegalRepresentativeNationality = "FR";
$User->LegalRepresentativeCountryOfResidence = "ZA";
$result = $mangoPayApi->Users->Create($User);

//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["UserLegal"] = $result->Id;
