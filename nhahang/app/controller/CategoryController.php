<?php

include_once __DIR__ . '/../model/ProductModel.php';
include_once __DIR__ . '/../model/CategoryModel.php';


class CategoryController {

    //  @param int
    
    public function show($categoryId) {
        try {
            $productModel = new ProductModel();
            $categoryModel = new CategoryModel();
            
        
            $category = $categoryModel->getCategoryById($categoryId);
            
        
            if (!$category) {
                header("Location: /WD20302-PRO1014_N5/nhahang/public/");
                exit;
            }
            $products = $productModel->getProductsByCategory($categoryId);

            $data = [
                'title' => $category['ten_danh_muc'] . ' - PIZZA & PASTA',
                'category' => $category,
                'products' => $products,
                'base_url_path' => '/WD20302-PRO1014_N5/nhahang/',
            ];
            
           
            $content_view = __DIR__ . '/../view/show.php'; 
            extract($data); 
            include __DIR__ . '/../view/main.php';
            
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            echo "<br>File: " . $e->getFile();
            echo "<br>Line: " . $e->getLine();
        }
    }
}
