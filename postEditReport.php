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
$id         = (int)$_POST['id'];
$name       = trim($_POST['name']);
$asset_name = trim($_POST['asset_name']);
$type       = trim($_POST['type']);
$SN         = trim($_POST['SN']);
$detail     = trim($_POST['detail']);          // ✅ detail ก่อน
$anydesk_id = isset($_POST['anydesk_id']) 
    ? trim($_POST['anydesk_id']) 
    : "";
$location   = trim($_POST['location']);

/* ตรวจข้อมูล */
if (
    $id <= 0 ||
    $name === "" ||
    $asset_name === "" ||
    $type === "" ||
    $SN === "" ||
    $location === ""
) {
    die("กรุณากรอกข้อมูลให้ครบ");
}

/* UPDATE (สลับคืนแล้ว) */
$sql = "UPDATE reports SET
          name        = ?,
          asset_name = ?,
          type        = ?,
          SN          = ?,
          detail      = ?,   -- ✅ detail มาก่อน
          anydesk_id  = ?,   -- ✅ anydesk มาทีหลัง
          location    = ?
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("SQL Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "sssssssi",
    $name,
    $asset_name,
    $type,
    $SN,
    $detail,        // ✅ ตรงกับ SQL
    $anydesk_id,    // ✅ ตรงกับ SQL
    $location,
    $id
);

mysqli_stmt_execute($stmt);
header("Location: listReport.php");
exit;
