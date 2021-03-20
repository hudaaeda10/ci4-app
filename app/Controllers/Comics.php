<?php

namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;

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
            'cover' => [
                'rules' => 'max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'max_size' => 'Your file is biggest',
                    'is_image' => 'your file not image',
                    'mime_in' => 'your file not image'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('/comics/create')->withInput()->with('validation', $validation);
            return redirect()->to('/comics/create')->withInput();
        }
        // Cara 1
        // ambil data file
        // $fileCover = $this->request->getFile('cover');
        // // kirim file ke folder public
        // $fileCover->move('img');
        // // kirim nama file ke database
        // $fileName = $fileCover->getName();

        // cara 2
        $fileCover = $this->request->getFile('cover');
        // jika tidak upload file
        if ($fileCover->getError() == 4) {
            $coverName = 'default.png';
        } else {
            // simpan random nama
            $coverName = $fileCover->getRandomName();
            // kirim file ke public
            $fileCover->move('img', $coverName);
        }

        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->comicModel->save([
            'title' => $this->request->getVar('title'),
            'slug' => $slug,
            'author' => $this->request->getVar('author'),
            'publisher' => $this->request->getVar('publisher'),
            'cover' => $coverName
        ]);
        session()->setFlashdata('message', 'New comics has been added!');
        return redirect()->to('/comics');
    }

    public function delete($id)
    {
        // hapus gambar
        $comic = $this->comicModel->find($id);
        // jika file yang dihapus namanya default.png jangan di hapus
        if ($comic['cover'] != 'default.png') {
            // hapus gambar
            unlink('img/' . $comic['cover']);
        }
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
            'cover' => [
                'rules' => 'max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'max_size' => 'Your file is biggest',
                    'is_image' => 'your file not image',
                    'mime_in' => 'your file not image'
                ]
            ]
        ])) {
            return redirect()->to('/comics/edit/' . $this->request->getVar('slug'))->withInput();
        }
        // cari gambar
        $fileCover = $this->request->getFile('cover');
        // cek apakah ada perubahan?
        if ($fileCover->getError() == 4) {
            $coverName = $this->request->getVar('coverLast');
        } else {
            // generate nama random
            $coverName = $fileCover->getRandomName();
            // simpan file
            $fileCover->move('img', $coverName);
            // hapus file lama
            if ($this->request->getVar('coverLast') != 'default.jpg') {
                unlink('img/' . $this->request->getVar('coverLast'));
            }
        }

        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->comicModel->save([
            'id' => $id,
            'title' => $this->request->getVar('title'),
            'slug' => $slug,
            'author' => $this->request->getVar('author'),
            'publisher' => $this->request->getVar('publisher'),
            'cover' => $coverName
        ]);
        session()->setFlashdata('message', 'Comics has been updated!');
        return redirect()->to('/comics');
    }
}
