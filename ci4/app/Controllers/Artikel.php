<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Exceptions\PageNotFoundException; 

class Artikel extends BaseController
{
    // 1. Menampilkan daftar artikel untuk pengunjung (User)
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->findAll();
        
        return view('artikel/index', compact('artikel', 'title'));
    }

    // 2. Menampilkan isi artikel lengkap berdasarkan SLUG
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

    // 3. Menampilkan tabel manajemen artikel (Admin)
    public function admin_index()  
    { 
        $title = 'Daftar Artikel'; 
        $model = new ArtikelModel();
        $artikel = $model->findAll(); 
        
        return view('artikel/admin_index', compact('artikel', 'title')); 
    } 

    // 4. Fungsi untuk Tambah Artikel Baru
    public function add() 
    { 
        // Validasi: Judul wajib diisi
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

    public function edit($id)  
{ 
    $artikel = new ArtikelModel(); 

    // 1. Validasi data
    $validation = \Config\Services::validation(); 
    $validation->setRules(['judul' => 'required']); 
    $isDataValid = $validation->withRequest($this->request)->run(); 

    // 2. Jika tombol Simpan diklik dan data valid, lakukan update
    if ($isDataValid) 
    { 
        $artikel->update($id, [ 
            'judul' => $this->request->getPost('judul'), 
            'isi'   => $this->request->getPost('isi'), 
            // Opsional: update slug jika judul berubah
            'slug'  => url_title($this->request->getPost('judul'), '-', true),
        ]); 
        return redirect()->to('/admin/artikel'); 
    } 

    // 3. Ambil data lama dari database untuk ditampilkan di form
    $data = $artikel->where('id', $id)->first(); 
    
    if (!$data) {
        throw PageNotFoundException::forPageNotFound();
    }

    $title = "Edit Artikel"; 
    return view('artikel/form_edit', compact('title', 'data')); 
}

    // 5. Fungsi untuk Hapus Artikel
    public function delete($id) 
    { 
        $artikel = new ArtikelModel(); 
        $artikel->delete($id); 
        return redirect()->to('/admin/artikel'); 
    }
}