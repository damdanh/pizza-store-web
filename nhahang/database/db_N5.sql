
CREATE TABLE admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE, 
    mat_khau VARCHAR(255) NOT NULL,    
    vai_tro INT DEFAULT 1,              
    trang_thai_hoat_dong BOOLEAN DEFAULT TRUE, 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE khach_hang (
    id_khach_hang INT AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(255) NOT NULL,
    sdt VARCHAR(20),
    email VARCHAR(255) UNIQUE, 
    mat_khau VARCHAR(255) NOT NULL,
    gioi_tinh VARCHAR(10),
    ngay_sinh DATE,
    dia_chi VARCHAR(500),
    trang_thai_tai_khoan VARCHAR(50) DEFAULT 'Active', 
    phan_hoi TEXT,                      
    tai_khoan_dang_nhap VARCHAR(100) UNIQUE, 
    ma_xac_minh VARCHAR(100),           
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE khu_vuc (
    id_khu_vuc INT AUTO_INCREMENT PRIMARY KEY,
    ten_khu_vuc VARCHAR(255) NOT NULL,
    mo_ta TEXT
);


CREATE TABLE ban (
    id_ban INT AUTO_INCREMENT PRIMARY KEY,
    id_khu_vuc INT,
    ten_ban VARCHAR(100) NOT NULL UNIQUE, 
    so_dong INT,
    so_ghe INT, 
    trang_thai_ban VARCHAR(50) DEFAULT 'Trống', 
    loai_ban VARCHAR(50),
    mo_ta TEXT,
    FOREIGN KEY (id_khu_vuc) REFERENCES khu_vuc(id_khu_vuc) ON DELETE SET NULL
);


CREATE TABLE danh_muc_mon (
    id_danh_muc_mon INT AUTO_INCREMENT PRIMARY KEY,
    ten_danh_muc VARCHAR(255) NOT NULL UNIQUE,
    mo_ta TEXT
);


CREATE TABLE mon_an (
    id_mon INT AUTO_INCREMENT PRIMARY KEY,
    id_danh_muc_mon INT,
    ten_mon VARCHAR(255) NOT NULL,
    gia DECIMAL(10, 2) NOT NULL, 
    mo_ta TEXT,
    hinh_anh VARCHAR(500), 
    trang_thai VARCHAR(50) DEFAULT 'Còn hàng', 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_danh_muc_mon) REFERENCES danh_muc_mon(id_danh_muc_mon) ON DELETE CASCADE
);


CREATE TABLE bai_viet (
    id_bai_viet INT AUTO_INCREMENT PRIMARY KEY,
    id_admin INT,
    tieu_de VARCHAR(255) NOT NULL,
    bai_doc TEXT,
    noi_dung TEXT,
    tom_tat TEXT,
    ngay_dang DATETIME DEFAULT CURRENT_TIMESTAMP,
    trang_thai VARCHAR(50) DEFAULT 'Draft',    
    FOREIGN KEY (id_admin) REFERENCES admin(id_admin) ON DELETE SET NULL
);


CREATE TABLE dat_ban (
    id_dat_ban INT AUTO_INCREMENT PRIMARY KEY,
    id_khach_hang INT,
    id_ban INT NULL, 
    ngay_dat_ban DATETIME NOT NULL,
    trang_thai_dat_ban VARCHAR(50) DEFAULT 'Chờ xác nhận',
    so_luong_nguoi INT NOT NULL,
    ghi_chu TEXT,
    phu_phi DECIMAL(10, 2) DEFAULT 0.00,
    tong_gia DECIMAL(10, 2) DEFAULT 0.00,
    danh_gia_dat_ban INT,

    FOREIGN KEY (id_khach_hang) REFERENCES khach_hang(id_khach_hang) ON DELETE CASCADE,
    FOREIGN KEY (id_ban) REFERENCES ban(id_ban) ON DELETE SET NULL
);


CREATE TABLE chi_tiet_dat_ban (
    id_dat_ban INT NOT NULL,
    id_mon INT NOT NULL,
    so_luong INT NOT NULL,
    don_gia DECIMAL(10, 2) NOT NULL, 
    ghi_chu TEXT,
    PRIMARY KEY (id_dat_ban, id_mon),
    FOREIGN KEY (id_dat_ban) REFERENCES dat_ban(id_dat_ban) ON DELETE CASCADE,
    FOREIGN KEY (id_mon) REFERENCES mon_an(id_mon) ON DELETE RESTRICT
);


CREATE TABLE khuyen_mai (
    id_khuyen_mai INT AUTO_INCREMENT PRIMARY KEY,
    ten_chuong_trinh VARCHAR(255) NOT NULL,
    ten_ctk VARCHAR(100) UNIQUE, 
    chi_tiet_km TEXT,
    ngay_bat_dau DATETIME NOT NULL,
    ngay_ket_thuc DATETIME NOT NULL,
    phan_tram_giam_gia DECIMAL(5, 2), 
    trang_thai_hoat_dong BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE chi_tiet_khuyen_mai (
    id_khuyen_mai INT NOT NULL,
    id_mon INT NOT NULL,
    PRIMARY KEY (id_khuyen_mai, id_mon),
    FOREIGN KEY (id_khuyen_mai) REFERENCES khuyen_mai(id_khuyen_mai) ON DELETE CASCADE,
    FOREIGN KEY (id_mon) REFERENCES mon_an(id_mon) ON DELETE RESTRICT
);

CREATE TABLE tai_khoan_reset (
    id_reset INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE, 
    loai_tai_khoan VARCHAR(50) NOT NULL, 
    ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP,
    het_han DATETIME NOT NULL,
    INDEX idx_token (token)
);