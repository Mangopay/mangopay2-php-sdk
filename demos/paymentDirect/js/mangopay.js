var mangoPay = {

  cardRegistration : {

    /**
     * Initialize card registration object
     * 
     * @param {object} cardRegisterData Card pre-registration data {cardRegistrationURL, preregistrationData, accessKey}
     */
    init : function(cardRegisterData) {

        _cardRegisterData = cardRegisterData;

    },

    /**
     * Processes card registration and sends the result to given URL asynchronously
     * Requires a browser that supports cross-origin Ajax calls
     *
     * @param {string} ajaxUrl Your page to load asynchronously to process the payment
     * @param {object} data Sensitive card details {cardNumber, cardExpirationDate, cardCvx}
     * @param {function} resultCallback A function to invoke when the call to given ajaxUrl succeeds
     * @param {function} errorCallback A function to invoke when the call to given ajaxUrl fails
     */
    sendDataWithAjax : function(ajaxUrl, data, resultCallback, errorCallback) {

        // Get Payline token
        mangoPay._ajax({

            // Payline expects POST
            type: "post",

            // Payline service URL
            url: _cardRegisterData.cardRegistrationURL,

            // Force CORS
            crossDomain: true,

            // Sensitive card data plus pre-registration data and access key 
            data: {
                data: _cardRegisterData.preregistrationData,
                accessKeyRef: _cardRegisterData.accessKey,
                cardNumber: data.cardNumber,
                cardExpirationDate: data.cardExpirationDate,
                cardCvx: data.cardCvx
            },

            // Forward response to the return URL
            success: function(data) {

                var dataToSend = "";

                // Prepare data
                if (data === null ) {
                    dataToSend = { errorCode: '' };
                } else if (data.indexOf("data=") === 0) {
                    dataToSend = { data: data.replace("data=", "") };
                } else {
                    dataToSend = { errorCode: data.replace("errorCode=", "") };
                }

                // Send data to the return page
                mangoPay._ajax({
                    type: "get",
                    url: ajaxUrl,
                    data: dataToSend,
                    success: resultCallback,
                    error: errorCallback
                });

            },

            error: errorCallback

        });
    },

    /**
     * Processes card registration and sends the result to given URL asynchronously or redirects browser to the given URL to capture result
     * Automatically detects if browser is capable of making cross-origin Ajax calls
     *
     * @param {string} ajaxUrl Your page to call asynchronously to process the payment
     * @param {string} redirectUrl Your page browser will be redirected to process the payment
     * @param {object} data Sensitive card details {cardNumber, cardExpirationDate, cardCvx}
     * @param {function} resultCallback A function to invoke when the call to given ajaxUrl succeeds
     * @param {function} errorCallback A function to invoke when the call to given ajaxUrl fails
     */
    sendDataWithAjaxOrRedirect: function(ajaxUrl, redirectUrl, data, resultCallback, errorCallback) {

        // Check if browser is capable of making cross-origin Ajax calls
        if(mangoPay._browser.corsSupport()) {
            mangoPay.cardRegistration.sendDataWithAjax(ajaxUrl, data, resultCallback, errorCallback);
            return;
        }

        // Browser doesn't support CORS, use the form with page reload
        mangoPay.cardRegistration.sendDataWithRedirect(redirectUrl, data);

    },

    /**
     * Processes card registration and redirects browser to the given URL to capture result
     * Does not rely on browser's cross-origin Ajax support
     *
     * @param {string} redirectUrl Your page browser will be redirected to process the payment
     * @param {object} data Sensitive card details {cardNumber, cardExpirationDate, cardCvx}
     */
    sendDataWithRedirect : function(redirectUrl, data) {

        // Build the form and append to the document
        var form = document.createElement('form');
        form.setAttribute('action', _cardRegisterData.cardRegistrationURL);
        form.setAttribute('method', 'post');
        form.setAttribute('style', 'display: none');
        document.getElementsByTagName('body')[0].appendChild(form);

        // Add card registration data to the form
        form.appendChild(mangoPay._getInputElement('data', _cardRegisterData.preregistrationData));
        form.appendChild(mangoPay._getInputElement('accessKeyRef', _cardRegisterData.accessKey));
        form.appendChild(mangoPay._getInputElement('cardNumber', data.cardNumber));
        form.appendChild(mangoPay._getInputElement('cardExpirationDate', data.cardExpirationDate));
        form.appendChild(mangoPay._getInputElement('cardCvx', data.cardCvx));
        form.appendChild(mangoPay._getInputElement('returnURL', redirectUrl));

        // Submit the form
        form.submit();

    }

  },

  /**
   * PRIVATE. Builds a hidden form field DOM element
   *
   * @param {string} name Field name
   * @param {string} value Field value
   */
  _getInputElement : function(name, value) {
      var input = document.createElement('input');
      input.setAttribute('type', 'hidden');
      input.setAttribute('name', name);
      input.setAttribute('value', value);
      return input;
  },

  /**
   * PRIVATE. Performs an asynchronous HTTP (Ajax) request
   *
   * @param {object} settings {type, crossDomain, url, data, success, error}   
   */
  _ajax: function(settings) {

      // XMLHttpRequest object
      var xmlhttp = new XMLHttpRequest();

      // Put together input data as string
      var parameters = "";
      for(key in settings.data) {
          parameters += (parameters.length > 0 ? '&' : '' ) + key + "=" + encodeURIComponent(settings.data[key]);
      }

      // URL to hit, with parameters added for GET request
      var url = settings.url;
      if (settings.type === "get") {
          url = settings.url + (settings.url.indexOf("?") > -1 ? '&' : '?') + parameters;
      }

      // Cross-domain requests in IE 7, 8 and 9 using XDomainRequest
      if (settings.crossDomain && !("withCredentials" in xmlhttp) && window.XDomainRequest) {
          xdr = new XDomainRequest();
          xdr.onerror = function(){ settings.error(xdr); };
          xdr.onload = function(){ settings.success(xdr.responseText); };
          xdr.open(settings.type, url);
          xdr.send(settings.type === "post" ? parameters : null);
          return;
      }

      // Attach success and error handlers
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4) {
           if (xmlhttp.status == 200) {
                settings.success(xmlhttp.responseText);
           } else {
                settings.error(xmlhttp, xmlhttp.status, xmlhttp.statusText);
           }
         }
      };

      // Open connection
      xmlhttp.open(settings.type, url, true);

      // Send extra header for POST request
      if (settings.type === "post") {
         xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      }

      // Send data
      xmlhttp.send(settings.type === "post" ? parameters : null);

  },

  _browser : {

    /**
     * Returns true if browser is capable of making cross-origin Ajax calls
     */
    corsSupport : function() {

        // IE 10 and above, Firefox, Chrome, Opera etc.
        if ("withCredentials" in new XMLHttpRequest()) {
            return true;
        }

        // IE 8 and IE 9
        if (window.XDomainRequest) {
            return true;
        }

        return false;

    }

  }

};

