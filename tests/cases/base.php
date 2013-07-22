<?php
namespace MangoPay\Tests;
require_once '../../src/mangoPayApi.inc';

/**
 * Base class for test case classes
 */
abstract class Base extends \UnitTestCase {

    /** @var \MangoPay\MangoPayApi */
    protected $_api;

    /**
     * Test user (natural) - access by getJohn()
     * @var \MangoPay\UserNatural
     */
    public static $John;

    /**
     * Test user (legal) - access by getMatrix()
     * @var \MangoPay\UserLegal
     */
    public static $Matrix;

    /**
     * Test bank account belonging to John - access by getJohnsAccount()
     * @var \MangoPay\BankAccount
     */
    public static $JohnsAccount;

    function __construct() {
        $this->_api = new \MangoPay\MangoPayApi();
    }

    /**
     * Creates self::$John (test natural user) if not created yet
     * @return \MangoPay\UserNatural
     */
    protected function getJohn() {
        if (self::$John === null) {
            $user = new \MangoPay\UserNatural();
            $user->FirstName = "John";
            $user->LastName = "Doe";
            $user->Email = "john.doe@sample.org";
            $user->Address = "Some Address";
            $user->Birthday = mktime(0,0,0, 12, 21, 1975);
            $user->Birthplace = "Paris";
            $user->Nationality = "FR";
            $user->CountryOfResidence = "FR";
            $user->Occupation = "programmer";
            $user->IncomeRange = 3;
            self::$John = $this->_api->Users->Create($user);
//print "<pre> JOHN CREATED: ";var_dump(self::$John);print "</pre>";
        }
        return self::$John;
    }

    /**
     * Creates self::$Matrix (test legal user) if not created yet
     * @return \MangoPay\UserLegal
     */
    protected function getMatrix() {
        if (self::$Matrix === null) {
            $john = $this->getJohn();
            $user = new \MangoPay\UserLegal();
            $user->Name = "MartixSampleOrg";
            $user->LegalPersonType = "BUSINESS";
            $user->HeadquartersAddress = "Some Address";
            $user->LegalRepresentativeFirstName = $john->FirstName;
            $user->LegalRepresentativeLastName = $john->LastName;
            $user->LegalRepresentativeAdress = $john->Address;
            $user->LegalRepresentativeEmail = $john->Email;
            $user->LegalRepresentativeBirthday = $john->Birthday;
            $user->LegalRepresentativeNationality = $john->Nationality;
            $user->LegalRepresentativeCountryOfResidence = $john->CountryOfResidence;
            self::$Matrix = $this->_api->Users->Create($user);
//print "<pre> MATRIX CREATED: ";var_dump(self::$Matrix);print "</pre>";
        }
        return self::$Matrix;
    }

    /**
     * Creates self::$JohnsAccount (bank account belonging to John) if not created yet
     * @return \MangoPay\BankAccount
     */
    protected function getJohnsAccount() {
        if (self::$JohnsAccount === null) {
            $john = $this->getJohn();
            $account = new \MangoPay\BankAccount();
            $account->Type = 'IBAN';
            $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
            $account->OwnerAddress = $john->Address;
            $account->IBAN = 'AD12 0001 2030 2003 5910 0100';
            $account->BIC = 'BINAADADXXX';
            self::$JohnsAccount = $this->_api->Users->CreateBankAccount($john->Id, $account);
//print "<pre> JOHN'S ACCOUNT CREATED: ";var_dump(self::$JohnsAccount);print "</pre>";
        }
        return self::$JohnsAccount;
    }

    /**
     * Asserts the passed entities have identical values (by assertIdentical())
     * but ONLY FOR INPUT PROPERTIES, i.e. properties that are accepted by Create methods:
     * IGNORES SYSTEM PROPERTIES set by the Mango API (Id, CreationDate etc).
     * 
     * @param \MangoPay\EntityBase $entity1
     * @param \MangoPay\EntityBase $entity2
     */
    protected function assertIdenticalInputProps($entity1, $entity2) {
//print "<pre>";var_dump($entity1);print "</pre>";
//print "<pre>";var_dump($entity2);print "</pre>";

        $this->assertIdentical($entity1->Tag, $entity2->Tag);

        if (is_a($entity1, '\MangoPay\UserNatural')) {
            $this->assertIdentical($entity1->PersonType, $entity2->PersonType);
            $this->assertIdentical($entity1->FirstName, $entity2->FirstName);
            $this->assertIdentical($entity1->LastName, $entity2->LastName);
            $this->assertIdentical($entity1->Email, $entity2->Email);
            $this->assertIdentical($entity1->Address, $entity2->Address);
            $this->assertIdentical($entity1->Birthday, $entity2->Birthday);
            $this->assertIdentical($entity1->Birthplace, $entity2->Birthplace);
            $this->assertIdentical($entity1->Nationality, $entity2->Nationality);
            $this->assertIdentical($entity1->CountryOfResidence, $entity2->CountryOfResidence);
            $this->assertIdentical($entity1->Occupation, $entity2->Occupation);
            $this->assertIdentical($entity1->IncomeRange, $entity2->IncomeRange);

        } elseif (is_a($entity1, '\MangoPay\UserLegal')) {
            $this->assertIdentical($entity1->PersonType, $entity2->PersonType);
            $this->assertIdentical($entity1->Name, $entity2->Name);
            $this->assertIdentical($entity1->HeadquartersAddress, $entity2->HeadquartersAddress);
            $this->assertIdentical($entity1->LegalRepresentativeFirstName, $entity2->LegalRepresentativeFirstName);
            $this->assertIdentical($entity1->LegalRepresentativeLastName, $entity2->LegalRepresentativeLastName);
            $this->assertIdentical($entity1->LegalRepresentativeAdress, $entity2->LegalRepresentativeAdress, "***** TEMPORARY API ISSUE: RETURNED OBJECT MISSES THIS PROP AFTER CREATION *****");
            $this->assertIdentical($entity1->LegalRepresentativeEmail, $entity2->LegalRepresentativeEmail);
            $this->assertIdentical($entity1->LegalRepresentativeBirthday, $entity2->LegalRepresentativeBirthday, "***** TEMPORARY API ISSUE: RETURNED OBJECT HAS THIS PROP CHANGED FROM TIMESTAMP INTO ISO STRING AFTER CREATION *****");
            $this->assertIdentical($entity1->LegalRepresentativeNationality, $entity2->LegalRepresentativeNationality);
            $this->assertIdentical($entity1->LegalRepresentativeCountryOfResidence, $entity2->LegalRepresentativeCountryOfResidence);

        } elseif (is_a($entity1, '\MangoPay\BankAccount')) {
            $this->assertIdentical($entity1->UserId, $entity2->UserId);
            $this->assertIdentical($entity1->Type, $entity2->Type);
            $this->assertIdentical($entity1->OwnerName, $entity2->OwnerName);
            $this->assertIdentical($entity1->OwnerAddress, $entity2->OwnerAddress);
            $this->assertIdentical($entity1->IBAN, $entity2->IBAN);
            $this->assertIdentical($entity1->BIC, $entity2->BIC);

        /* etc for other entity classes...
        } elseif (is_a($entity1, '\MangoPay\...')) {
            $this->assertIdentical($entity1->, $entity2->);
            //...
         */

        } else {
            throw new \Exception("Unsupported type");
        }
    }
}
