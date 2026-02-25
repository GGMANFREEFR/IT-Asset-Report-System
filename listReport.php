<?php
date_default_timezone_set('Asia/Bangkok');


$host = "localhost";
$user = "root";
$pass = "12345678";
$dbname = "report_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("ไม่สามารถเชื่อมต่อฐานข้อมูลได้");
}
mysqli_set_charset($conn, "utf8");

$sql = "SELECT * FROM reports ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>รายการแจ้ง Asset</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h2 style="text-align:center;"> รายการแจ้ง Asset คอมพิวเตอร์</h2>

<div style="text-align:center; margin-bottom:15px;">
  <a href="addReport.html" class="add-btn">➕ แจ้ง Asset ใหม่</a>
</div>

<table>
  <thead>
    <tr>
      <th>รหัส</th>
      <th>ผู้แจ้ง</th>
      <th>ชื่อเครื่อง</th>
      <th>ประเภท</th>
      <th>Serial Number</th>
      <th>สถานที่</th>
      <th>รายละเอียด</th>
      <th>AnyDesk ID</th>
      <th>วันที่แจ้ง</th>
      <th>แก้ไข</th>
      <th>ลบ</th>
    </tr>
  </thead>

  <tbody>
  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td><?= $row['id']; ?></td>
      <td><?= htmlspecialchars($row['name']); ?></td>
      <td><?= htmlspecialchars($row['asset_name']); ?></td>
      <td><?= htmlspecialchars($row['type']); ?></td>
      <td><?= htmlspecialchars($row['SN']); ?></td>
      <td><?= htmlspecialchars($row['location']); ?></td>      
      <td style="max-width:260px;">
        <?= nl2br(htmlspecialchars($row['detail'])); ?>
      </td>
      <td><?= htmlspecialchars($row['anydesk_id'] ?: '-'); ?></td>
      <td>
      <?= date('d/m/Y H:i', strtotime($row['created_at'])); ?>
      </td>
      <td>
        <a class="action-edit"
           href="editReport.php?id=<?= $row['id']; ?>">
           แก้ไข
        </a>
      </td>
      <td>
        <a class="action-delete"
           href="delReport.php?id=<?= $row['id']; ?>"
           onclick="return confirm('ต้องการลบข้อมูลนี้หรือไม่ ?');">
           ลบ
        </a>
      </td>
    </tr>
  <?php } ?>
  </tbody>
</table>

<?php mysqli_close($conn); ?>

</body>
</html>
