<?php
// include MangoPay SDK
require_once '../../MangoPaySDK/mangoPayApi.inc';

// sample data to demo
$_SESSION['amount'] = 3300;
$_SESSION['currency'] = 'EUR';
$_SESSION['fees'] = 10;

// create instance of MangoPayApi SDK
$mangoPayApi = new \MangoPay\MangoPayApi();

// create temporary user
$user = new MangoPay\UserNatural();
$user->FirstName = 'John';
$user->LastName = 'Smith';
$createdUser = $mangoPayApi->Users->Create($user);

// register card
$cardRegister = new \MangoPay\CardRegistration();
$cardRegister->UserId = $createdUser->Id;
$cardRegister->Currency = $_SESSION['currency'];
$createdCardRegister = $mangoPayApi->CardRegistrations->Create($cardRegister);
$_SESSION['cardRegisterId'] = $createdCardRegister->Id;

// build the return URL for POST request if browser not supports 
// cross-domain ajax requests
$returnUrl = 'http://' . $_SERVER['HTTP_HOST'];
$returnUrl .= substr($_SERVER['REQUEST_URI'], 0, strripos($_SERVER['REQUEST_URI'], '/') + 1);
$returnUrl .= 'payment.php';

?>

<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery.xdomainrequest.min.js"></script>
<script src="js/script.js"></script>

<div id ="divForm">
    <label>User</label>
    <label><?php print $createdUser->FirstName . ' ' . $createdUser->LastName; ?></label>
    <div class="clear"></div>

    <label>Amount</label>
    <label><?php print $_SESSION['amount'] . ' ' . $_SESSION['currency']; ?></label>
    <div class="clear"></div>

    <label>Fees amount</label>
    <label><?php print $_SESSION['fees'] . ' ' . $_SESSION['currency']; ?></label>
    <div class="clear"></div>

    <form action="<?php print $createdCardRegister->CardRegistrationURL; ?>" method="post" id="paymentForm">

        <input type="hidden" id="url" value="<?php print $createdCardRegister->CardRegistrationURL; ?>" />
        <input type="hidden" id="data" name="data" value="<?php print $createdCardRegister->PreregistrationData; ?>" />
        <input type="hidden" id="accessKeyRef" name="accessKeyRef" value="<?php print $createdCardRegister->AccessKey; ?>" />
        <input type="hidden" name="returnURL" value="<?php print $returnUrl; ?>" />

        <label for="cardNumber">Card Number</label>
        <input type="text" name="cardNumber" id="cardNumber" value="" />
        <div class="clear"></div>

        <label for="cardExpirationDate">Expiration Date</label>
        <input type="text" name="cardExpirationDate" id="cardExpirationDate" value="" />
        <div class="clear"></div>

        <label for="cardCvx">CVV</label>
        <input type="text" name="cardCvx" id="cardCvx" value="" />
        <div class="clear"></div>

        <input type="button" id="button" value="Pay" />
    </form>
</div>