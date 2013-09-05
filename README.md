MangoPay SDK
=================================================
MangoPaySDK is a PHP client library to work with
[MangoPay REST API](http://docs.mangopay.com/api-references/).


Installation
-------------------------------------------------
SDK has been written in PHP 5.5 and has no dependencies on external packages.
You only have to ensure that curl and openssl extensions (that are part of
standard PHP distribution) are enabled in your PHP installation.

The installation is as easy as downloading the package and storing it
under any location that will be available for including by

    require_once '{your-installation-dir}/MangoPaySDK/mangoPayApi.inc';

in your project (see examples below).


License
-------------------------------------------------
MangoPaySDK is distributed under MIT license, see LICENSE file.


Unit Tests
-------------------------------------------------
Tests are placed under {your-installation-dir}/tests.
The /tests/suites/all.php suite runs ALL tests.
You can also use any of /tests/cases/*.php to run a single test case.


Contacts
-------------------------------------------------
Report bugs or suggest features using
[issue tracker at GitHub](https://github.com/MangoPay/mangopay2-php-sdk).


Sample usage
-------------------------------------------------

    require_once '{your-installation-dir}/MangoPaySDK/mangoPayApi.inc';
    $api = new MangoPay\MangoPayApi();

    // get some user by id
    $john = $api->Users->Get($someId);

    // change and update some of his data
    $john->LastName .= " - CHANGED";
    $api->Users->Update($john);

    // get all users (with pagination)
    $pagination = new MangoPay\Pagination(1, 8); // get 1st page, 8 items per page
    $users = $api->Users->GetAll($pagination);

    // get his bank accounts
    $pagination = new MangoPay\Pagination(2, 10); // get 2nd page, 10 items per page
    $accounts = $api->Users->GetBankAccounts($john->Id, $pagination);


Client creation example (you need to call it only once)
-------------------------------------------------

    require_once '{your-installation-dir}/MangoPaySDK/mangoPayApi.inc';
    $api = new MangoPay\MangoPayApi();

    $client = $api->Clients->Create('your-client-id', 'your-client-name', 'your-client-email@sample.org');
    print($client->Passphrase); // you receive your password here


Configuration example
-------------------------------------------------

    require_once '{your-installation-dir}/MangoPaySDK/mangoPayApi.inc';
    $api = new MangoPay\MangoPayApi();

    $api->Config->ClientID = 'your-client-id';
    $api->Config->ClientPassword = 'your-client-password';
    print($api->Config->BaseUrl); // you probably dont have to change it

    // call some API methods...
    $users = $api->Users->GetAll();


Example with auth token reusage
-------------------------------------------------

    require_once '{your-installation-dir}/MangoPaySDK/mangoPayApi.inc';
    $api = new MangoPay\MangoPayApi();

    // optionally you can reuse token from previous requests (unless expired)
    $api->OAuthToken = $myTokensPersistenceService->loadIfStored();

    // call some API methods...
    $users = $api->Users->GetAll();

    // optionally store the token for future requests (until expires)
    $myTokensPersistenceService->store($api->OAuthToken);
