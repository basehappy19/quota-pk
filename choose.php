<?php
session_start();
require './config/db.php';
require './functions/Plan.php';
require './functions/Auth.php';
require './functions/Setting.php';

$settings = getSystemSettings($conn);

if (!isset($_SESSION['studentId'])) {
    header("Location: ./auth.php");
    exit();
}
$student = getStudent($conn, $_SESSION['studentId']);

if (!isset($_SESSION['agree'])) {
    header('location: ./account.php');
}

if (isset($student['plan']) && $student['plan'] !== '') {
    header("Location: ./info.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plan = $_POST['plan'];
    if (PickPlan($conn, $_SESSION['studentId'], $plan)) {
        header('location:./info.php');
        exit();
    }
}


$plans = getPlans($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เลือกแผนการเรียน | โรงเรียนภูเขียว</title>
    <?php require 'helper/source/icon.php'; ?>
    <link rel="stylesheet" href="helper/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <script src="https://kit.fontawesome.com/5134196601.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="helper/style.css">
</head>

<body>
    <?php require('helper/source/header.php'); ?>
    <main>
        <div class="container">
            <div class="card-background text-center mb-3" data-aos="zoom-in" data-aos-duration="500">
                <div class="text-center">
                    <h3>กรุณาเลือกแผนการเรียนภายใน</h3>
                    <h3 class="text-danger" id="countdownDisplay"></h3>
                    <div style="color: #ff5656;" id="aboutTime">
                        <h4><i class="bi bi-heart-fill"></i></h4>
                        <h5 class="fw-bolder">สามารถตัดสินใจได้เพียง 1 ครั้ง</h5>
                    </div>

                    <?php
                    $registrationEndDate = $settings['registration_end_date'];
                    $registrationStartDate = $settings['registration_start_date'];
                    $registrationEnabled = $settings['registration_enabled'];
                    ?>

                    <script>
                        const registrationEndDate = new Date('<?php echo $registrationEndDate; ?>').getTime();
                        const registrationStartDate = new Date('<?php echo $registrationStartDate; ?>').getTime();
                        const registrationEnabled = <?php echo $registrationEnabled; ?>;

                        function startCountdown() {
                            const now = new Date().getTime();
                            const timeLeft = registrationEndDate - now;
                            const timeUntilStart = registrationStartDate - now;

                            if (registrationEnabled === 0 || timeUntilStart > 0) {
                                document.querySelector('h3').style.display = 'none';
                                document.querySelector('#aboutTime').style.display = 'none';
                                document.getElementById('countdownDisplay').innerHTML = "ปิดระบบรับสมัครแล้ว"; 
                            } else if (timeLeft < 0) {
                                // หากหมดเวลาการสมัคร
                                document.querySelector('h3').style.display = 'none';
                                document.querySelector('#aboutTime').style.display = 'none';
                                document.getElementById('countdownDisplay').innerHTML = "ปิดรับสมัครแล้ว";
                            } else {
                                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                                document.getElementById('countdownDisplay').innerHTML = `${days} วัน ${hours} ชั่วโมง ${minutes} นาที ${seconds} วินาที`;
                            }
                        }

                        startCountdown();

                        setInterval(startCountdown, 1000);
                    </script>
                </div>



            </div>
            <?php include './components/profileInfo.php'; ?>
            <hr>
            <form method="post" id="pickPlan" class="card-background" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="1000">
                <h6 class="mb-5"><span>กรุณา<strong>เลือกแผนการเรียน</strong>ที่ต้องการสมัคร</span></h6>
                <div class="row">
                    <?php foreach ($plans as $plan) : ?>
                        <?php

                        $plan;
                        include './components/planCard.php';

                        ?>
                    <?php endforeach; ?>
            </form>
        </div>
    </main>
    <?php require 'helper/source/footer.php' ?>
    <?php require 'helper/source/script.php' ?>
    <script>
        AOS.init();
    </script>

</body>

</html>