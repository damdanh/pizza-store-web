<?php
class AboutController {
    public function index() {
        $data = [
            'title' => 'Về Chúng Tôi - PIZZA & PASTA',
            'base_url_path' => '/WD20302-PRO1014_N5/nhahang/'
        ];
        extract($data);
        include __DIR__ . '/../view/main.php'; // main.php chứa nội dung trang "Chúng tôi"
    }
}