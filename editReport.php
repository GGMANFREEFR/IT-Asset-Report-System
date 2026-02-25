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

/* timezone */
date_default_timezone_set('Asia/Bangkok');

/* รับ id */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM reports WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    die("<p style='color:red;text-align:center;'>ไม่พบข้อมูล</p>");
}

$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>แก้ไขข้อมูลแจ้งงาน</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

<h3 style="text-align:center;"> แก้ไขข้อมูลแจ้งงาน</h3>

<div class="form-box">
<form method="post" action="postEditReport.php">

<input type="hidden" name="id" value="<?= $data['id']; ?>">

<!-- =====================
     ข้อมูลผู้แจ้ง
====================== -->
<h4>ข้อมูลผู้แจ้ง</h4>
<hr>

<label>ชื่อผู้แจ้ง</label>
<input type="text" name="name"
       value="<?= htmlspecialchars($data['name']); ?>"
       required>

<!-- =====================
     ข้อมูลทรัพย์สิน
====================== -->
<h4>ข้อมูลทรัพย์สิน (Asset)</h4>
<hr>

<label>ชื่อเครื่อง</label>
<input type="text" name="asset_name"
       value="<?= htmlspecialchars($data['asset_name']); ?>"
       required>

<label>ประเภทอุปกรณ์</label>
<select name="type" required>
  <option value="">-- เลือกประเภท --</option>
  <?php
  $types = ['Desktop','Notebook','Printer','Other'];
  foreach ($types as $t) {
      $selected = ($data['type'] === $t) ? 'selected' : '';
      echo "<option value=\"$t\" $selected>$t</option>";
  }
  ?>
</select>

<label>Serial Number</label>
<input type="text" name="SN"
       value="<?= htmlspecialchars($data['SN']); ?>"
       required>

<label>สถานที่ / ห้อง</label>
<input type="text" name="location"
       value="<?= htmlspecialchars($data['location']); ?>"
       required>

<label>AnyDesk ID</label>
<input type="text"
       name="detail"
       value="<?= htmlspecialchars($data['detail']); ?>">

<!-- =====================
     รายละเอียด
====================== -->
<h4>รายละเอียดการแจ้ง</h4>
<hr>

<label>รายละเอียดงาน</label>
<textarea name="anydesk_id"
          oninput="countChar(this)"
          required><?= htmlspecialchars($data['anydesk_id']); ?></textarea>

<small id="counter">0 ตัวอักษร</small>

<p style="font-size:13px;color:#64748b;">
  แจ้งเมื่อ :
  <?= date('d/m/Y H:i', strtotime($data['created_at'])); ?>
</p>

<div class="form-actions">
  <input type="submit" value=" บันทึกการแก้ไข">
  <input type="reset"
       value="↩ กลับหน้ารายการ"
       class="btn-cancel"
       onclick="confirmBack();">
</div>

</form>
</div>

<script>
function countChar(el) {
  document.getElementById("counter").innerText =
    el.value.length + " ตัวอักษร";
}

document.addEventListener("DOMContentLoaded", function () {
  const textarea = document.querySelector("textarea[name='detail']");
  if (textarea) countChar(textarea);
});
</script>

<script>
function confirmBack() {
  if (confirm("ต้องการยกเลิกการแก้ไข และกลับไปหน้ารายการใช่หรือไม่?")) {
    location.href = "listReport.php";
  }
}
</script>


</body>
</html>
