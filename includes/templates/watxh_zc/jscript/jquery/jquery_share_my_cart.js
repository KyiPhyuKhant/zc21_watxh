jQuery(document).ready(function() {
    jQuery(document).on('click', '.share-my-cart-link', function(e) {
        e.preventDefault();
        jQuery.ajax({
            url: 'ajax/create_shared_cart.php',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    jQuery('.alert-message').remove();
                    jQuery('.share-my-cart-sns-container').remove();
                    jQuery('.link-cont').remove();
                    // Share by Facebook, Twitter and Email
                    jQuery('#share-my-cart-modal').append(`<div class="share-my-cart-sns-container">
                                            <div class="fb-icon" title="Facebook icon">${response.facebook}</div>
                                            <div class="twitter-icon" title="Twitter icon">${response.twitter}</div>
                                            <div class="user-email-icon" >${response.email}</div>`);
                    jQuery('#share-my-cart-modal').append(`<div class="link-cont">
                        <p class="alert-message">${response.message}</p>
                        <div class="input-cont">    
                            <input class="input" value="${response.url}"/>
                            <a class="js-clipboard" title="Copy the link icon" href="javascript: alert('Link code copied to clipboard!');" 
                            data-clipboard-text="${response.url}"></a>
                        </div>
                    </div>`);

                    jQuery('.modal-wrap').css('display', 'flex');
                    new ClipboardJS(".js-clipboard");
                }

                else if (!response.success) {
                    jQuery('.alert-message').remove();
                    jQuery('#share-my-cart-modal').append(`<p class="messageStackError alert-message"> ${response.message}</p>`); 
                    jQuery('.modal-wrap').css('display', 'flex');
                }
            }
        });
    });


    $("#share-my-cart-modal").on("click", ".close-node", function() {
        jQuery('.modal-wrap').css('display', 'none');
    });
});