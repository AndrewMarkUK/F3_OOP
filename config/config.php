<?php

if (!empty($f3)) {
    $root = $f3->get('ROOT');
    $dotenv = Dotenv\Dotenv::createImmutable($root);
    $dotenv->load();
    $autoloads = $root . '/app/models/|' . $root . '/app/controllers/|' . $root . '/app/services/|' . $root . '/app/classes/';
    $ui = $root . '/app/views/|' . $root . '/app/views/components/|' . $root . '/app/views/layout/|' . $root . '/app/views/common/';
    $f3->set('AUTOLOAD',$autoloads);
    $f3->set('UI',$ui);
    $f3->set('DEBUG',4);
}
