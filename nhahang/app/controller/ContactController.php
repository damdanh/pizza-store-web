<?php
class ContactController {
    public function index() {
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../model/ContactModel.php';
            $model = new ContactModel();

            $hoTen = $_POST['ho_ten'];
            $sdt = $_POST['sdt'];
            $email = $_POST['email'];
            $noiDung = $_POST['noi_dung'];

            if ($model->insertContact($hoTen, $sdt, $email, $noiDung)) {
                $message = "Gửi liên hệ thành công!";
            } else {
                $message = "Gửi thất bại, vui lòng thử lại!";
            }
        }

        $data = [
            'title' => 'Liên Hệ - PIZZA & PASTA',
            'base_url_path' => '/WD20302-PRO1014_N5/nhahang/',
            'message' => $message
        ];
        
        $content_view = __DIR__ . '/../view/contact.php';
        extract($data);
        include __DIR__ . '/../view/main.php';
    }
}
