<?php

class IndexController extends AppController
{
    public function index($f3)
    {
        $f3->set('view','home.html');
        $template = new Template();
        echo $template->render('index.html');
    }
}