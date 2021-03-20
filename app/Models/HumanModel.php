<?php

namespace App\Models;

use CodeIgniter\Model;

class HumanModel extends Model
{
    protected $table = 'human';
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'address'];

    public function getHuman($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }

    public function search($keyword)
    {
        return $this->table('human')->like('name', $keyword)->orLike('address', $keyword);
    }
}
