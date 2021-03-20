<?php

namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;

use App\Models\HumanModel;

class Human extends BaseController
{
    protected $humanModel;
    public function __construct()
    {
        $this->humanModel = new HumanModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_human') ? $this->request->getVar('page_human') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $human = $this->humanModel->search($keyword);
        } else {
            $human = $this->humanModel;
        }

        $data = [
            'title' => 'List Humans',
            // 'human' => $this->humanModel->getHuman()
            'human' => $human->paginate(6, 'human'),
            'pager' => $this->humanModel->pager,
            'currentPage' => $currentPage
        ];
        return view('human/index', $data);
    }

    public function detail($id)
    {
        $data = [
            'title' => 'Detail Human',
            'human' => $this->humanModel->getHuman($id)
        ];
        if (empty($data['human'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Human Name ' . $id . 'Not Found');
        }
        return view('human/detail', $data);
    }
}
