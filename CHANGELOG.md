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

 
