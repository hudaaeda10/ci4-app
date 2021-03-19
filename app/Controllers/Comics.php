<?php

namespace App\Controllers;

use App\Models\ComicModel;

class Comics extends BaseController
{
    protected $comicModel;
    public function __construct()
    {
        $this->comicModel = new ComicModel();
    }
    public function index()
    {
        $comic = $this->comicModel->findAll();
        $data = [
            'title' => 'List Comics',
            'comic' => $comic
        ];
        return view('comics/index', $data);
    }
}
