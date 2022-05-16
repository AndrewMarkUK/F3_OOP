<?php

class RenderView
{
    public function getTable($f3,$data)
    {
        Template::instance()->extend('pageBrowser','Pagination::renderTag');
        $page = Pagination::findCurrentPage();
        $limit = 10;
        $filter = array();
        $option = array();
        $subset = $data->paginate($page - 1,$limit,$filter,$option);
        $f3->set('data',$subset);

        $pagination_tpl = new Pagination($subset['total'],$subset['limit']);
        $pagination_tpl->setTemplate('pagination_tpl.html');
        $f3->set('pagination_tpl',$pagination_tpl->serve());

        $f3->set('view','table.html');
        $f3->set('table_html',$f3->get('table') . '.html');

        $template = new Template();
        echo $template->render('index.html');
    }
}
