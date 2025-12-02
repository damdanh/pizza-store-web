<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Xác Minh Email</h2>
                    <p>Chúng tôi đã gửi mã xác minh 6 số đến: <b><?= htmlspecialchars($email) ?></b></p>
                    <?php if($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nhập mã OTP</label>
                            <input type="text" name="otp" class="form-control form-control-lg text-center" maxlength="6" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 py-3">Xác Nhận</button>
                    </form>
                    <div class="text-center mt-3">
                        <small>Mã có hiệu lực trong <b>2 phút</b></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>