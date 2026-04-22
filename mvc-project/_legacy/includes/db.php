<?php
$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "mvc_project_db"; // Đổi tên database theo dự án của bạn

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

return $conn;
?>
