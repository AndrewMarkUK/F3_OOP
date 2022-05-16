<?php

use DB\SQL;

class AppController
{

    protected $f3;
    protected SQL $db;

    function __construct()
    {
        $f3 = Base::instance();
        $this->f3 = $f3;

        $db = new DB\SQL('mysql:host=localhost;port=3306;dbname='.$_ENV['db'],
            $_ENV['db_user'],
            $_ENV['db_pass'],
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        $this->db = $db;
    }

}