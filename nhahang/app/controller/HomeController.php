<?php
include_once __DIR__ . '/../model/ProductModel.php';
class HomeController {

    public function index() {
        $productModel = new ProductModel();
        $popularProducts = $productModel->getPopularProducts(5);

        $data = [
            'title' => 'Trang Chủ - PIZZA & PASTA',
            'popularProducts' => $popularProducts,
            'base_url_path' => '/WD20302-PRO1014_N5/nhahang/',
        ];
        $content_view = __DIR__ . '/../view/home.php'; 
        extract($data); 
        include __DIR__ . '/../view/main.php';
    }
}