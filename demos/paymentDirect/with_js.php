<?php

// include MangoPay SDK
require_once '../../vendor/autoload.php';
require_once 'config.php';

// sample data to demo
$_SESSION['amount'] = 3300;
$_SESSION['currency'] = 'EUR';
$_SESSION['cardType'] = 'CB_VISA_MASTERCARD';//or alternatively MAESTRO or DINERS etc

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
$cardRegister->CardType = $_SESSION['cardType'];
$createdCardRegister = $mangoPayApi->CardRegistrations->Create($cardRegister);
$_SESSION['cardRegisterId'] = $createdCardRegister->Id;

// build the return URL to capture token response if browser does not support cross-domain Ajax requests
$returnUrl = 'http' . ( isset($_SERVER['HTTPS']) ? 's' : '' ) . '://' . $_SERVER['HTTP_HOST'];
$returnUrl .= substr($_SERVER['REQUEST_URI'], 0, strripos($_SERVER['REQUEST_URI'], '/') + 1);
$returnUrl .= 'payment.php';

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://rawgit.com/Mangopay/cardregistration-js-kit/master/kit/mangopay-kit.min.js"></script><!-- Or add the repo https://github.com/Mangopay/cardregistration-js-kit to your project -->
<script src="js/script.js"></script>

<script>
    var cardRegistrationURL = "<?php print $createdCardRegister->CardRegistrationURL; ?>";
    var preregistrationData = "<?php print $createdCardRegister->PreregistrationData; ?>";
    var cardRegistrationId = "<?php print $createdCardRegister->Id; ?>";
    var cardType = "<?php print $createdCardRegister->CardType; ?>";
    var accessKey = "<?php print $createdCardRegister->AccessKey; ?>";
    var ajaxUrl = "<?php print $returnUrl; ?>";
    var redirectUrl = "<?php print $returnUrl; ?>";
    
    mangoPay.cardRegistration.baseURL = "<?php print $mangoPayApi->Config->BaseUrl; ?>";
    mangoPay.cardRegistration.clientId = "<?php print $mangoPayApi->Config->ClientId; ?>";
</script>

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
        <br>

        <input type="button" value="Register with Ajax (will fail for non supporting CORS browsers)" id="payAjax" />
        <div class="clear"></div>
        <br>
        
        <input type="button" value="Register with Ajax or redirect if no CORS support" id="payAjaxOrRedirect" />
        <div class="clear"></div>
		<br>
		
        <input type="button" value="Register with redirect and then pay" id="payRedirect" />
        <div class="clear"></div>

    </form>

</div>
