<?php

class HomeController {

    public function index() {

        $data = [
            'title' => 'Trang Chủ - PIZZA & PASTA',
        ];
        $content_view = __DIR__ . '/../view/home.php'; 
        extract($data); 
        include __DIR__ . '/../view/main.php';
    }
}