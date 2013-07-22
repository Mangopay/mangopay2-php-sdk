<?php
namespace MangoPay;

/**
 * UserLegal entity
 */
class UserLegal extends User {
    
    /**
     * Name of user
     * @var String
     */
    public $Name;
    
    /**
     * Type for legal user. Possible: ‘BUSINESS’, ’ASSOCIATION’
     * @var String 
     */
    public $LegalPersonType;
    
    /**
     * 
     * @var String 
     */
    public $HeadquartersAddress;
    
    /**
     * 
     * @var String 
     */
    public $LegalRepresentativeFirstName;
    
    /**
     * 
     * @var String 
     */
    public $LegalRepresentativeLastName;
    
    /**
     * 
     * @var String 
     */
    public $LegalRepresentativeAdress;
    
    /**
     * 
     * @var String 
     */
    public $LegalRepresentativeEmail;
    
    /**
     * 
     * @var Date 
     */
    public $LegalRepresentativeBirthday;
    
    /**
     * 
     * @var String 
     */
    public $LegalRepresentativeNationality;
    
    /**
     * 
     * @var String 
     */
    public $LegalRepresentativeCountryOfResidence;
    
    /**
     * 
     * @var String 
     */
    protected $Statute;
    
    /**
     * 
     * @var String 
     */
    protected $ProofOfRegistration;
    
    /**
     * 
     * @var String 
     */
    protected $ShareholderDeclaration;
    
    /**
     * Construct
     */
    function __construct($id = null) {
        parent::__construct($id);
        $this->setPersonType(PersonType::Legal);
    }
}