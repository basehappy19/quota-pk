<?php
require './config/db.php';
require './functions/Plan.php';

$planCounts = getPlanStatistics($conn);

function hexToRgba($hex, $alpha = 0.2) {
    $hex = ltrim($hex, '#');

    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    return "rgba($r, $g, $b, $alpha)";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สถิติการสมัครเรียน | โรงเรียนภูเขียว</title>
    <?php require 'helper/source/icon.php'; ?>
    <link rel="stylesheet" href="helper/bootstrap/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/5134196601.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="helper/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body style="font-family: Prompt, sans-serif;">
    <?php require 'helper/source/header.php' ?>
    <main>
        <div class="container">
            <?php foreach ($planCounts as $plan) : ?>
                <p style="background-color: <?php echo hexToRgba($plan['plan_color'], 0.2); ?>;" class="card-background">จำนวนคนสมัครแผนการเรียน <?php echo $plan['plan_name'] ?> : <?php echo $plan['num_students'] ?> คน</p>
            <?php endforeach; ?>
            <div class="card-background">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </main>

    <?php require 'helper/source/footer.php' ?>
    <?php require 'helper/source/script.php' ?>
    <script>
        AOS.init();
        let planData = <?php echo json_encode($planCounts); ?>;

        let labels = planData.map(plan => plan.plan_name);
        let values = planData.map(plan => plan.num_students);
        let colors = planData.map(plan => plan.plan_color);

        let ctx = document.getElementById('myChart').getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'จำนวนผู้สมัครตามแผน',
                    data: values,
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>




</body>

</html>