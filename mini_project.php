<?php
// ===== BAGIAN PEMROSESAN =====
$data = null;
$error = [];
$nama = $nim = $prodi = $email = $semesterInput = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $nim = trim($_POST["nim"] ?? "");
    $prodi = trim($_POST["prodi"] ?? "");
    $semesterInput = $_POST["semester"] ?? "";
    $email = trim($_POST["email"] ?? "");

    if ($nama === "") $error[] = "Nama wajib diisi.";
    if ($nim === "") $error[] = "NIM wajib diisi.";
    if ($prodi === "") $error[] = "Program studi wajib diisi.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Format email tidak valid.";
    }
    if (!ctype_digit((string)$semesterInput) ||
        (int)$semesterInput < 1 || (int)$semesterInput > 14) {
        $error[] = "Semester harus berupa angka 1–14.";
    }

    if (!$error) {
        $data = compact("nama", "nim", "prodi", "email");
        $data["semester"] = (int)$semesterInput;
    }
}

function e($teks) {
    return htmlspecialchars((string)$teks, ENT_QUOTES, "UTF-8");
}
?>
<!-- ===== BAGIAN TAMPILAN ===== -->
<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Formulir Data Mahasiswa</title>
 <style>
  body { font-family: Arial, sans-serif; max-width: 480px; margin: 2rem auto; padding: 0 1rem; }
  label { display: block; margin-top: .8rem; font-weight: bold; }
  input { width: 100%; padding: .5rem; box-sizing: border-box; }
  button { margin-top: 1rem; padding: .5rem 1rem; }
  .error { background: #fde8e8; border: 1px solid #e0a0a0; padding: .5rem 1rem; }
  .sukses { background: #e8f7ea; border: 1px solid #8fc796; padding: .5rem 1rem; }
 </style>
</head>
<body>
 <h1>Formulir Data Mahasiswa</h1>

 <?php if ($error): ?>
  <div class="error">
   <strong>Terdapat kesalahan:</strong>
   <ul>
    <?php foreach ($error as $pesan): ?>
     <li><?= e($pesan) ?></li>
    <?php endforeach; ?>
   </ul>
  </div>
 <?php endif; ?>

 <?php if ($data): ?>
  <div class="sukses">
   <h3>Data berhasil diterima</h3>
   <p>Nama: <?= e($data["nama"]) ?></p>
   <p>NIM: <?= e($data["nim"]) ?></p>
   <p>Program Studi: <?= e($data["prodi"]) ?></p>
   <p>Semester: <?= e($data["semester"]) ?></p>
   <p>Email: <?= e($data["email"]) ?></p>
  </div>
 <?php endif; ?>

 <form method="POST" action="">
  <label for="nama">Nama</label>
  <input id="nama" name="nama" type="text" value="<?= e($nama) ?>" required>

  <label for="nim">NIM</label>
  <input id="nim" name="nim" type="text" value="<?= e($nim) ?>" required>

  <label for="prodi">Program Studi</label>
  <input id="prodi" name="prodi" type="text" value="<?= e($prodi) ?>" required>

  <label for="semester">Semester (1–14)</label>
  <input id="semester" name="semester" type="number" min="1" max="14" step="1" value="<?= e($semesterInput) ?>" required>

  <label for="email">Email</label>
  <input id="email" name="email" type="email" value="<?= e($email) ?>" required>

  <button type="submit">Kirim</button>
  <button type="reset">Reset</button>
</form>
</body>
</html>
