<div class="row">

    <input type="hidden" id="payload_nonce" name="payload_nonce">
    <div class="col-md-12" id="dropin-container"></div>

</div>








    <script type="text/javascript">
        var cardStatus = false;
        var submitButton = document.querySelector("a[href^='#finish']");

        braintree.dropin.create({
            authorization: '{{$clientToken}}',
            container: '#dropin-container',
            form: '#createOrder',
        /*  paypal: {
              flow: 'checkout',
              amount: grad_total_amount,
              currency: 'EUR'
          }*/
      }, function (err, dropinInstance) {
          if (err) {
              // Handle any errors that might've occurred when creating Drop-in
              console.error(err);
              return;
          }
          submitButton.addEventListener('click', function () {
                 dropinInstance.requestPaymentMethod(function (err, payload,callback) {
                     if (err) {
                         // Handle errors in requesting payment method
                         console.log("err:", err);
                     }
                     cardStatus = true;
                     // Send payload.nonce to your server
                     console.log("payload:", payload);
                     $("#payload_nonce").val(payload.nonce);
                     save(cardStatus);
                 });
          });
      });
      function save(cardStatus) {
          $("#paymet_loading").show();
          if(cardStatus){
              $.post('/manager/order/create', $('#createOrder').serialize()).done(function (data) {
                  swal("Created!", "Order is created !", "success");
                  window.location = '/manager/order/timetable';
                  $("#paymet_loading").hide();
              }).fail(function (data) {
                  if (data.status === 422) {
                      var errors = data.responseJSON;
                      var errosHtml = "";
                      $.each(errors, function (key, value) {
                          toastr.options.positionClass = "toast-container toast-bottom-full-width";
                          toastr["error"](value);
                      });
                  }
                  $("#paymet_loading").hide();
              });

          }else{
              return false;
          }

      }

</script>
