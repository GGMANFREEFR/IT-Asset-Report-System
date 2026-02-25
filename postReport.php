<?php
$host = "localhost";
$user = "root";
$pass = "12345678";
$dbname = "report_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลไม่ได้");
}
mysqli_set_charset($conn, "utf8");

/* รับค่าจากฟอร์ม */
$name        = trim($_POST['name']);
$asset_name  = trim($_POST['asset_name']);
$type        = trim($_POST['type']);
$SN          = trim($_POST['SN']);
$location    = trim($_POST['location']);
$detail      = trim($_POST['detail']);

$anydesk_id = isset($_POST['anydesk_id'])
    ? trim($_POST['anydesk_id'])
    : '';

/* ตรวจข้อมูลจำเป็น */
if ($name === "" || $asset_name === "" || $type === "" || $SN === "" || $location === "") {
    die("กรุณากรอกข้อมูลให้ครบ");
}

/* SQL (สลับตำแหน่งให้ตรงกัน) */
$sql = "INSERT INTO reports
(name, asset_name, type, SN, location, detail, anydesk_id )
VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("SQL Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "sssssss",
    $name,
    $asset_name,
    $type,
    $SN,
    $location,
    $detail,
    $anydesk_id
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: listReport.php");
    exit;
} else {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
