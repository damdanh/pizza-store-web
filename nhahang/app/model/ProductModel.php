<?php
// File: /nhahang/app/model/ProductModel.php

// Hàm getConnection() đã được include trong index.php nên có thể gọi trực tiếp

class ProductModel {
    /**
     * Lấy danh sách N sản phẩm mới nhất (tạm xem là phổ biến) từ bảng mon_an.
     * @param int $limit Số lượng sản phẩm muốn lấy.
     * @return array Danh sách sản phẩm.
     */
    public function getPopularProducts($limit = 5) {
        $pdo = getConnection(); 
        
        // SỬ DỤNG TÊN BẢNG VÀ CỘT CHÍNH XÁC: mon_an, id_mon, ten_mon, gia, hinh_anh
        $sql = "SELECT id_mon, ten_mon, gia, hinh_anh FROM mon_an ORDER BY id_mon ASC LIMIT :limit";
        
        $stmt = $pdo->prepare($sql);
        // Bind giá trị giới hạn
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}