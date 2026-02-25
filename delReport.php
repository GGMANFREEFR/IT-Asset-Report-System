<?php
// เชื่อมต่อฐานข้อมูล
$host = "localhost";
$user = "root";
$pass = "12345678";
$dbname = "report_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("ไม่สามารถเชื่อมต่อฐานข้อมูล MySQL ได้");
}

// ตั้งค่า UTF-8
mysqli_set_charset($conn, "utf8");

// รับ id จาก URL
$id = $_GET['id'];

// คำสั่ง DELETE
$sql = "DELETE FROM reports WHERE id='$id'";

// ประมวลผล
if (mysqli_query($conn, $sql)) {
    header("Location: listReport.php"); // กลับหน้ารายการแจ้งงาน
} else {
    echo "ไม่สามารถลบข้อมูลได้";
}

// ปิดการเชื่อมต่อ
mysqli_close($conn);
?>
