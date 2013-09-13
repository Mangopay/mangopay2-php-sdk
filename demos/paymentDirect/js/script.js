$(document).ready(function(){

  // attach to payment button click
  $("#payButton").click(function(){

    // disable button to prevent double click while waiting
    $("#payButton").attr("disabled", true).val("Please wait...");

    // invoke MangoPay helper function to handle card registration
    MangoPaySDK.Card.GetRegistrationData({

      paymentForm: $("#paymentForm"),

      resultCallback: function(data){
        $("#divForm").html(data);
      },

      errorCallback: function(xhr, status, error){ 
        alert("Payment error : " + xhr.responseText + " (" + status + " - " + error + ")");
      }

    });

  });

});