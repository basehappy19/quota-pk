<div class="col-lg-4" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1000">
    <div class="card mb-5 choose-plan--choose"
        style='
    box-shadow: 0px 0px 44px -20px <?php echo $plan['color'] ?>;
    -webkit-box-shadow: 0px 0px 44px -20px <?php echo $plan['color'] ?>;
    -moz-box-shadow: 0px 1px 44px -20px <?php echo $plan['color'] ?>;
    '>
        <div>
            <img class="card-img-top mb-3" src="helper/plan/<?php echo $plan['img_cover'] ?>">
        </div>
        <div class="card-body">
            <h5 class="card-title text-center"><?php echo $plan['name'] ?></h5>
            <div class="text-center">
                <p class="m-0">จำนวนการสมัครแล้ว <?php echo (string)$plan['num_students'] ?> คน</p>
            </div>
            <hr>
            <div class="hide-dot">
                <ul>
                    <?php if ($plan['min_GPAX'] > 0) : ?>
                        <li>
                            <?php if ($student['GPAX'] >= $plan['min_GPAX']) : ?>
                                <i class="fas fa-check text-success"></i>
                            <?php else : ?>
                                <i class="fas fa-times text-danger"></i>
                            <?php endif; ?>
                            GPAX ตั้งแต่ <?php echo $plan['min_GPAX'] ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($plan['min_GPA_MAT'] > 0) : ?>
                        <li>
                            <?php if ($student['GPA_MAT'] >= $plan['min_GPA_MAT']) : ?>
                                <i class="fas fa-check text-success"></i>
                            <?php else : ?>
                                <i class="fas fa-times text-danger"></i>
                            <?php endif; ?>
                            GPA วิชาคณิตศาสตร์ ตั้งแต่ <?php echo $plan['min_GPA_MAT'] ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($plan['min_GPA_SCI'] > 0) : ?>
                        <li>
                            <?php if ($student['GPA_SCI'] >= $plan['min_GPA_SCI']) : ?>
                                <i class="fas fa-check text-success"></i>
                            <?php else : ?>
                                <i class="fas fa-times text-danger"></i>
                            <?php endif; ?>
                            GPA วิชาวิทยาศาสตร์ ตั้งแต่ <?php echo $plan['min_GPA_SCI'] ?>
                        </li>
                    <?php endif; ?>
                    <li>
                        <?php if ($student['behavior_pass'] === 1) : ?>
                            <i class="fas fa-check text-success"></i>
                        <?php else : ?>
                            <i class="fas fa-times text-danger"></i>
                        <?php endif; ?>
                        คะแนนความประพฤติไม่ติดลบ เกิน 100 คะแนน
                    </li>
                    <li>
                        <?php if ($student['GPA_Fail'] === 0) : ?>
                            <i class="fas fa-check text-success"></i>
                        <?php else : ?>
                            <i class="fas fa-times text-danger"></i>
                        <?php endif; ?>
                        ต้องไม่มีผลการเรียน ติด 0 ร มส มผ
                    </li>
                </ul>
            </div>
            <?php
            $settings['current_date'] = date('Y-m-d H:i:s');
            $isInRegistrationPeriod = ($settings['registration_enabled'] === 1) &&
                ($settings['current_date'] >= $settings['registration_start_date'] && 
                 $settings['current_date'] < $settings['registration_end_date']);
            ?>
            <?php if (!$isInRegistrationPeriod) : ?>
                <p class="text-center text-danger">ปิดรับสมัครแล้ว</p>
            <?php elseif (
                (
                    $student['GPAX'] < $plan['min_GPAX'] ||
                    $student['GPA_MAT'] < $plan['min_GPA_MAT'] ||
                    $student['GPA_SCI'] < $plan['min_GPA_SCI'] ||
                    $student['GPA_Fail'] === 1 ||
                    $student['behavior_pass'] !== 1
                )
            ) : ?>
                <p class="text-center text-danger">สมัครไม่ได้ คุณสมบัติไม่ตรงตามเงื่อนไข</p>
            <?php else : ?>
                <div class="text-center">
                    <button class="btn btn-primary animated-button" type="button" name="code" value="<?php echo $plan['code'] ?>" onclick="confirmForm('<?php echo $plan['code'] ?>')"><i class="far fa-edit"></i>&nbsp;สมัคร</button>
                </div>
            <?php endif; ?>


        </div>
    </div>
</div>
