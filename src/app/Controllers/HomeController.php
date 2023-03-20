<?php

namespace App\Controllers;

use App\App;
use App\View;
use PDO;

class HomeController
{
    public function index(): View
    {
        $db = App::db();

        $email = 'aaaa@b.com';
        $name = 'aaaJohn Jon';
        $amount = 25;

        try {
            $db->beginTransaction();
            $newUserStmt = $db->prepare(
                'INSERT INTO users (email, full_name, is_active, created_at)
                VALUES (?, ?, 1, NOW())'
            );

            $newInvoiceStmt = $db->prepare(
                'INSERT INTO invoices (amount, user_id)
                VALUES (?, ?)'
            );

            $newUserStmt->execute([$email, $name]);
            $userId = (int)$db->lastInsertId();
            $newInvoiceStmt->execute([$amount, $userId]);

            $db->commit();
        } catch (\Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
        }
        $fetchStmt = $db->prepare(
            'SELECT invoices.id AS invoice_id, amount, user_id, full_name
            FROM invoices
            INNER JOIN users ON user_id = users.id
            WHERE email = ?
            '
        );

        $fetchStmt->execute([$email]);

        echo '<pre>';
        var_dump($fetchStmt->fetch(PDO::FETCH_ASSOC));
        echo '<pre>';

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
        exit;
    }
}
