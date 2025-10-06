<?php
require('../includes/configure.php');
ini_set('include_path', DIR_FS_CATALOG . PATH_SEPARATOR . ini_get('include_path'));
chdir(DIR_FS_CATALOG);
$current_page_base = 'one_page_checkout';
$loaderPrefix = 'oprc';
require_once('includes/application_top.php');

header('HTTP/1.1 200 OK');
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

$response = [
    'status' => 'error',
];

if (!isset($_SESSION['customer_id']) || !$_SESSION['customer_id']) {
    $response['redirect_url'] = zen_href_link(FILENAME_LOGIN, '', 'SSL');
    echo json_encode($response);
    require_once('includes/application_bottom.php');
    return;
}

if (!isset($_SESSION['cart']) || $_SESSION['cart']->count_contents() <= 0) {
    $response['redirect_url'] = zen_href_link(FILENAME_SHOPPING_CART);
    echo json_encode($response);
    require_once('includes/application_bottom.php');
    return;
}

if (function_exists('zen_get_customer_validate_session') && zen_get_customer_validate_session($_SESSION['customer_id']) === false) {
    $response['redirect_url'] = zen_href_link(FILENAME_LOGIN, '', 'SSL');
    echo json_encode($response);
    require_once('includes/application_bottom.php');
    return;
}

$addressType = $_POST['addressType'] ?? 'billto';
if (!in_array($addressType, ['billto', 'shipto', 'both'], true)) {
    $addressType = 'billto';
}

if (!isset($_POST['oprc_change_address']) || $_POST['oprc_change_address'] === '') {
    $_POST['oprc_change_address'] = 'submit';
}

if (!isset($_POST['action']) || $_POST['action'] === '') {
    $_POST['action'] = 'submit';
}

$_POST['addressType'] = $addressType;

require(DIR_WS_MODULES . zen_get_module_directory('checkout_new_address.php'));

$payload = oprc_build_change_address_payload();

$response = array_merge(
    [
        'status' => $payload['hasErrors'] ? 'warning' : 'success',
        'messagesHtml' => $payload['messagesHtml'],
    ],
    array_diff_key($payload, ['hasErrors' => true, 'messagesHtml' => true])
);

echo json_encode($response);

require_once('includes/application_bottom.php');

function oprc_build_change_address_payload()
{
    global $template, $current_page_base, $messageStack;
    global $order, $order_total_modules, $payment_modules, $shipping_modules, $credit_covers;

    require_once(DIR_WS_CLASSES . 'order.php');
    $order = new order();

    require_once(DIR_WS_CLASSES . 'payment.php');
    $payment_modules = new payment();

    require_once(DIR_WS_CLASSES . 'shipping.php');
    $shipping_modules = new shipping();

    require_once(DIR_WS_CLASSES . 'order_total.php');
    $order_total_modules = new order_total();
    $order_total_modules->collect_posts();
    $order_total_modules->pre_confirmation_check();
    $order_totals = $order_total_modules->process();

    $credit_covers = (isset($_SESSION['credit_covers']) && $_SESSION['credit_covers'] == true);
    if ($credit_covers) {
        unset($_SESSION['payment']);
    }

    $originalPageBase = $current_page_base;
    $current_page_base = 'one_page_checkout';

    $step3Html = oprc_capture_template_output('tpl_modules_oprc_step_3.php');
    $orderTotalHtml = oprc_capture_template_output('tpl_modules_oprc_ordertotal.php');

    $current_page_base = $originalPageBase;

    return [
        'oprcAddresses' => oprc_extract_inner_html($step3Html, 'oprcAddresses'),
        'shippingMethodContainer' => oprc_extract_inner_html($step3Html, 'shippingMethodContainer'),
        'paymentMethodContainer' => oprc_extract_inner_html($step3Html, 'paymentMethodContainer'),
        'shopBagWrapper' => oprc_extract_inner_html($orderTotalHtml, 'shopBagWrapper'),
        'oprcAddressMissing' => oprc_is_address_missing() ? 'true' : 'false',
        'hasErrors' => ($messageStack->size('checkout_address') > 0),
        'messagesHtml' => $messageStack->output('checkout_address'),
    ];
}

function oprc_capture_template_output($templateFile)
{
    global $template;
    $templatePath = $template->get_template_dir($templateFile, DIR_WS_TEMPLATE, 'one_page_checkout', 'templates/one_page_checkout') . '/' . $templateFile;
    ob_start();
    require($templatePath);
    return ob_get_clean();
}

function oprc_extract_inner_html($html, $elementId)
{
    if (trim($html) === '') {
        return '';
    }

    $document = new DOMDocument('1.0', 'UTF-8');
    $useErrors = libxml_use_internal_errors(true);
    $document->loadHTML('<?xml encoding="UTF-8"?><div>' . $html . '</div>');
    libxml_clear_errors();
    libxml_use_internal_errors($useErrors);
    $xpath = new DOMXPath($document);
    $nodes = $xpath->query("//*[@id='" . $elementId . "']");
    if ($nodes->length === 0) {
        return '';
    }

    $innerHtml = '';
    foreach ($nodes->item(0)->childNodes as $child) {
        $innerHtml .= $document->saveHTML($child);
    }

    return trim($innerHtml);
}

function oprc_is_address_missing()
{
    if (!isset($_SESSION['customer_id']) || !$_SESSION['customer_id']) {
        return true;
    }

    if (!isset($_SESSION['customer_default_address_id']) || !$_SESSION['customer_default_address_id']) {
        return true;
    }

    if (function_exists('user_owns_address') && !user_owns_address($_SESSION['customer_default_address_id'])) {
        return true;
    }

    return false;
}
