// Checks if the current browser supports cross-domain requests (CORS)
function browserSupportsCors() {
    if ($.support.cors)
        return true;
    else if (window.XDomainRequest)
        return true;
    else
        return false;
}

$(document).ready(function(){

// Handle 
$("#PayButton").click(function(){

    // if browser does not support cross-domain Ajax requests submit the form with POST
    if (!browserSupportsCors()) {
        $("#paymentForm").submit();
        return;
    }

    // disable button to prevent double clicks
    $("#PayButton").attr("disabled", true);

    // send token request using Ajax
    $.ajax({
        type: "POST",
        url: $("#paymentForm").attr("action"),
        data: {
            data: $("#data").val(),
            accessKeyRef: $("#accessKeyRef").val(),
            cardNumber: $("#cardNumber").val(),
            cardExpirationDate: $("#cardExpirationDate").val(),
            cardCvx: $("#cardCvx").val()
        },
        success: function(data){
            // parse data from Payline service
            if (data.indexOf("errorCode=") === 0)
                dataToSend = { errorCode: data.replace("errorCode=", "") };
            else
                dataToSend = { data: data.replace("data=", "") };

            // Forward token response to create payment
            $.ajax({
                type: "GET",
                url: "payment.php",
                data: dataToSend,
                success: function(data){
                    $("#divForm").html(data);
                },
                error:function (xhr, status, error){
                    alert("Payment error : " + xhr.responseText + " (" + status + " - " + error + ")");
                }
            });
        },
        error:function (xhr, status, error){
            alert("Ajax error : " + xhr.responseText + " (" + status + " - " + error + ")");
        }
    });
});
});