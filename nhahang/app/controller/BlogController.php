<?php
class BlogController {
    public function index() {
        $data = [
            'title' => 'Liên Hệ - PIZZA & PASTA',
            'base_url_path' => '/WD20302-PRO1014_N5/nhahang/',
        ];
        $content_view = __DIR__ . '/../view/baochi.php';
        extract($data);
        include __DIR__ . '/../view/main.php';
    }
}