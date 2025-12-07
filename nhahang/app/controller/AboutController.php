<?php
class AboutController {
    public function index() {
        $data = [
            'title' => 'Về Chúng Tôi - PIZZA & PASTA',
            'base_url_path' => '/WD20302-PRO1014_N5/nhahang/'
        ];
        
        $content_view = __DIR__ . '/../view/chungtoi.php'; 
        extract($data);
        include __DIR__ . '/../view/main.php';
    }
}