<?php
/**
 * Setting for client: client ID and client password
 */
define('MangoPay_ClientID', 'mosaiclab');
define('MangoPay_ClientPassword', 'FPpPoofN837Y0MxRXnKVH31kJ2dLc54oT481R55KEkjeQ6Bph4');

/**
 * Base URL to MangoPay API
 */
define('MangoPay_BaseUrl', 'https://mangopay-api-inte.leetchi.com');

/**
 * Possible are two type of authentication:
 *      'Basic' - Basic Access Authentication
 *      'Strong' - OAuth 2.0 : Client Credentials Grant
 */
define('MangoPay_AuthenticationType', 'Strong');
//define('MangoPay_AuthenticationType', 'Basic');

/**
 * Constant to switch debug mode - display all request and response data
 */
define('MangoPay_DebugMode', 0);
//define('MangoPay_DebugMode', 1);
