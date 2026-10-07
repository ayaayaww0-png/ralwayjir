<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        // Data hardcode (tidak masuk database)
        $kontaks = [
            [
                'nama' => 'Fathan Arya Buana Leandro',
                'telepon' => '0895-2409-8594'
            ],
            [
                'nama' => 'Bintang Bilawal Adam',
                'telepon' => '0895-1578-1624'
            ],
            [
                'nama' => 'Fatiha Nurul Ahya',
                'telepon' => '0895-1849-4571'
            ],
            [
                'nama' => 'Nabila Kumairah',
                'telepon' => '0831-4951-4979'
            ],
        ];

        return view('kontak.index', compact('kontaks'));
    }
}