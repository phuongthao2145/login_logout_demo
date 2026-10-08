<?php
/**
 * Lớp AI_User đại diện cho một người dùng trong hệ thống AI.
 */
class AI_User {
    private $username;
    private $fullName;

    public function __construct($username = '', $fullName = '') {
        $this->username = $username;
        $this->fullName = $fullName;
    }
    /**
     * Xác thực người dùng dựa trên tên đăng nhập và mật khẩu.
     * @param string $username Tên đăng nhập.
     * @param string $password Mật khẩu (đã được hash).
     * @return AI_User|false Trả về đối tượng AI_User nếu xác thực thành công, ngược lại trả về false.
     */
    public static function authenticate($username, $password) {
        // Ví dụ giả định tài khoản hợp lệ
        if ($username === 'admin' && password_verify('123456',$password)) {
            return new AI_User('admin', 'Quản trị viên AI');
        }
        return false;
    }
    /**
     * Lấy tên đăng nhập của người dùng.
     * @return string Tên đăng nhập.
     */
    public function getFullName() {
        return $this->fullName;
    }
}