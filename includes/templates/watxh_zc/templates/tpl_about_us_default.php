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
<!-- Header -->
<header class="header">
  <div class="header-about">
    <div class="container">
      <div class="header-about--text">
        <h2>Your neighbourhood store, online.</h2>
        <p>
          Now celebrating more than 17 years in business, we're dedicated to being your #1 store for smartwatches
          and finess band.
        </p>
      </div>
    </div>
    <div class="header-about--image">
      <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-pictures/about-header-image.png' ?>" alt="" />
    </div>
  </div>
</header>
<!-- Header -->

<!-- About Content -->
<section class="about-content">
  <div class="container">
    <p>
      Welcome to Watxh, your premier destination for exquisite timepieces in the heart of New York. With a passion
      for horology and an unwavering commitment to excellence, we bring you a curated collection of watches that
      seamlessly blend style, craftsmanship, and precision. <br /><br />
      At Watxh, we understand that a watch is not just a timekeeping device; it is an expression of one's
      personality and a symbol of taste and refinement. That's why we carefully handpick each timepiece, ensuring
      that every watch we offer represents the perfect fusion of timeless elegance and contemporary design. Our
      collection boasts a diverse range of luxury watches, catering to the distinct preferences of our esteemed
      clientele. Whether you seek the sophistication of Swiss precision, the audacity of avant-garde creations, or
      the classic allure of vintage timepieces, we have something to captivate every horological enthusiast.
      <br /><br />
      We pride ourselves on collaborating with renowned watchmakers and esteemed brands from around the world.
      From iconic Swiss manufacturers to prestigious independent watchmakers, our selection showcases the finest
      examples of horological mastery. Our commitment to quality means that each watch in our inventory has been
      meticulously inspected, ensuring that it meets our stringent standards of craftsmanship and performance.
      <br /><br />
      At Watxh, we believe that exceptional customer service is the cornerstone of a memorable shopping
      experience. Our knowledgeable and passionate team of watch enthusiasts is dedicated to assisting you in
      finding the perfect watch that reflects your unique style and preferences. We understand that acquiring a
      timepiece is a personal journey, and we are here to guide you every step of the way. <br /><br />
      Located in the heart of New York, our flagship boutique offers an inviting and luxurious atmosphere where
      you can immerse yourself in the world of horology. Step into our elegantly appointed showroom, where our
      expert staff will help you explore our collection and provide personalized recommendations tailored to your
      desires. <br /><br />
      In addition to our physical boutique, we also offer a seamless online shopping experience, ensuring that our
      exceptional timepieces are accessible to enthusiasts worldwide. Our user-friendly website showcases our
      collection in exquisite detail, allowing you to browse and select your desired watch from the comfort of
      your own home. <br /><br />
      At Watxh, we believe that a watch is more than just an accessory; it is a legacy to be passed down through
      generations. We are honored to be part of your journey in finding the perfect timepiece, and we look forward
      to providing you with unparalleled service and a lifelong partnership. <br />
      Discover the artistry, precision, and elegance of fine watches at Watxh - where time meets perfection.
    </p>
  </div>
</section>
<!-- About Content End -->

<!-- About Location -->
<section class="about-location">
  <div class="container">
    <div class="row">
      <div class="about-location--map">
        <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-pictures/about-map.png' ?>" alt="" />
      </div>
      <div class="about-location--address">
        <h3>Your neighbourhood store, online.</h3>
        <p>4523 Broadway Ave Manhattan, New York</p>
        <ul>
          <li>Mon - Fri, 8:30am - 10:30pm</li>
          <li>Saturday, 8:30am - 10:30pm</li>
          <li>Sunday, 8:30am - 10:30pm</li>
        </ul>
        <button>Contact Us</button>
      </div>
    </div>
  </div>
</section>
<!-- About Location End -->

<section class="about-form">
  <?php
  if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
  ?>
    <!--  -->
    <p><?php echo TEXT_SUCCESS; ?></p>
  <?php
  } ?>
  <!--  -->
  <div class="container">
    <h4>Get In Touch</h4>
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
</section>

<?php
      }
?>