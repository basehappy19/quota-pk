<?php
session_start();

require './config/db.php';
require './functions/Auth.php';

if (isset($_SESSION['studentId'])) {
    header("Location: account.php");
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $studentId = isset($_POST['studentId']) ? $_POST['studentId'] : null;
    $cid = isset($_POST['cid']) ? $_POST['cid'] : null;

    if($student = Auth($conn, $studentId, $cid)){
        $_SESSION['studentId'] = $student['id'];
        header("Location: ./account.php");
        exit();
    }
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ | โรงเรียนภูเขียว</title>
    <?php require 'helper/source/icon.php'; ?>
    <?php require 'helper/source/link.php'; ?>
</head>

<body>
    <?php require 'helper/source/header.php' ?>
    <main class="my-3">
        <?php
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
        ?>
        <div class="d-flex align-items-center" id="main--regis">
            <div class="container" id="con--regis" data-aos="zoom-in" data-aos-delay="150" data-aos-duration="1000">
                <div class="text-center">
                    <img id="pk-logo--regis" src="helper/media/pklogo.png" data-aos="zoom-in">
                </div>
                <h3 class="text-center" id="h3--regis">เข้าสู่ระบบ</h3>
                <form method="post" action="" class="form-login" id="form-login--regis">
                    <div id="s-id.regis">
                        <fieldset>
                            <legend class="fs-5 my-2">เลขประจำตัวนักเรียน</legend>
                            <input class="form-control" id="s-id-input--regis" type="text" name="studentId" placeholder="ระบุรหัสนักเรียน" required>
                        </fieldset>
                        <fieldset>
                            <legend class="fs-5 my-2">เลขประจำตัวประชาชน</legend>
                            <input class="form-control" id="s-p-input--regis" type="text" name="cid" placeholder="เลขประจำตัวประชาชน" required>
                        </fieldset>
                    </div>
                    <div class="text-end d-flex justify-content-end my-3">
                        <button id="btn-login--regis" class="btn btn-success animated-button" type="submit"><i class="far fa-check-circle"></i>&nbsp;ตกลง</button>
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