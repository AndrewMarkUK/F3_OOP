<?php

if(!empty($f3)) {
    $f3->route('GET /','IndexController->index');
    $f3->route(array('GET @store_categories: /store/categories', 'GET /store/categories/@page'),'CategoriesController->all');
    $f3->route(array('GET /store/categories/@page [ajax]'),'CategoriesController->all');
    $f3->route(array('GET /store/categories/form/@action/@id [ajax]'),'CategoriesController->getForm');
    $f3->route(array('POST /store/categories/@action/@id [ajax]'),'CategoriesController->@action');
    $f3->route(array('GET @store_products: /store/products', 'GET /store/products/@page'),'ProductsController->all');
    $f3->route(array('GET /store/products/@page [ajax]'),'ProductsController->all');
    $f3->route(array('GET /store/products/form/@action/@id [ajax]'),'ProductsController->getForm');
    $f3->route(array('POST /store/products/@action/@id [ajax]'),'ProductsController->@action');
    $f3->run();
}