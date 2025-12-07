<?php
// app/controller/BaoChiController.php

class BaoChiController {
    
    public function index() {
        $data = [
            'title' => 'Tư Liệu Truyền Thông - PIZZA & PASTA',
            'base_url_path' => '/WD20302-PRO1014_N5/nhahang/'
        ];
        
        // Chỉ định view content
        $content_view = __DIR__ . '/../view/baochi.php'; 
        
        // Truyền biến ra view
        extract($data);
        
        // Load layout chính (có header + footer)
        include __DIR__ . '/../view/main.php';
    }
}