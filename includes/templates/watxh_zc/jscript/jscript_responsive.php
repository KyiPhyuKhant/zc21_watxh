<?php
if (isset($_SESSION['view']) && $_SESSION['view'] == 'desktop') {
    // No viewport meta tag for desktop view
} else { 
?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<?php 
} 
?>