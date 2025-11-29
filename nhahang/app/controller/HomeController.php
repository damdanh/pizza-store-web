<?php
include_once __DIR__ . '/../model/ProductModel.php';
include_once __DIR__ . '/../model/CategoryModel.php';

class HomeController {

    public function index() {
        try {
            $productModel = new ProductModel();
            $categoryModel = new CategoryModel();
            
            // Lấy sản phẩm phổ biến
            $popularProducts = $productModel->getPopularProducts(5);
            
            // Lấy danh mục món ăn từ database
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
            // Xử lý lỗi
            echo "Lỗi: " . $e->getMessage();
            echo "<br>File: " . $e->getFile();
            echo "<br>Line: " . $e->getLine();
        }
    }
}