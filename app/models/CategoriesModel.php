<?php

class CategoriesModel extends DB\SQL\Mapper
{
    public function __construct(DB\SQL $db)
    {
        parent::__construct($db,'categories');
    }

    public function all(): array
    {
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

    /* RAW SQL EXAMPE */
    public function category_menu()
    {
        return $this->db->exec('SELECT id, name FROM categories');

    }
}
