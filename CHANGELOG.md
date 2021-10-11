## [3.8.0] - 2021-10-11
## Added

### Payconiq

As requested by numerous clients, we are now providing [Payconiq](https://www.payconiq.be) as a new mean-of-payment. To request access, please contact MANGOPAY.

### Flags for KYC documents

**We provide more information regarding refused KYC documents.** Therefore it will be easier for you to adapt your app behavior and help your end user.

You are now able to see the exact explanation thanks to a new parameter called “Flags”.

It has been added to

`MangoPay::KycDocument.fetch(new_natural_user['Id'], new_document['Id'])`

It will display one or several error codes that provide the reason(s) why your document validation has failed. These error codes description are available [here](https://docs.mangopay.com/guide/kyc-document).

## [3.7.1] - 2021-08-10
## Fixed

- Better support of more PHPUnit versions
- Cleanup the vendor bundle, to reduce the size of the SDK

Thanks williamdes for your help

## [3.7.0] - 2021-08-10
## Fixed

- ChargeDate has been added for PayInPaymentDetailsDirectDebit
- Change `FallbackReason` parameter's type to object in PayOutPaymentDetailsBankWire

## Added

- You can now update and view a Recurring PayIn Registration object. To know more about this feature, please consult the documentation [here](https://docs.mangopay.com/guide/recurring-payments-introduction).
- To improve recurring payments, we have added new parameters for CIT : DebitedFunds & Fees. To know more about this feature, please consult the documentation [here](https://docs.mangopay.com/endpoints/v2.01/payins#e1053_create-a-recurring-payin-cit)

## [3.6.0] - 2021-06-10
## Added

We have added a new feature **[recurring payments](https://docs.mangopay.com/guide/recurring-payments)** dedicated to clients needing to charge a card repeatedly, such as subscriptions or payments installments.

You can start testing in sandbox, to help you define your workflow. This release provides the first elements of the full feature.

- [Create a Recurring PayIn Registration object](https://docs.mangopay.com/endpoints/v2.01/payins#e1051_create-a-recurring-payin-registration), containing all the information to define the recurring payment
- [Initiate your recurring payment flow](https://docs.mangopay.com/endpoints/v2.01/payins#e1053_create-a-recurring-payin-cit) with an authenticated transaction (CIT) using the Card Recurring PayIn endpoint
- [Continue your recurring payment flow](https://docs.mangopay.com/endpoints/v2.01/payins#e1054_create-a-recurring-payin-mit) with an non-authenticated transaction (MIT) using the Card Recurring PayIn endpoint

This feature is not yet available in production and you need to contact the Support team to request access.

## [3.5.0] - 2021-05-27
## Added

### Instant payment

Mangopay introduces the instant payment mode. It allows payouts (transfer from wallet to user bank account) to be processed within 25 seconds, rather than the 48 hours for a standard payout.

You can now use this new type of payout with the PHP SDK.

Example :

```php
$payOutGet = $this->_api->PayOuts->GetBankwire($payOut->Id);
// where $payOut->Id is the id of an existing payout
```

Please note that this feature must be authorized and activated by MANGOPAY. More information [here](https://docs.mangopay.com/guide/instant-payment-payout).

### Accepted PRs

- Improved documentation around ubo declaration reason
- ResponseError object improvement

## [3.4.0] - 2021-05-11
## Fixed

### IBAN for testing purposes

⚠️ **IBAN provided for testing purpose should never be used outside of a testing environement!**

More information about how to test payments, click [here](https://docs.mangopay.com/guide/testing-payments).

### Others

- Fix Shipping was missing Libraries\Dto thank you @ericabouaf
- Fix `BankAccount` IBAN reference for tests
- FIX path oauth/token erreur 404 url not found. Thank you @rachedbelhadj

## Added

### New events for PreAuthorization

Some of you use a lot the [PreAuthorization](https://docs.mangopay.com/endpoints/v2.01/preauthorizations#e183_the-preauthorization-object) feature of our API. To make your life easier, we have added three new events :

- PREAUTHORIZATION_CREATED
- PREAUTHORIZATION_SUCCEEDED
- PREAUTHORIZATION_FAILED

The goal is to help you monitor a PreAuthorization with a [webhook](https://docs.mangopay.com/endpoints/v2.01/hooks#e246_the-hook-object).

*Example: If a PreAuthorization is desynchronized, when the status is updated, you will be able to know it.*

### PSR4 / PSR12 compliance

- Thanks to @MockingMagician, the SDK is PSR4 / PSR12 compliant. That help your IDE and make sure you can run tests on case-sensitive system. Plus, docker environments has been added to run tests locally in all PHP major versions.

## Changed
- To better illustrate the fact that Rate Limiting Reset is a timestamp, we have change $rateLimits[0]->ResetTimeMillis to $rateLimits[0]->ResetTimeTimestamp

## [3.3.0] - 2021-03-25
## Added

### On demand feature for 3DSv2

> **This on-demand feature is for testing purposes only and will not be available in production**

#### Request

We've added a new parameter `Requested3DSVersion` (not mandatory) that allows you to choose between versions of 3DS protocols (managed by the parameter `SecureMode`). Two values are available:
* `V1`
* `V2_1`

If nothing is sent, the flow will be 3DS V1.

The `Requested3DSVersion` may be included on all calls to the following endpoints:
* `/preauthorizations/card/direct`
* `/payins/card/direct`

#### Response

In the API response, the `Requested3DSVersion` will show the value you requested:
* `V1`
* `V2_1`
* `null` – indicates that nothing was requested

The parameter `Applied3DSVersion` shows you the version of the 3DS protocol used. Two values are possible:
* `V1`
* `V2_1`

## Fixed

* Fixed UBO declaration by adding missing `UserId`
* Added missing `Billing` in `/payins/card/web`
* Test on `IpAddress` presence in `/payins/card/direct`



# [3.2.0] - 2021-02-19
- 3DS2 integration with Shipping and Billing objects, including FirstName and a LastName fields
The objects Billing and Shipping may be included on all calls to the following endpoints:
  - /preauthorizations/card/direct
  - /payins/card/direct
  - /payins/card/web
- Activate Instant Payment for payouts by adding a new parameter PayoutModeRequested on the following endpoint /payouts/bankwire
  - The new parameter PayoutModeRequested can take two differents values : "INSTANT_PAYMENT" or "STANDARD" (STANDARD = the way we procede normaly a payout request)
  - This new parameter is not mandatory and if empty or not present, the payout will be "STANDARD" by default
  - Instant Payment is in beta all over Europe - SEPA region
- Fix inverted params for PHP compatibility : Due to compatibility issues with newer versions of PHP we have inverted params in certain methods, including constructor, please check the release code for further detail 🔄
- Fix method ScopeBlocked for blocked status
- Fix BrowserInfo class
# [3.1.6] -  2020-12-18
Added IpAddress and BrowserInfo parameters to the following endpoints and corresponding objects
- /payins/card/direct
- /preauthorizations/card/direct

Added 'NO_CHOICE' value for the SecureMode parameter
# [3.1.5] - 2020-12-11
- Removed testing older PHP testing versions
- Added 'Regulatory' endpoint to allow checks of User Block Status
- Added support for Regulatory -> Blocked Status Hooks
- Added methods for creating Client bank accounts and client payouts
## [3.1.4] - 2020-10-23
- New endpoint : GET .../v2.01/ClientId/preauthorizations/PreAuthorizationId/transactions/ which allows multiple transactions to be listed
- Testing config changes for TLS, this was blocking a part of the deploy process
- Sorting::_sortFields changed to avoid an error when calling GetSortParameter()
- Changed ignore phpunit-cache and minor "Field" typo
- removed php 5.4 and 5.5 from travis and updated curl ssl version

## [3.1.2] - 2020-09-25
- New endpoint to support changes to Card Validation process (please listen out for product announcements)
- New RemainingFunds Parameters (Complete feature not fully activated, please listen for product announcements)
- Fix to PayInWebExtendedView

## [3.1.1] - 2020-08-28
- As part of KYC improvements, we are adding an OUT_OF_DATE status for KYC documents
- New MultiCapture Parameter added to Preauthorization object (Complete feature not fully activated, please listen for product announcements)
- "User-agent" format in the headers changed, aligned to other assets
- Improvements to error handling for RestTool.php requests

## [3.1.0]
- USER_KYC_REGULAR has been added as a new Event. Thanks to it, you are now able to know when all the needed KYCs for a user have been validated and its KYCLevel is updated.
- Release adds typing for EventType values KYC_OUTDATED USER_KYC_REGULAR and USER_KYC_LIGHT
- Updated filtering on user Cards list
- Google Pay are ready to be supported!
- AccountNumber has been added for Payin External Instruction as a part of DebitedBankAccountDetails. Funds from a non-IBAN account are now better identified.

## [3.0.0]
### BREAKING CHANGES
- Add a new `PAYLINEV2` parameter for Payin Web Card only. You must now use `PayInCardTemplateURLOptions` object instead of `PayInTemplateURLOptions` (if you use custom Template). You can always use `PayInTemplateURLOptions`for all of your Payin Direct Debit Web.

## [2.13.2]
### Added
- Mandate Status `EXPIRED` and EventType `MANDATE_EXPIRED` have been added.

## [2.13.1]
### Fixed
- Deprecated syntax on RestTool.php file for PHP 7.4 version.

## [2.13.0]
### Added
- ApplePay `Payin` functions are now available. More info about activation to come in the following weeks...  
- `UBODeclaration` can be retrieved only with its ID thanks to new `GetById`function
- `COUNTERFEIT_PRODUCT` added as a new `DisputeReasonType`
- `GetEMoney` function has been fixed due to too many mandatory parameters.

## [2.12.2] - 2019-09-11
### Changed
- GET EMoney method now supports year and month parameters. More info on our [docs](https://docs.mangopay.com/endpoints/v2.01/user-emoney#e895_view-a-users-emoney)
### Fixed
- Add missing `isActive`property for `UBOs`

## [2.12.1] - 2019-06-13
### Fixed
- missing UBO EventTypes has been added 

## [2.12.0] - 2019-05-21
### Added
- new [`UBODelaration`](https://docs.mangopay.com/endpoints/v2.01/ubo-declarations#e1024_the-ubo-declaration-object) submission system
- `CompanyNumber` support for [Legal `Users`](https://docs.mangopay.com/endpoints/v2.01/users#e259_create-a-legal-user)
### Fixed
- Pagination has been fixed as total pages/items value was always zero.

 
