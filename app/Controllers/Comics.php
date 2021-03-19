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
        // $comic = $this->comicModel->findAll();
        $data = [
            'title' => 'List Comics',
            'comic' => $this->comicModel->getComic()
        ];
        return view('comics/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Comic',
            'comic' => $this->comicModel->getComic($slug)
        ];
        if (empty($data['comic'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Comic Title ' . $slug . 'Not Found');
        }
        return view('comics/detail', $data);
    }

    public function create()
    {
        // session();
        $data = [
            'title' => 'Create New Comic',
            'validation' => \Config\Services::validation()
        ];
        return view('comics/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            // 'title' => 'required|is_unique[comics.title]'            contoh yang sederhana
            'title' => [
                'rules' => 'required|is_unique[comics.title]',
                'errors' => [
                    'required' => '{field} Comic Must Be Fill In',
                    'is_unique' => '{field} Comic Must Be Unique'
                ]
            ],
            'author' => 'required',
            'publisher' => 'required',
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/comics/create')->withInput()->with('validation', $validation);
        }
        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->comicModel->save([
            'title' => $this->request->getVar('title'),
            'slug' => $slug,
            'author' => $this->request->getVar('author'),
            'publisher' => $this->request->getVar('publisher'),
            'cover' => $this->request->getVar('cover')
        ]);
        session()->setFlashdata('message', 'New comics has been added!');
        return redirect()->to('/comics');
    }

    public function delete($id)
    {
        $this->comicModel->delete($id);
        session()->setFlashdata('message', 'Comics has been deleted!');
        return redirect()->to('/comics');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Edit Comic',
            'validation' => \Config\Services::validation(),
            'comic' => $this->comicModel->getComic($slug)
        ];
        return view('comics/edit', $data);
    }

    public function update($id)
    {
        // cek title
        $komikLama = $this->comicModel->getComic($this->request->getVar('slug'));
        if ($komikLama['title'] == $this->request->getVar('title')) {
            $rule_title = 'required';
        } else {
            $rule_title = 'required|is_unique[comics.title]';
        }

        if (!$this->validate([
            'title' => [
                'rules' => $rule_title,
                'errors' => [
                    'required' => '{field} Comic Must Be Fill In',
                    'is_unique' => '{field} Comic Must Be Unique'
                ]
            ],
            'author' => 'required',
            'publisher' => 'required',
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/comics/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }
        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->comicModel->save([
            'id' => $id,
            'title' => $this->request->getVar('title'),
            'slug' => $slug,
            'author' => $this->request->getVar('author'),
            'publisher' => $this->request->getVar('publisher'),
            'cover' => $this->request->getVar('cover')
        ]);
        session()->setFlashdata('message', 'Comics has been updated!');
        return redirect()->to('/comics');
    }
}
