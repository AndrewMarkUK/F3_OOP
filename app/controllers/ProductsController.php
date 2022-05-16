<?php

class ProductsController extends AppController
{

    public function all($f3)
    {
        $check_for_categories = new CategoriesModel($this->db);
        $check_for_categories->category_menu();
        $f3->set('count',$check_for_categories->count());

        $f3->set('table','products');
        $data = new ProductsModel($this->db);
        $data = $data->all();

        $render = new RenderView();
        $render->getTable($f3,$data);
    }

    public function getForm($f3,$args)
    {
        $id = $args['id'];
        $action = $args['action'];
        $f3->set('id', $id);
        $f3->set('action',$action);
        $category_menu = new CategoriesModel($this->db);
        $f3->set('categories',$category_menu->category_menu());
        if($id != 0) {
            $record_details= new ProductsModel($this->db);
            $record_details->read($f3,$id);
            $f3->set('record_details',$record_details);
        }
        $template = new Template();
        echo $template->render('products_form.html');
    }

    public function create($f3)
    {
        $validate_input = new ValidateInput();
        $validate_input->product_input();
        $validate_input->run_validation();
        $create_record = new ProductsModel($this->db);
        $create_record->create($f3);
    }

    public function edit($f3,$args)
    {
        if($f3){
            $id = $args['id'];
            $validate_input = new ValidateInput();
            $validate_input->product_input();
            $validate_input->run_validation();
            $update_record = new ProductsModel($this->db);
            $update_record->edit($f3,$id);
        }
    }

    public function delete($f3,$args)
    {
        if($f3) {
            $id = $args['id'];
            $delete_record = new ProductsModel($this->db);
            $delete_record->delete($id);
            echo json_encode(array('result' => true));
        }
    }
}