<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    // Menampilkan daftar artikel untuk pengunjung (User)
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        // Pagination juga bisa diterapkan di sini jika artikel sudah banyak
        $artikel = $model->paginate(10); 
        
        return view('artikel/index', [
            'artikel' => $artikel,
            'title'   => $title,
            'pager'   => $model->pager
        ]);
    }

    // Menampilkan isi artikel lengkap berdasarkan SLUG
    public function view($slug) 
    { 
        $model = new ArtikelModel(); 
        $artikel = $model->where(['slug' => $slug])->first(); 
 
        if (!$artikel) { 
            throw PageNotFoundException::forPageNotFound(); 
        } 
 
        $title = $artikel['judul']; 
        return view('artikel/detail', compact('artikel', 'title')); 
    }

    public function admin_index()  
    { 
        $title = 'Daftar Artikel'; 
        $model = new ArtikelModel();

        // Mengambil query pencarian dari input 'q' [cite: 77, 82]
        $q = $this->request->getVar('q') ?? ''; 

        $data = [
            'title'   => $title,
            'q'       => $q,
            // Mencari judul yang mirip dengan $q dan membagi 10 data per halaman [cite: 22, 84]
            'artikel' => $model->like('judul', $q)->paginate(10), 
            'pager'   => $model->pager // Mengambil library navigasi halaman [cite: 25, 86]
        ];
        
        return view('artikel/admin_index', $data); 
    } 

    // Fungsi untuk Tambah Artikel Baru
    public function add() 
    { 
        $validation = \Config\Services::validation(); 
        $validation->setRules(['judul' => 'required']); 
        $isDataValid = $validation->withRequest($this->request)->run(); 

        if ($isDataValid) 
        { 
            $model = new ArtikelModel(); 
            $model->insert([ 
                'judul' => $this->request->getPost('judul'), 
                'isi'   => $this->request->getPost('isi'), 
                'slug'  => url_title($this->request->getPost('judul'), '-', true),
            ]); 
            return redirect()->to('/admin/artikel'); 
        } 

        $title = "Tambah Artikel"; 
        return view('artikel/form_add', compact('title')); 
    } 

    // Fungsi untuk Edit Artikel
    public function edit($id)  
    { 
        $artikel = new ArtikelModel(); 
        $validation = \Config\Services::validation(); 
        $validation->setRules(['judul' => 'required']); 
        $isDataValid = $validation->withRequest($this->request)->run(); 

        if ($isDataValid) 
        { 
            $artikel->update($id, [ 
                'judul' => $this->request->getPost('judul'), 
                'isi'   => $this->request->getPost('isi'), 
                'slug'  => url_title($this->request->getPost('judul'), '-', true),
            ]); 
            return redirect()->to('/admin/artikel'); 
        } 

        $data = $artikel->where('id', $id)->first(); 
        if (!$data) throw PageNotFoundException::forPageNotFound();

        $title = "Edit Artikel"; 
        return view('artikel/form_edit', compact('title', 'data')); 
    }

    // Fungsi untuk Hapus Artikel
    public function delete($id) 
    { 
        $artikel = new ArtikelModel(); 
        $artikel->delete($id); 
        return redirect()->to('/admin/artikel'); 
    }
}
