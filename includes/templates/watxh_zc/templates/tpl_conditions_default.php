<?php

/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=conditions.<br />
 * Displays conditions page.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_conditions_default.php 3464 2006-04-19 00:07:26Z ajeh $
 */
?>

<?php if (DEFINE_CONDITIONS_STATUS >= 1 and DEFINE_CONDITIONS_STATUS <= 2) { ?>

  <?php
  // require the html_define for the conditions page
  // require($define_page);
  ?>
  <section class="terms">
    <div class="container">
      <div class="terms-content">
        <h3>Terms of Use</h3>
        <h4>Effective Date: 01/20/2021</h4>
        <p>
          Please read these Terms of Use ("Terms") carefully before using our website and services. These Terms
          govern your access to and use of the Watxh website ("Website") and any content, features, or services
          provided by Watxh ("We," "Us," or "Our"). By accessing or using our Website, you agree to be bound by
          these Terms. If you do not agree with these Terms, please refrain from using our Website.
        </p>

        <ul>
          <li>
            Use of the Website: Eligibility: You must be at least 18 years old or the age of majority in your
            jurisdiction to use our Website. By accessing and using the Website, you represent and warrant that you
            meet these eligibility requirements. User Account: Certain features of our Website may require you to
            create a user account. You are responsible for maintaining the confidentiality of your account
            information and agree to accept responsibility for all activities that occur under your account.
          </li>

          <li>
            Intellectual Property: Ownership: The Website and its content, including but not limited to text,
            graphics, logos, images, audiovisual materials, and software, are the property of Watxh or its licensors
            and are protected by intellectual property laws. Limited License: We grant you a limited, non-exclusive,
            non-transferable, and revocable license to access and use the Website solely for personal and
            non-commercial purposes. You may not reproduce, modify, distribute, or create derivative works of the
            Website or its content without our prior written consent.
          </li>

          <li>
            Prohibited Conduct: When using our Website, you agree not to: Violate any applicable laws, regulations,
            or third-party rights. Engage in unauthorized access to our systems, interfere with or disrupt the
            Website, or transmit any viruses or malicious code. Use the Website for any fraudulent, deceptive, or
            unlawful purposes. Collect or store personal information of other users without their consent. Engage in
            any activity that could damage the reputation, functionality, or security of the Website or Watxh.
          </li>

          <li>
            Disclaimer of Warranties: The Website and its content are provided on an "as is" and "as available"
            basis without warranties of any kind, whether express or implied. We do not warrant that the Website
            will be error-free, secure, uninterrupted, or free from viruses or other harmful components. We make no
            representations or warranties regarding the accuracy, completeness, reliability, or timeliness of the
            content on our Website.
          </li>

          <li>
            Limitation of Liability: To the maximum extent permitted by applicable law, Watxh and its affiliates,
            directors, officers, employees, agents, or suppliers shall not be liable for any direct, indirect,
            incidental, consequential, or punitive damages arising out of or in connection with your use of the
            Website or any content or services provided through the Website.
          </li>

          <li>
            Third-Party Links: Our Website may contain links to third-party websites or services. We do not endorse
            or assume any responsibility for the content, products, or services provided by these third parties.
            Your access and use of third-party websites or services are subject to their respective terms of use and
            privacy policies.
          </li>

          <li>
            Modifications to the Terms: We reserve the right to modify these Terms at any time. Any changes will be
            effective upon posting on our Website. It is your responsibility to review these Terms periodically for
            any updates.
          </li>

          <li>
            Governing Law and Jurisdiction: These Terms shall be governed by and construed in accordance with the
            laws of [Insert governing law jurisdiction]. Any disputes arising out of or relating to these Terms or
            your use of the Website shall be subject to the exclusive jurisdiction of the courts in [Insert
            jurisdiction].
          </li>

          <li>
            Contact Us: If you have any questions or concerns regarding these Terms, please contact us at [Insert
            contact
          </li>
        </ul>

        <p>
          By accessing and using our Website, you acknowledge that you have read, understood, and agreed to be bound
          by these Terms of Use.
        </p>
      </div>
    </div>
  </section>

<?php } ?>