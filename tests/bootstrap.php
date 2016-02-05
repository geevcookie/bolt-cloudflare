<?php

include_once __DIR__ . '/../vendor/bolt/bolt/tests/phpunit/bootstrap.php';

define('TEST_WEB_ROOT', TEST_ROOT . '/tests/phpunit/web-root');
@mkdir(TEST_WEB_ROOT . '/app/cache', 0777, true);
@mkdir(TEST_WEB_ROOT . '/app/config', 0777, true);
@mkdir(TEST_WEB_ROOT . '/app/database', 0777, true);

require_once BOLT_AUTOLOAD;
