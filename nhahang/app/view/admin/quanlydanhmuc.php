<?php
// Biến $dsdm (danh sách danh mục) đã được AdminController truyền vào
$categories_list = $dsdm ?? [];
$category_count = count($categories_list);

include 'views/layouts/header.php';
include 'views/layouts/sidebar.php';
?>

<main class="main-content">
    <header class="page-header">
        <div class="page-title-group">
            <h1>Quản lý Nhóm Món (Danh Mục)</h1>
            <p>Tổng cộng **<?php echo $category_count; ?>** nhóm món</p>
        </div>
        
        <div class="action-buttons">
            <a href="admin.php?page=menu" class="action-btn">
                <span class="material-icons-outlined">restaurant_menu</span>
                Quay lại Menu Món
            </a>
            <a href="admin.php?page=menu&action=add_category" class="action-btn">
                <span class="material-icons-outlined">add_box</span>
                Thêm Nhóm Mới
            </a>
        </div>
    </header>

    <section class="category-list-section card">
        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 25%;">Tên Nhóm Món</th>
                        <th style="width: 45%;">Mô tả</th>
                        <th class="action-cell" style="width: 25%;">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories_list)): ?>
                        <?php foreach ($categories_list as $category): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category['id_danh_muc_mon']); ?></td>
                            <td><strong><?php echo htmlspecialchars($category['ten_danh_muc']); ?></strong></td>
                            <td><?php echo htmlspecialchars($category['mo_ta'] ?? 'Không có mô tả.'); ?></td>
                            <td class="action-cell">
                                <a href="admin.php?page=menu&action=edit_category&id=<?php echo $category['id_danh_muc_mon']; ?>" class="action-icon" title="Sửa">
                                    <span class="material-icons-outlined">edit</span>
                                </a>
                                <a href="admin.php?page=menu&action=delete_category&id=<?php echo $category['id_danh_muc_mon']; ?>" 
                                   class="action-icon" 
                                   title="Xóa"
                                   onclick="return confirm('CẢNH BÁO: Xóa nhóm món có thể làm mất liên kết món ăn. Bạn có chắc chắn xóa nhóm: <?php echo htmlspecialchars($category['ten_danh_muc']); ?>?');" 
                                   style="color: #dc3545;">
                                    <span class="material-icons-outlined">delete</span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-sub); padding: 20px;">
                                <span class="material-icons-outlined" style="font-size: 20px; display: block; margin-bottom: 5px;">info</span>
                                Hiện tại không có nhóm món nào. Vui lòng thêm nhóm mới.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>