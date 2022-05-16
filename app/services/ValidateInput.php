<?php

class ValidateInput
{

    private array $validation;

    public function category_input()
    {
        $this->validation = array(
            array('name' => 'name','validation' => 'is_required|is_for_item_name','text' => 'Category Name'),
        );
    }

    public function product_input()
    {
        $this->validation = array(
            array('name' => 'name','validation' => 'is_required|is_for_item_name','text' => 'Product Name'),
            array('name' => 'quantity','validation' => 'is_required|is_numeric','text' => 'Quantity'),
            array('name' => 'category_id','validation' => 'is_required','text' => 'Category'),
        );
    }

    public function run_validation()
    {
        $form = new AMMValidation($this->validation);
        if (!$form->is_invalid($_POST)) {
            echo json_encode(array('result' => true,'message' => 'Creating Record...'));
        } else {
            echo json_encode(array('result' => false,'message' => $form->get_Errors()));
            exit();
        }
    }

}
