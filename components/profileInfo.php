<?php
$student = getStudent($conn, $_SESSION['studentId']);

?>

<div class="card-background" id="card--account" data-aos="zoom-in" data-aos-delay="150" data-aos-duration="1000">
    <h4>ข้อมูลผู้สมัคร</h4>
    <?php if (isset($student)) : ?>
        <div><span>รหัสนักเรียน : </span><?php echo $student['student_id']; ?></div>
        <div>
            <span>ชื่อ - สกุล : </span>
            <span><?php echo $student['name']; ?></span>
            <span>ระดับชั้น : </span><?php echo $student['room']; ?>
            <span>เลขที่ </span><?php echo $student['student_number']; ?>
        </div>
        <div></div>
        <span>เกรดเฉลี่ย : </span>
        <span class="badge bg-secondary gpa">
            5 เทอม <?php echo $student['GPAX']; ?>
        </span>
        <span class="badge bg-secondary gpa">
            คณิต <?php echo $student['GPA_MAT']; ?>
        </span>
        <span class="badge bg-secondary badge bg-secondary gpa">
            วิทย์ <?php echo $student['GPA_SCI']; ?>
        </span>
        <div>
            <span>คะแนนความประพฤติ : </span>
            <span class="badge <?php echo $student['behavior_pass'] === 1 ? "bg-success" : "bg-danger" ?>">
                <?php echo $student['behavior_pass'] === 1 ? "ผ่าน" : "ไม่ผ่าน" ?>
            </span>
        </div>
        <div>
            <span>ติด 0 ร มส มผ : </span>
            <span class="badge <?php echo $student['GPA_Fail'] === 1 ? "bg-danger" : "bg-success" ?>"><?php echo $student['GPA_Fail'] === 1 ? "มี" : "ไม่มี" ?></span>
        </div>


    <?php endif; ?>
</div>