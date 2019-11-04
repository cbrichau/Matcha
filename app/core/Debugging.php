<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo '<pre>'; print_r($_POST); echo '</pre>';
echo '<pre>'; print_r($_GET); echo '</pre>';
echo '<pre>'; print_r($_SESSION); echo '</pre>';
