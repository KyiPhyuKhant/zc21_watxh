<?php
require('../includes/configure.php');
ini_set('include_path', DIR_FS_CATALOG . PATH_SEPARATOR . ini_get('include_path'));
chdir(DIR_FS_CATALOG);
$current_page_base = 'checkout_process';
$loaderPrefix = 'oprc';
require_once('includes/application_top.php');

header('HTTP/1.1 200 OK');
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

class OprcAjaxCheckoutException extends Exception
{
    protected $redirectUrl;
    protected $messagesHtml;
    protected $payload;

    public function __construct($message = '', $redirectUrl = null, $messagesHtml = null, array $payload = [], $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->redirectUrl = $redirectUrl;
        $this->messagesHtml = $messagesHtml;
        $this->payload = $payload;
    }

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    public function getMessagesHtml()
    {
        return $this->messagesHtml;
    }

    public function getPayload()
    {
        return $this->payload;
    }
}

class OprcAjaxCheckoutShutdownHandler
{
    protected $response;
    protected $finalized = false;

    public function setResponse(?array $response = null)
    {
        $this->response = $response;
    }

    public function finalize()
    {
        if ($this->finalized) {
            return;
        }
        $this->finalized = true;
        $response = $this->response;
        if ($response === null) {
            $response = $this->buildDefaultErrorPayload();
        }
        $this->outputResponse($response);
        require_once(DIR_WS_INCLUDES . 'application_bottom.php');
    }

    public function handleShutdown()
    {
        if ($this->finalized) {
            return;
        }
        $response = $this->response;
        $redirect = $this->detectRedirect();
        if ($redirect !== null) {
            global $messageStack;
            $response = [
                'status' => 'error',
                'messages' => oprc_build_messages_html($messageStack),
                'redirect_url' => $redirect,
            ];
            error_log('OPRC checkout_process redirect intercepted: ' . $redirect);
        } elseif ($response === null) {
            $response = $this->buildDefaultErrorPayload();
        }
        $this->finalized = true;
        $this->outputResponse($response);
        require_once(DIR_WS_INCLUDES . 'application_bottom.php');
    }

    protected function detectRedirect()
    {
        if (!function_exists('headers_list')) {
            return null;
        }
        $redirect = null;
        foreach (headers_list() as $header) {
            if (stripos($header, 'Location:') === 0) {
                $redirect = trim(substr($header, 9));
                if (function_exists('header_remove')) {
                    header_remove('Location');
                }
            }
        }
        return $redirect;
    }

    protected function buildDefaultErrorPayload()
    {
        global $messageStack;
        return [
            'status' => 'error',
            'messages' => oprc_build_messages_html($messageStack, [oprc_constant_or_default('ERROR_DEFAULT', 'An unexpected error occurred. Please try again.')]),
        ];
    }

    protected function outputResponse(array $response)
    {
        if (!isset($response['status'])) {
            $response['status'] = 'error';
        }
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
        }
        echo json_encode($response);
    }
}

function oprc_constant_or_default($name, $default)
{
    return defined($name) ? constant($name) : $default;
}

function oprc_build_messages_html($messageStack, array $additionalMessages = [])
{
    $html = '';
    if (is_object($messageStack) && isset($messageStack->messages) && is_array($messageStack->messages)) {
        foreach ($messageStack->messages as $message) {
            $params = !empty($message['params']) ? $message['params'] : 'class="messageStackError larger"';
            $html .= '<div ' . $params . '>' . $message['text'] . '</div>';
        }
    }
    foreach ($additionalMessages as $text) {
        if (trim($text) === '') {
            continue;
        }
        $html .= '<div class="messageStackError larger">' . htmlspecialchars($text, ENT_COMPAT, defined('CHARSET') ? CHARSET : 'UTF-8') . '</div>';
    }
    return $html;
}

