<?php
require_once __DIR__ . '/../Model/chinhanhModel.php';

class ChinhanhController {
    private $model;

    public function __construct() {
        $this->model = new ChinhanhModel();
    }

    public function index() {
        $error = null;

        // Support actions via GET: edit (show form prefilled), delete
        $action = $_GET['action'] ?? null;
        if ($action === 'delete' && isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            try {
                $this->model->deleteBranch($id);
                header('Location: admin.php?page=chinhanh&msg=' . urlencode('Đã xóa chi nhánh'));
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $branch_edit = null;
        if ($action === 'edit' && isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $branch_edit = $this->model->getBranchById($id);
            if (!$branch_edit) {
                $error = 'Chi nhánh không tồn tại.';
            }
        }

        // Handle POST for create or update
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_branch'])) {
            $data = [
                'ten_chi_nhanh' => trim($_POST['ten_chi_nhanh'] ?? ''),
                'dia_chi' => trim($_POST['dia_chi'] ?? ''),
                'gio_mo_cua' => trim($_POST['gio_mo_cua'] ?? ''),
                'gio_dong_cua' => trim($_POST['gio_dong_cua'] ?? ''),
                'so_luong_ban' => (int)($_POST['so_luong_ban'] ?? 0),
                'suc_chua' => (int)($_POST['suc_chua'] ?? 0),
                'khung_gio' => trim($_POST['khung_gio'] ?? ''),
                'ban_con_trong' => (int)($_POST['ban_con_trong'] ?? 0),
            ];

            try {
                if (!empty($_POST['branch_id'])) {
                    // Update
                    $id = (int)$_POST['branch_id'];
                    $this->model->updateBranch($id, $data);
                    header('Location: admin.php?page=chinhanh&msg=' . urlencode('Đã cập nhật chi nhánh'));
                    exit;
                } else {
                    // Create
                    $this->model->createBranch($data);
                    header('Location: admin.php?page=chinhanh&msg=' . urlencode('Đã thêm chi nhánh'));
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        // Get list
        $branches = $this->model->getAllBranches();

        // Include view (view will use $branches, $branch_edit and may show $error)
        include __DIR__ . '/../view/admin/chinhanh.php';
    }
}

?>
