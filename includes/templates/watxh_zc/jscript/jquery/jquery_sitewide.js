function concatExpiresFields(fields) {
    return $(":input[name=" + fields[0] + "]").val() + $(":input[name=" + fields[1] + "]").val();
}

function methodSelect(theMethod) {
  if (document.getElementById(theMethod)) {
    document.getElementById(theMethod).checked = 'checked';
  }
}

function doesCollectsCardDataOnsite(paymentValue)
{
    if ($('#'+paymentValue+'_collects_onsite').val()) {
        if($('#pmt-'+paymentValue).is(':checked')) {
            return true;
        }
        if ($("[name='payment']").length == 1) {
          return true;
        }
    }
    return false;
}

function doCollectsCardDataOnsite()
{
   var str = $('form[name="checkout_payment"]').serializeArray();

   zcJS.ajax({
    url: "ajax.php?act=ajaxPayment&method=prepareConfirmation",
    data: str
  }).done(function( response ) {
   $('#checkoutPayment').hide();
   $('#navBreadCrumb').html(response.breadCrumbHtml);
   $('#checkoutPayment').before(response.confirmationHtml);
   $(document).attr('title', response.pageTitle);
 });
}

// jQuery(document).ready(function(){
    
//     jQuery('form[name="checkout_payment"]').submit(function() {
//         jQuery('#paymentSubmit').attr('disabled', true);
//         if ($flagOnSubmit) { 
//             formPassed = check_form();
//             if (formPassed == false) {
//                 jQuery('#paymentSubmit').attr('disabled', false);
//             }
//             return formPassed;
//         }
//     });
// });

jQuery(document).ready(function() {
  const cards = jQuery('.cart-card');
  const checkOutLink = jQuery('.cart-checkout');
  jQuery('.mini-cart-qty-update').click(function() {
    let pid = jQuery(this).data('pid');
    let value = jQuery('#cart-card_' + pid + ' .mini-cart-input').val();
    let price = parseFloat(jQuery(this).data('value'));
    let total = (value * price).toFixed(2);

    jQuery('#cart-card_' + pid + ' .cart-price-total p').text(`$${total}`);
    
    // Recalculate the final total from scratch
    let setFinalTotal = 0;
    cards.each(function() {
      const priceTotal = jQuery(this).find('.cart-price-total p').text().trim();
      const parseTotal = parseFloat(priceTotal.replace(/[^0-9.]/g, '')) || 0;
      setFinalTotal += parseTotal;
    });

    // Update the final total in the cart
    jQuery('.mini-cart-total-final h3').text(`$${setFinalTotal.toFixed(2)}`);
    if(checkOutLink) checkOutLink.text(`Checkout - $${setFinalTotal.toFixed(2)}`);
  });

  const fc5 = document.querySelector('#checkoutpaymentBody .form-control.form-control-5');
  if(fc5) fc5.innerHTML = fc5.innerHTML.replace(/&nbsp;/g, '');

  jQuery(".form-control input[type='text']").each(function () {
    let $input = jQuery(this);
    let $label = $input.siblings("label");

    function updateLabel() {
      if ($input.val().trim() !== "" || $input.is(":focus")) {
        $label.addClass("input-active");
      } else {
        $label.removeClass("input-active");
      }
    }
  
    $input.on("focus blur input", updateLabel);
    updateLabel();
  });

  jQuery('#btn-place-order').click(function() {
    jQuery('.button_continue_checkout').click();
  })
});