<?php
namespace MangoPay;

/**
 * Configuration settings
 */
class Configuration {
	
	/**
     * Client Id
     * @var string 
     */
	public $ClientId;
	
	/**
     * Client password
     * @var string 
     */
	public $ClientPassword;
	
	/**
     * Base URL to MangoPay API
     * @var string 
     */
	public $BaseUrl;
	
	/**
	 * [readonly] Authentication type - always of value "Strong"
	 * @var string
	 */
	private $AuthenticationType = "Strong";
	
	
	function __get($name) {
        if($name === 'AuthenticationType') {
            return $this->$name;
		}
    }
    function __set($name, $value) {
		if($name === 'AuthenticationType') {
			throw new Exception ('Cannot modify AuthenticationType. It is read-only.');
		}
    }
	
}