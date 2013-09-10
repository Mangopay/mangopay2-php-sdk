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

// build the return URL
$returnUrl = 'http://' . $_SERVER['HTTP_HOST'];
$returnUrl .= substr($_SERVER['REQUEST_URI'], 0, strripos($_SERVER['REQUEST_URI'], '/') + 1);
$returnUrl .= 'payment.php';

?>
<label>User</label>
<label><?php print $createdUser->FirstName . ' ' . $createdUser->LastName; ?></label>
<div class="clear"></div>

<label>Amount</label>
<label><?php print $_SESSION['amount'] . ' ' . $_SESSION['currency']; ?></label>
<div class="clear"></div>

<label>Fees amount</label>
<label><?php print $_SESSION['fees'] . ' ' . $_SESSION['currency']; ?></label>
<div class="clear"></div>

<form action="<?php print $createdCardRegister->CardRegistrationURL; ?>" method="post">
    <input type="hidden" name="data" value="<?php print $createdCardRegister->PreregistrationData; ?>" />
    <input type="hidden" name="accessKeyRef" value="<?php print $createdCardRegister->AccessKey; ?>" />
    <input type="hidden" name="returnURL" value="<?php print $returnUrl; ?>" />

    <label for="cardNumber">Card Number</label>
    <input type="text" name="cardNumber" value="" />
    <div class="clear"></div>

    <label for="cardExpirationDate">Expiration Date</label>
    <input type="text" name="cardExpirationDate" value="" />
    <div class="clear"></div>

    <label for="cardCvx">CVV</label>
    <input type="text" name="cardCvx" value="" />
    <div class="clear"></div>

    <input type="submit" id="postCall" value="Pay" />
</form>