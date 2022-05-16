<?php

class ProductsModel extends DB\SQL\Mapper
{

    public function __construct(DB\SQL $db)
    {
        parent::__construct($db,'products');
    }

    public function all()
    {
        $this->category_name = 'SELECT c.name FROM categories c WHERE c.id = products.category_id';
        return $this->load();
    }

    public function create($f3)
    {
        $this->copyFrom($f3->get('POST'));
        $this->save();
    }

    public function read($f3,$id)
    {
        if ($f3) {
            $this->load(array('id = ?',$id));
        }
    }

    public function edit($f3,$id)
    {
        if ($f3) {
            $this->load(array('id = ?',$id));
            $this->copyFrom($f3->get('POST'));
            $this->save();
        }
    }

    public function delete($id)
    {
        $this->load(array('id = ?',$id));
        $this->erase();
    }

}