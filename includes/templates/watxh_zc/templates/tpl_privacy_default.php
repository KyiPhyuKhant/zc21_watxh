<?php

/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_privacy_default.php 3464 2006-04-19 00:07:26Z ajeh $
 */
?>

<?php if (DEFINE_PRIVACY_STATUS >= 1 and DEFINE_PRIVACY_STATUS <= 2) { ?>
  <?php
  //require the html_define for the privacy page

  // require($define_page);
  ?>
  <section class="terms">
    <div class="container">
      <div class="terms-content">
        <h3>Privacy Policy</h3>
        <h4>Effective Date: 01/20/2021</h4>
        <p>
          At Watxh, we prioritize the privacy and security of our customers' personal information. This Privacy
          Policy outlines how we collect, use, disclose, and protect the information you provide when using our
          website or interacting with our services. By accessing our website or providing us with your personal
          information, you consent to the practices described in this policy.
        </p>

        <ul>
          <li>
            Information We Collect:
            <ol>
              <li>
                <strong>Personal Information:</strong> When you make a purchase, create an account, or subscribe to
                our newsletter, we may collect personal information such as your name, email address, billing and
                shipping address, phone number, and payment details.
              </li>
              <li>
                <strong>Website Usage Information:</strong> We may collect non-personal information, including your
                IP address, browser type, operating system, referring website, and pages visited, to improve our
                website's performance and enhance your browsing experience.
              </li>
            </ol>
          </li>

          <li>
            Use of Information:
            <ol>
              <li>
                <strong>Personalization:</strong> We may use your information to personalize your shopping
                experience, provide product recommendations, and offer tailored promotions or discounts.
              </li>
              <li>
                <strong>Order Processing:</strong> We use your information to process and fulfill your orders,
                including shipping, invoicing, and communicating order updates.
              </li>
              <li>
                <strong>Customer Support:</strong> Your information helps us respond to your inquiries, provide
                technical support, and address any concerns you may have.
              </li>
              <li>
                <strong>Marketing Communication:</strong> With your consent, we may send you promotional emails,
                newsletters, or special offers. You can unsubscribe from these communications at any time.
              </li>
            </ol>
          </li>

          <li>
            Data Security: We implement industry-standard security measures to protect your personal information
            from unauthorized access, misuse, alteration, or loss. However, no data transmission over the internet
            or electronic storage method is completely secure, and we cannot guarantee absolute security.
          </li>
          <li>
            Cookies and Tracking Technologies: We use cookies and similar tracking technologies to enhance your
            browsing experience, analyze website traffic, and personalize content. You can manage your cookie
            preferences through your browser settings.
          </li>
          <li>
            Third-Party Links: Our website may contain links to third-party websites or services. We are not
            responsible for the privacy practices or content of these websites. We encourage you to review their
            privacy policies before providing any personal information.
          </li>
          <li>
            Children's Privacy: Our services are not intended for individuals under the age of 13. We do not
            knowingly collect or solicit personal information from children. If we discover that we have collected
            personal information from a child, we will promptly delete it. Changes to the Privacy Policy: We reserve
            the right to update this Privacy Policy periodically. Any changes will be posted on our website with the
            updated effective date. We recommend reviewing this policy periodically for any updates.
          </li>
          <li>
            Contact Us: If you have any questions, concerns, or requests regarding our Privacy Policy or the
            handling of your personal information, please contact us at [insert contact information].
          </li>
        </ul>

        <p>
          By using our website and services, you acknowledge that you have read and understood this Privacy Policy
          and agree to the collection, use, and disclosure of your personal information as described herein.
        </p>
      </div>
    </div>
  </section>

<?php } ?>