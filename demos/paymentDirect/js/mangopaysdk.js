var MangoPaySDK = {

  Card: {

    GetRegistrationData: function(params) {

      // Payment form
      var paymentForm = $(params.paymentForm);

      // Browser doesn't support cross-origin resource sharing, submit the form traditionally
      if (!$.support.cors) {
        paymentForm.submit();
        return;
      }

      // Get Payline token
      $.ajax({

        type: "POST",

        url: paymentForm.attr('action'),

        // Collect sensitive data from the payment form
        data: {
          data: paymentForm.find("input[name$='data']").val(),
          accessKeyRef: paymentForm.find("input[name$='accessKeyRef']").val(),
          cardNumber: paymentForm.find("input[name$='cardNumber']").val(),
          cardExpirationDate: paymentForm.find("input[name$='cardExpirationDate']").val(),
          cardCvx: paymentForm.find("input[name$='cardCvx']").val()
        },

        // Forward response to the return URL
        success: function(data){

          var dataToSend = "";

          // Prepare data
          if (data != null && data.indexOf("data=") === 0) {
            dataToSend = { data: data.replace("data=", "") };
          }
          else {
            dataToSend = { errorCode: data.replace("errorCode=", "") };
          }

          // Ajax return URL
          var returnUrl = paymentForm.find("input[name$='ajaxURL']").val() || paymentForm.find("input[name$='returnURL']").val();

          // Send data to the return page
          $.ajax({
            type: "GET",
            url: returnUrl,
            data: dataToSend,
            success: params.resultCallback,
            error: params.errorCallback
          });

        },

        error: params.errorCallback

      });

    }

  }

};

