<?php
session_start();
require './config/db.php';
require './functions/Plan.php';
require './functions/Auth.php';

if (!isset($_SESSION['studentId'])) {
    header("Location: ./auth.php");
    exit();
}

$student = getStudent($conn, $_SESSION['studentId']);


if (isset($student['plan']) && $student['plan'] !== '') {
    header("Location: ./info.php");
    exit();
}

if (isset($_SESSION['agree'])) {
    header('location: ./choose.php');
}
    
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $_SESSION['agree'] = true;
    header('location:./choose.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลผู้สมัคร | โรงเรียนภูเขียว</title>
    <?php require 'helper/source/icon.php'; ?>
    <link rel="stylesheet" href="helper/bootstrap/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/5134196601.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="helper/style.css">
</head>

<body>
    <?php include './helper/source/header.php'; ?>
    <main>
        <div class="container">
            <?php include './components/profileInfo.php'; ?>
            <hr>
            <div class="card-background" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="1000">
                <h4>แนวปฏิบัติและข้อควรทราบ</h4>
                <p>ในการสมัครเรียน (รอบโควตา) สำหรับนักเรียนชั้นมัธยมศึกษาปีที่ 3 โรงเรียนภูเขียว มีแนวปฏิบัติและข้อควรทราบ ดังนี้</p>
                <ul>
                    <li>มีแผนการเรียนให้สมัครทั้งสิ้น 3 แผนการเรียน ดังนี้
                        <ol>
                            <li>แผนการเรียนวิทยาศาสตร์ – คณิตศาสตร์</li>
                            <li>แผนการเรียนภาษาอังกฤษ – คณิตศาสตร์</li>
                            <li>แผนการเรียนการจัดการธุรกิจการค้าสมัยใหม่ : MOU CP ALL</li>
                        </ol>
                    </li>
                    <li>นักเรียน<strong><span id="span-danger--account">สามารถสมัครได้เพียง 1 แผนการเรียน</span></strong></li>
                    <li>หากต้องการเปลี่ยนแปลงแผนการเรียนที่สมัครนักเรียนจะต้องส่งแบบฟอร์ม <a href="https://drive.google.com/file/d/17p5Unp99m6RwB53ny6BSSKGPxJb9n6fU/view?usp=sharing" target="_blank">นร.01.1</a> ที่ห้องวิชาการ โรงเรียนภูเขียว</li>
                </ul>
                <form method="post" action="">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="formCheck-1" name="agree" required>
                        <label class="form-check-label" for="formCheck-1">ข้าพเจ้ารับทราบข้อกำหนดและเงื่อนไขการสมัครเรียนรอบโควตาโรงเรียนภูเขียวดังที่ปรากฏด้านบนเรียนร้อยแล้ว</label>
                    </div>
                    <div class="text-center mt-3" id="btn--account">
                        <button class="btn btn-primary animated-button" type="submit"><i class="far fa-edit"></i>&nbsp;สมัครเลย</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php require 'helper/source/footer.php' ?>
    <?php require 'helper/source/script.php' ?>
    <script>
        AOS.init();
    </script>
</body>

</html>