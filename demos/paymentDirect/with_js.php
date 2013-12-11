<?php

// include MangoPay SDK
require_once '../../MangoPaySDK/mangoPayApi.inc';
require_once 'config.php';

// sample data to demo
$_SESSION['amount'] = 3300;
$_SESSION['currency'] = 'EUR';

// create instance of MangoPayApi SDK
$mangoPayApi = new \MangoPay\MangoPayApi();
$mangoPayApi->Config->ClientId = MangoPayDemo_ClientId;
$mangoPayApi->Config->ClientPassword = MangoPayDemo_ClientPassword;
$mangoPayApi->Config->TemporaryFolder = MangoPayDemo_TemporaryFolder;

// create user for payment
$user = new MangoPay\UserNatural();
$user->FirstName = 'John';
$user->LastName = 'Smith';
$user->Email = 'email@domain.com';
$user->Address = "Some Address";
$user->Birthday = time();
$user->Nationality = 'FR';
$user->CountryOfResidence = 'FR';
$user->Occupation = "programmer";
$user->IncomeRange = 3;
$createdUser = $mangoPayApi->Users->Create($user);

// register card
$cardRegister = new \MangoPay\CardRegistration();
$cardRegister->UserId = $createdUser->Id;
$cardRegister->Currency = $_SESSION['currency'];
$createdCardRegister = $mangoPayApi->CardRegistrations->Create($cardRegister);
$_SESSION['cardRegisterId'] = $createdCardRegister->Id;

// build the return URL to capture token response if browser does not support cross-domain Ajax requests
$returnUrl = 'http' . ( isset($_SERVER['HTTPS']) ? 's' : '' ) . '://' . $_SERVER['HTTP_HOST'];
$returnUrl .= substr($_SERVER['REQUEST_URI'], 0, strripos($_SERVER['REQUEST_URI'], '/') + 1);
$returnUrl .= 'payment.php';

?>

<script>
    var cardRegistrationURL = "<?php print $createdCardRegister->CardRegistrationURL; ?>";
    var preregistrationData = "<?php print $createdCardRegister->PreregistrationData; ?>";
    var accessKey = "<?php print $createdCardRegister->AccessKey; ?>";
    var ajaxUrl = "<?php print $returnUrl; ?>";
    var redirectUrl = "<?php print $returnUrl; ?>";
</script>

<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/mangopay.js"></script>
<script src="js/script.js"></script>

<p>
  <i>
    Shows how to register the card using JavaScript Kit <br />
    and process payments asynchronously or with page reload.
  </i>
</p>

<div id ="divForm">
    <label>Full Name</label>
    <label><?php print $createdUser->FirstName . ' ' . $createdUser->LastName; ?></label>
    <div class="clear"></div>

    <label>Amount</label>
    <label><?php print $_SESSION['amount'] . ' ' . $_SESSION['currency']; ?></label>
    <div class="clear"></div>

    <form id="paymentForm">
        <label for="cardNumber">Card Number</label>
        <input type="text" name="cardNumber" value="" />
        <div class="clear"></div>

        <label for="cardExpirationDate">Expiration Date</label>
        <input type="text" name="cardExpirationDate" value="" />
        <div class="clear"></div>

        <label for="cardCvx">CVV</label>
        <input type="text" name="cardCvx" value="" />
        <div class="clear"></div>

        <input type="button" value="Pay with Ajax" id="payAjax" />
        <div class="clear"></div>
        
        <input type="button" value="Pay with Ajax or redirect" id="payAjaxOrRedirect" />
        <div class="clear"></div>

        <input type="button" value="Pay with redirect" id="payRedirect" />
        <div class="clear"></div>

    </form>

</div>