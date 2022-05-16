<?php

class CategoriesController extends AppController
{
    public function all($f3)
    {
        $f3->set('table','categories');
        $data = new CategoriesModel($this->db);
        $render = new RenderView();
        $render->getTable($f3,$data);
    }

    public function getForm($f3,$args)
    {
        $id = $args['id'];
        $action = $args['action'];
        $f3->set('id', $id);
        $f3->set('action',$action);
        if($id != 0) {
            $record_details= new CategoriesModel($this->db);
            $record_details->read($f3,$id);
            $f3->set('record_details',$record_details);
        }
        $template = new Template();
        echo $template->render('categories_form.html');
    }

    public function create($f3)
    {
        $validate_input = new ValidateInput();
        $validate_input->category_input();
        $validate_input->run_validation();
        $create_record = new CategoriesModel($this->db);
        $create_record->create($f3);
    }

    public function edit($f3,$args)
    {
        if($f3){
            $id = $args['id'];
            $validate_input = new ValidateInput();
            $validate_input->category_input();
            $validate_input->run_validation();
            $update_record = new CategoriesModel($this->db);
            $update_record->edit($f3,$id);
        }
    }

    public function delete($f3,$args)
    {
        if($f3) {
            $id = $args['id'];
            $delete_record = new CategoriesModel($this->db);
            $delete_record->delete($id);
            echo json_encode(array('result' => true));
        }
    }
}