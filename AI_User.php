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

    public static function authenticate($username, $password) {
        // Ví dụ giả định tài khoản hợp lệ
        if ($username === 'admin' && $password === '123456') {
            return new AI_User('admin', 'Quản trị viên AI');
        }
        return false;
    }

    public function getFullName() {
        return $this->fullName;
    }
}