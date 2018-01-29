<?php
  defined('DB_SERVER') ? null : define('DB_SERVER', 'localhost');
  defined('DB_PORT') ? null : define('DB_PORT', '5432');
  defined('DB_NAME') ? null : define('DB_NAME', 'craigv1_peepz');
  defined('DB_USER') ? null : define('DB_USER', 'craigv1_adminpg');
  defined('DB_PASS') ? null : define('DB_PASS', 'P@ssw0rd1');

  defined('SITE_ROOT') ? null : define('SITE_ROOT', $_SERVER["DOCUMENT_ROOT"] . "/");

  defined('TEMPLATE_DIR') ? null : define('TEMPLATE_DIR', SITE_ROOT . 'Templates/');
?>