function oprc_checkout_process()
{
    global $messageStack, $credit_covers, $zco_notifier;

    $_SESSION['request'] = 'ajax';

    if (!isset($_SESSION['cart']) || $_SESSION['cart']->count_contents() <= 0) {
        $message = oprc_constant_or_default('ERROR_CART_EMPTY', 'Your shopping cart is empty.');
        throw new OprcAjaxCheckoutException($message, zen_href_link(FILENAME_TIME_OUT), '<div class="messageStackError larger">' . htmlspecialchars($message, ENT_COMPAT, defined('CHARSET') ? CHARSET : 'UTF-8') . '</div>');
    }

    if (empty($_SESSION['customer_id'])) {
        if (isset($_SESSION['navigation'])) {
            $_SESSION['navigation']->set_snapshot(['mode' => 'SSL', 'page' => FILENAME_ONE_PAGE_CHECKOUT]);
        }
        $message = oprc_constant_or_default('ERROR_NOT_LOGGED_IN', 'Please log in to complete your order.');
        throw new OprcAjaxCheckoutException($message, zen_href_link(FILENAME_LOGIN, '', 'SSL'));
    }

    if (function_exists('zen_get_customer_validate_session') && zen_get_customer_validate_session($_SESSION['customer_id']) === false) {
        if (isset($_SESSION['navigation'])) {
            $_SESSION['navigation']->set_snapshot();
        }
        $message = oprc_constant_or_default('ERROR_INVALID_CUSTOMER_SESSION', 'Please log in again to continue.');
        throw new OprcAjaxCheckoutException($message, zen_href_link(FILENAME_LOGIN, '', 'SSL'));
    }

    if (isset($_SESSION['cart']->cartID) && !empty($_SESSION['cartID']) && $_SESSION['cart']->cartID !== $_SESSION['cartID']) {
        $messageStack->add_session('checkout_shipping', oprc_constant_or_default('ERROR_SESSION_SECURITY', 'Please review your order and try again.'), 'error');
        throw new OprcAjaxCheckoutException('', zen_href_link(FILENAME_ONE_PAGE_CHECKOUT, 'request=ajax', 'SSL'));
    }

    if (isset($_POST['payment'])) {
        $_SESSION['payment'] = $_POST['payment'];
    }

    if (isset($_POST['comments'])) {
        $_SESSION['comments'] = zen_output_string_protected($_POST['comments']);
    }

    if (defined('DISPLAY_CONDITIONS_ON_CHECKOUT') && DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {
        if (!isset($_POST['conditions']) || $_POST['conditions'] !== '1') {
            $messageStack->add_session('conditions', oprc_constant_or_default('ERROR_CONDITIONS_NOT_ACCEPTED', 'You must accept the terms and conditions.'), 'error');
            throw new OprcAjaxCheckoutException('', zen_href_link(FILENAME_ONE_PAGE_CHECKOUT, '', 'SSL'));
        }
    }

    require_once(DIR_WS_CLASSES . 'order.php');
    $order = new order();

    require_once(DIR_WS_CLASSES . 'shipping.php');
    $shipping_modules = new shipping();

    $oprc_process_dir_full = DIR_FS_CATALOG . DIR_WS_MODULES . 'one_page_checkout_process/';
    $oprc_process_dir = DIR_WS_MODULES . 'one_page_checkout_process/';
    if (is_dir($oprc_process_dir_full) && $dir = @dir($oprc_process_dir_full)) {
        while (($file = $dir->read()) !== false) {
            if (substr($file, -4) === '.php') {
                include($oprc_process_dir . $file);
            }
        }
        $dir->close();
    }

    if (!isset($_SESSION['shipping']) || !$_SESSION['shipping']) {
        $messageStack->add_session('checkout_shipping', 'Please select a shipping method', 'error');
        throw new OprcAjaxCheckoutException('', zen_href_link(FILENAME_ONE_PAGE_CHECKOUT, 'request=ajax', 'SSL'));
    }

    require_once(DIR_WS_CLASSES . 'order_total.php');
    $order_total_modules = new order_total();
    $order_total_modules->collect_posts();
    $order_total_modules->pre_confirmation_check();

    require_once(DIR_WS_CLASSES . 'payment.php');
    if (!isset($credit_covers)) {
        $credit_covers = false;
    }
    if ($credit_covers || (isset($_SESSION['credit_covers']) && $_SESSION['credit_covers']) || (isset($order->info['total']) && $order->info['total'] == 0)) {
        $credit_covers = true;
        $_SESSION['payment'] = '';
    }

    $paymentSelection = isset($_SESSION['payment']) ? $_SESSION['payment'] : '';
    $payment_modules = new payment($paymentSelection);
    $payment_modules->update_status();

    if ((empty($paymentSelection) || !isset($GLOBALS[$paymentSelection]) || !is_object($GLOBALS[$paymentSelection])) && $credit_covers === false) {
        $messageStack->add_session('checkout_payment', oprc_constant_or_default('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Please select a payment method.'), 'error');
        throw new OprcAjaxCheckoutException('', zen_href_link(FILENAME_ONE_PAGE_CHECKOUT, 'request=ajax', 'SSL'));
    }

    if (is_array($payment_modules->modules)) {
        $payment_modules->pre_confirmation_check();
    }

    if ($messageStack->size('checkout_payment') > 0 || $messageStack->size('redemptions') > 0) {
        throw new OprcAjaxCheckoutException('', zen_href_link(FILENAME_ONE_PAGE_CHECKOUT, 'request=ajax', 'SSL'));
    }

    $payment_modules->before_process();

    require(DIR_WS_MODULES . FILENAME_CHECKOUT_PROCESS . '.php');

    if (!isset($insert_id)) {
        $insert_id = isset($_SESSION['order_number_created']) ? (int)$_SESSION['order_number_created'] : 0;
    }

    $payment_modules->after_process();

    $zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_BEFORE_CART_RESET', $insert_id);
    $_SESSION['cart']->reset(true);

    unset($_SESSION['sendto']);
    unset($_SESSION['billto']);
    unset($_SESSION['shipping']);
    unset($_SESSION['payment']);
    unset($_SESSION['comments']);
    $order_total_modules->clear_posts();

    $zco_notifier->notify('NOTIFY_HEADER_END_CHECKOUT_PROCESS', $insert_id);

    $redirect = zen_href_link(FILENAME_CHECKOUT_SUCCESS, (isset($_GET['action']) && $_GET['action'] == 'confirm' ? 'action=confirm' : ''), 'SSL');

    return [
        'status' => 'success',
        'order_id' => (int)$insert_id,
        'redirect_url' => $redirect,
        'messages' => oprc_build_messages_html($messageStack),
    ];
}

$shutdownHandler = new OprcAjaxCheckoutShutdownHandler();
register_shutdown_function([$shutdownHandler, 'handleShutdown']);

try {
    $response = oprc_checkout_process();
    $shutdownHandler->setResponse($response);
} catch (OprcAjaxCheckoutException $e) {
    $messagesHtml = $e->getMessagesHtml();
    if ($messagesHtml === null) {
        global $messageStack;
        $append = $e->getMessage() ? [$e->getMessage()] : [];
        $messagesHtml = oprc_build_messages_html($messageStack, $append);
    }
    $payload = array_merge([
        'status' => 'error',
        'messages' => $messagesHtml,
    ], $e->getPayload());
    if ($e->getRedirectUrl()) {
        $payload['redirect_url'] = $e->getRedirectUrl();
    }
    $shutdownHandler->setResponse($payload);
} catch (Throwable $throwable) {
    error_log('OPRC checkout_process exception: ' . $throwable->getMessage() . ' in ' . $throwable->getFile() . ':' . $throwable->getLine());
    global $messageStack;
    $messagesHtml = oprc_build_messages_html($messageStack, [$throwable->getMessage()]);
    $shutdownHandler->setResponse([
        'status' => 'error',
        'messages' => $messagesHtml,
    ]);
}

$shutdownHandler->finalize();
