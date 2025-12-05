<?php
include_once __DIR__ . '/../model/ProductModel.php';
include_once __DIR__ . '/../model/CategoryModel.php';

class HomeController {

    public function index() {
        try {
            $productModel = new ProductModel();
            $categoryModel = new CategoryModel();
            
            $popularProducts = $productModel->getPopularProducts(5);
            
      
            $categories = $categoryModel->getAllCategories();

            $data = [
                'title' => 'Trang Chủ - PIZZA & PASTA',
                'popularProducts' => $popularProducts,
                'categories' => $categories,
                'base_url_path' => '/WD20302-PRO1014_N5/nhahang/',
            ];
            
            $content_view = __DIR__ . '/../view/home.php'; 
            extract($data); 
            include __DIR__ . '/../view/main.php';
            
        } catch (Exception $e) {
            
            echo "Lỗi: " . $e->getMessage();
            echo "<br>File: " . $e->getFile();
            echo "<br>Line: " . $e->getLine();
        }
    }
}