<?php
if (!defined('PRODUCTS_QUESTIONS_ANSWERS_ALLOW_QUESTS_ASKING_QUESTIONS')) {
    define('PRODUCTS_QUESTIONS_ANSWERS_ALLOW_QUESTS_ASKING_QUESTIONS', 'false');
}
?>
<script type="text/javascript"><!--//
var ajax_login_check_url = 'ajax/login_check.php<?php if (SESSION_RECREATE != 'True') echo '?' . zen_session_name() . '=' . zen_session_id(); ?>';
var ajax_products_questions_answers_url = 'ajax/products_questions_answers.php<?php if (SESSION_RECREATE != 'True') echo '?' . zen_session_name() . '=' . zen_session_id(); ?>';

var PRODUCTS_QUESTIONS_ANSWERS_ALLOW_QUESTS_ASKING_QUESTIONS = <?php echo PRODUCTS_QUESTIONS_ANSWERS_ALLOW_QUESTS_ASKING_QUESTIONS == 'true' ? 'true' : 'false'; ?>;
//--></script>