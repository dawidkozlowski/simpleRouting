<?php

namespace App\Controllers;

use App\View;

class HomeController
{
    public function index(): View
    {
        return View::make('index', ['foo' => 'bar']);
    }

    /**
     * fake headers for download
     * @return void
     */
    public function download()
    {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="myfile.pdf"');

        readfile(STORAGE_PATH . '/receipt.pdf');
    }
    public function upload()
    {
        $filePath = STORAGE_PATH . '/' . $_FILES['receipt']['name'];

        move_uploaded_file($_FILES['receipt']['tmp_name'], $filePath);

        header('Location: /');
    }
}
