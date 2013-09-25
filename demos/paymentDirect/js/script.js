$(document).ready(function(){

    // Initialize mangoPay.cardRegistration object
    mangoPay.cardRegistration.init({
        cardRegistrationURL : cardRegistrationURL,
        preregistrationData : preregistrationData,
        accessKey : accessKey
    });

    // Action for button "Pay with Ajax"
    $("#payAjax").click(function() {

        // Disable button to prevent double click while waiting
        $("#payAjax").attr("disabled", true).val("Please wait...");

        // Collect sensitive card data from the form
        var cardData = {
            cardNumber : $("#paymentForm").find("input[name$='cardNumber']").val(),
            cardExpirationDate : $("#paymentForm").find("input[name$='cardExpirationDate']").val(),
            cardCvx : $("#paymentForm").find("input[name$='cardCvx']").val()
        };

        // Process data
        mangoPay.cardRegistration.sendDataWithAjax(
            // URL to capture response
            ajaxUrl,
            // Card data
            cardData,
            // Result Ajax callback
            function(data) { 
                $("#divForm").html(data); 
            },
            // Error Ajax callback
            function(xhr, status, error){ 
                alert("Payment error : " + xhr.responseText + " (" + status + " - " + error + ")");
            }
        );
    });

    // Action for button "Pay with Ajax or Redirect"
    $("#payAjaxOrRedirect").click(function(){

        // Disable button to prevent double click while waiting
        $("#payAjaxOrRedirect").attr("disabled", true).val("Please wait...");

        // Collect sensitive card data from the form
        var cardData = {
            cardNumber : $("#paymentForm").find("input[name$='cardNumber']").val(),
            cardExpirationDate : $("#paymentForm").find("input[name$='cardExpirationDate']").val(),
            cardCvx : $("#paymentForm").find("input[name$='cardCvx']").val()
        };

        // Process data
        mangoPay.cardRegistration.sendDataWithAjaxOrRedirect(
            // URL to capture response when CORS is available
            ajaxUrl,
            // URL to capture response when CORS is not available
            redirectUrl,
            // Card data
            cardData,
            // Result Ajax callback
            function(data) { 
                $("#divForm").html(data); 
            },
            // Error ajax callback
            function(xhr, status, error){ 
                alert("Payment error : " + xhr.responseText + " (" + status + " - " + error + ")");
            }
        );
    });

    // Action for button "Pay with Redirect"
    $("#payRedirect").click(function() {
        
        // Collect sensitive card data from the form
        var cardData = {
            cardNumber : $("#paymentForm").find("input[name$='cardNumber']").val(),
            cardExpirationDate : $("#paymentForm").find("input[name$='cardExpirationDate']").val(),
            cardCvx : $("#paymentForm").find("input[name$='cardCvx']").val()
        };
        
        // Process data  
        mangoPay.cardRegistration.sendDataWithRedirect(
            // URL to capture response
            redirectUrl,
            // Card data
            cardData
        );
    });
});