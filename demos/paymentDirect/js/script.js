// function to check that current browser supports cross-domain requests
function browserSupportsCors() {
    if ($.support.cors)
        return true;
    else if (window.XDomainRequest)
        return true;
    else
        return false;
}

$(document).ready(function(){
// set onclick event for Pay button
$("#button").click(function(){
    // if browser not supports cross-domain ajax requests call POST request
    if (!browserSupportsCors()) {
        $("#paymentForm").submit();
        return;
    }
    // set button as disabled
    $("#button").attr("disabled", true);
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

            // AJAX call to create payment
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