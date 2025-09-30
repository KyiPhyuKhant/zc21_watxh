<?php

/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=about_us.<br />
 * Displays About Us page.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_about_us_default.php  v1.3 $
 */
?>
<?php
// require the html_define for the privacy page
// require($define_page);


?>

<!-- FAQs -->
<section class="faqs">
 <div class="container">
  <div class="faqs-header">
   <h3>FAQs</h3>
   <h4>General Information</h4>
  </div>
  <div class="row">
   <div class="faqs-content">
    <div class="accordion">
     <div class="accordion-container">
      <div class="accordion-header">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
       <h4>Do you ship overseas</h4>
      </div>
      <div class="accordion-content">
       <p>
        We accept major credit cards such as Visa, Mastercard, American Express, and Discover. We also
        offer payment options like PayPal and Apple Pay for your convenience.
       </p>
      </div>
     </div>
     <div class="accordion-container">
      <div class="accordion-header">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
       <h4>Do you offer international shipping?</h4>
      </div>
      <div class="accordion-content">
       <p>
        Yes, we offer international shipping to select countries. During the checkout process, you can
        choose your location, and the shipping options available for your country will be displayed.
       </p>
      </div>
     </div>
     <div class="accordion-container">
      <div class="accordion-header">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
       <h4>Can I track my order once it has been shipped?</h4>
      </div>
      <div class="accordion-content">
       <p>
        Absolutely! Once your order is shipped, we will provide you with a tracking number. You can use
        this tracking number to monitor the progress of your shipment through our website or the shipping
        carrier's website.
       </p>
      </div>
     </div>
     <div class="accordion-container">
      <div class="accordion-header">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
       <h4>What is your return policy?</h4>
      </div>
      <div class="accordion-content">
       <p>
        We offer a hassle-free return policy. If you are not completely satisfied with your purchase, you
        may return the watch within 30 days of delivery for a refund or exchange. Please review our
        Returns and Exchanges page on our website for more details.
       </p>
      </div>
     </div>
     <div class="accordion-container">
      <div class="accordion-header">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
       <h4>Are your watches covered by a warranty?</h4>
      </div>
      <div class="accordion-content">
       <p>
        Yes, all our watches are covered by a manufacturer's warranty. The specific warranty period and
        coverage details vary by brand and model. Please refer to the warranty information provided with
        your watch or contact our customer support team for more information.
       </p>
      </div>
     </div>
     <div class="accordion-container">
      <div class="accordion-header">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
       <h4>How can I determine the right watch size for my wrist?</h4>
      </div>
      <div class="accordion-content">
       <p>
        To determine the right watch size for your wrist, we recommend measuring your wrist circumference
        using a flexible measuring tape or a piece of string. You can find detailed instructions and a
        size guide on our website to help you choose the perfect fit.
       </p>
      </div>
     </div>
     <div class="accordion-container">
      <div class="accordion-header">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
       <h4>Do you offer watch strap replacements or additional straps?</h4>
      </div>
      <div class="accordion-content">
       <p>
        Yes, we offer a range of watch strap replacements and additional straps for select watch models.
        You can explore our collection of straps on our website or contact our customer support team for
        assistance in finding the right strap for your watch.
       </p>
      </div>
     </div>
     <div class="accordion-container">
      <div class="accordion-header">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
       <h4>Are the watches you sell authentic and brand new?</h4>
      </div>
      <div class="accordion-content">
       <p>
        Absolutely! We pride ourselves on offering only authentic, brand new watches. We work directly
        with authorized dealers and trusted suppliers to ensure the authenticity and quality of every
        watch we sell.
       </p>
      </div>
     </div>
     <div class="accordion-container">
      <div class="accordion-header">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
       <h4>Can I visit your physical store to see the watches in person?</h4>
      </div>
      <div class="accordion-content">
       <p>
        Yes, you are more than welcome to visit our physical store located in [insert location]. Our
        knowledgeable staff will be delighted to assist you and provide a hands-on experience with our
        exquisite timepieces.
       </p>
      </div>
     </div>
    </div>
   </div>
   <div class="faqs-form">
    <?php
    if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
    ?>
    <!--  -->
    <p><?php echo TEXT_SUCCESS; ?></p>
    <?php
    } ?>
    <h4>Ask a Question</h4>
    <form action="<?php echo zen_href_link(FILENAME_CONTACT_US, 'action=send'); ?>" method="post">
     <?php {
     ?>
     <?php if ($messageStack->size('contact') > 0) echo $messageStack->output('contact'); ?>
     <?php
      // show dropdown if set
      if (CONTACT_US_LIST != '') {
      ?>
     <?php
      }
      ?>
     <div class="form-group">
      <div class="input-group">
       <select name="<?php echo ('send_to'); ?>" id="<?php echo ('send-to'); ?>" style="visibility:hidden; display:none;">
        <option value="<?php echo ('0'); ?>" selected="<?php echo ('selected'); ?>">joel@numinix.com</option>
       </select>
      </div>
     </div>
     <div class="form-group">
      <div class="input-group">
       <label for="contactname">Name</label>
       <input name="<?php echo ('contactname'); ?>" type="<?php echo ('text'); ?>" placeholder="Name" id="<?php echo ('contactname'); ?>" size="<?php echo ('40'); ?>" />
      </div>
      <div class="input-group">
       <label for="email">Email</label>
       <input name="<?php echo ('email'); ?>" type="<?php echo ('email'); ?>" placeholder="Email" id="<?php echo ('email-address'); ?>" size="<?php echo ('40'); ?>" />
      </div>
     </div>
     <div class="form-group">
      <div class="input-group">
       <label for="subject">Subject</label>
       <input name="<?php echo ('subject'); ?>" type="<?php echo ('text'); ?>" placeholder="Subject" id="<?php echo ('subject'); ?>" size="<?php echo ('40'); ?>" />
      </div>
     </div>
     <div class="form-group">
      <div class="input-group">
       <textarea name="<?php echo ('enquiry'); ?>" cols="30" rows="5" id="<?php echo ('enquiry'); ?>" placeholder="Message"></textarea>
      </div>
     </div>
     <div class="form-group">
      <div class="input-group">
       <input name="<?php echo ('should_be_empty'); ?>" type="<?php echo ('text'); ?>" id="<?php echo ('CUAS'); ?>" size="<?php echo ('40'); ?>" style="visibility:hidden; display:none;" autocomplete="off" />
      </div>
     </div>
     <p>This site is protected by reCAPTCHA and the Google Privacy Policy and Terms of Service apply</p>
     <button>Send Mail</button>
    </form>
   </div>
  </div>
  <div class="row faqs-footer">
   <p>
    Please note that the above FAQs are general and may not cover all specific inquiries. For further
    assistance or more detailed information, please reach out to our customer support team.
   </p>
  </div>
 </div>
</section>
<?php
     }
?>