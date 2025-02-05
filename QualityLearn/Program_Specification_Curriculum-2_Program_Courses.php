<?php
ob_start();
include_once "conn.php";
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location:login.php');
    exit;
} ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $translations['Program Specification-Curriculum-2 Program Courses'] ?></title>
    <style>
        .button {
            display: inline-block;
            background: #003f8a;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            margin-top: 20px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #001f5b, #d7dce9);
        }

        .container {
            display: flex;
            flex-direction: row;
            height: 250vh;
        }

        .sidebar {
            background: linear-gradient(to bottom, #003f8a, #0057b7);
            width: 20%;
            padding: 20px;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.2);
        }

        .sidebar button {
            display: block;
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            background-color: #0057b7;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            text-align: left;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .sidebar button:hover {
            background-color: #0073e6;
            transform: translateY(-3px);

        }

        .main {
            width: 80%;
            padding: 20px;
            background: linear-gradient(to top, #d7dce9, #f0f4fa);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #003f8a;

        }

        .header-text {
            text-align: center;
            margin-top: 0px;
        }

        .header-text h3 {
            color: #003f8a;
            font-size: 24px;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
            margin-bottom: 5px;
        }

        .header-text p {
            color: #003f8a;
            font-size: 15px;
            font-weight: 200;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
            margin: 0;
            /* يمنع أي مسافة إضافية */
        }

        .form-container {
            width: 100%;
            margin-top: 30px;
            padding: 10px;
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-container .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
            /* مسافة بين المجموعات */
        }

        .form-container label {
            flex: 1 0 30%;
            margin-bottom: 5px;
        }

        table {
            width: 90%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            margin-bottom: 20px;
            border-radius: 7px;
            overflow: hidden;
            text-align: center;
        }

        table th {
            background: linear-gradient(to right, #003f8a, #0057b7);
            color: white;
            font-weight: 400;
            padding: 7px;
            /* تقليص التباعد داخل الخلايا */
            font-size: 15px;
            border: 1px solid #003f8a;
            text-align: center;
        }

        table td {
            border: 1px solid #003f8a;
            text-align: center;
            padding: 7px;
            font-size: 15px;
            background-color: #f2f7fc;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        td {
            width: 90%;
            /* جعل المربعات تأخذ 90% من عرض الخلية */
            padding: 4px;
            font-size: 12px;
        }

        input {
            width: 90%;
            text-align: center;
            padding: 4px;
            font-size: 12px;
        }

        p {
            color: #9fa0a1;
            font-size: 15px;
            font-weight: 200;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
            margin: 0;
        }

        .logout-button {
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px 24px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .logout-button:hover {
            background-color: #002244;
            transform: translateY(-3px);
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .nav-button {
            background-color: #003f8a;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .nav-button:hover {
            background-color: #0057b7;
            transform: translateY(-3px);
        }
    </style>
</head>

<body>

    <?php

    if (isset($_GET['new'])) {
        if ($_GET['new'] == 'IS' || $_GET['new'] == 'CS') {
            $program_name = $_GET['new'];

            // الحصول على الـ program_id
            $id_query = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
            $row = mysqli_fetch_assoc($id_query);
            $program_id = $row["id"];

            // التحقق من نوع الطلب POST وحفظ البيانات
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
                // جمع البيانات من المدخلات
                $courses = [];
                $all_filled = true;

                // التكرار عبر المدخلات للتحقق من أن كل الحقول مملوءة
                foreach ($_POST['courses'] as $course) {
                    if (
                        empty($course['course_code']) || empty($course['course_title']) || empty($course['required_or_elective']) ||
                        empty($course['pre_requisite_courses']) || !is_numeric($course['credit_hours']) || empty($course['requirement_type'])
                    ) {
                        $all_filled = false; // إذا كانت الحقول فارغة أو إذا كانت Credit Hours ليست رقمًا
                        break;
                    }

                    // إضافة البيانات إلى المصفوفة
                    $courses[] = [
                        'course_code' => $course['course_code'],
                        'course_title' => $course['course_title'],
                        'required_or_elective' => $course['required_or_elective'],
                        'pre_requisite_courses' => $course['pre_requisite_courses'],
                        'credit_hours' => (int)$course['credit_hours'],
                        'requirement_type' => $course['requirement_type'],
                    ];
                }

                // إذا كانت الحقول فارغة، عرض رسالة خطأ
                if (!$all_filled) {
                    $_SESSION['message'] = 'Please All Fields Are Required!';
                } else {
                    // تحويل البيانات إلى JSON
                    $data = json_encode($courses);

                    // التحقق من الاتصال بقاعدة البيانات
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // إعداد الاستعلام لإدخال البيانات
                    $stmt = $conn->prepare("INSERT INTO program_courses (user_id, data, program_id) VALUES (?, ?, ?)");
                    $stmt->bind_param('isi', $user_id, $data, $program_id);

                    // تنفيذ الاستعلام والتحقق من النجاح
                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data: ' . $stmt->error;
                    }
                }

                // حفظ البيانات في الـ session لاستخدامها عند إعادة تحميل الصفحة
                $_SESSION['curriculum_2_new'] = $_POST['courses'];

                // إعادة توجيه الصفحة بعد حفظ البيانات
                header("location: Program_Specification_Curriculum-2_Program_Courses.php?new=" . $program_name);
                exit;
            }

            // بدء HTML لتصميم الصفحة
    ?>
            <div class="container">
                <div class="sidebar">
                    <div class="user-section"></div>
                    <a href="Program_Specification_Curriculum-1_Curriculum_Structure.php?new=<?php echo $program_name ?>"><button><?= $translations['Curriculum Structure'] ?></button></a>
                    <a href="Program_Specification_Curriculum-2_Program_Courses.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Courses'] ?></button></a>
                    <a href="Program_Specification_Curriculum-3_Program_learning_Outcomes_Mapping_Matrix.php?new=<?php echo $program_name ?>"><button><?= $translations['Program learning Outcomes Mapping Matrix'] ?></button></a>
                </div>

                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <div class="header-text">
                            <h3><?= $translations['Program Specification'] ?></h3>
                            <p><?= $translations['Curriculum'] ?></p>
                        </div>
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>
                    <form method="post" id="coursesForm">

                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <div id="programs" class="form-container">
                            <h2><?= $translations['Program Courses'] ?></h2>
                            <table>
                                <tr>
                                    <th><?= $translations['Level'] ?></th>
                                    <th><?= $translations['Course Code'] ?></th>
                                    <th><?= $translations['Course Title'] ?></th>
                                    <th><?= $translations['Required or Elective'] ?></th>
                                    <th><?= $translations['Pre-Requisite Courses'] ?></th>
                                    <th><?= $translations['Credit Hours'] ?></th>
                                    <th><?= $translations['Type of Requirements (Institution, College, or Program)'] ?></th>
                                </tr>

                                <?php
                                $total_levels = 8;  // عدد المستويات
                                $courses_per_level = 3;  // عدد المواد في كل مستوى

                                $index = 0;  // عداد الدورات

                                // التكرار عبر المستويات والمواد
                                for ($level = 1; $level <= $total_levels; $level++):
                                    for ($i = 0; $i < $courses_per_level; $i++):
                                ?>
                                        <tr>
                                            <?php if ($i == 0): ?>
                                                <td class="level" rowspan="3"><?= $translations['Level'] ?> <?php echo $level; ?></td>
                                            <?php endif; ?>

                                            <!-- إدخال البيانات في الحقول مع التحقق من session -->
                                            <td><input type="text" name="courses[<?php echo $index; ?>][course_code]" value="<?php echo isset($_SESSION['curriculum_2_new'][$index]['course_code']) ? $_SESSION['curriculum_2_new'][$index]['course_code'] : ''; ?>"></td>
                                            <td><input type="text" name="courses[<?php echo $index; ?>][course_title]" value="<?php echo isset($_SESSION['curriculum_2_new'][$index]['course_title']) ? $_SESSION['curriculum_2_new'][$index]['course_title'] : ''; ?>"></td>
                                            <td><input type="text" name="courses[<?php echo $index; ?>][required_or_elective]" value="<?php echo isset($_SESSION['curriculum_2_new'][$index]['required_or_elective']) ? $_SESSION['curriculum_2_new'][$index]['required_or_elective'] : ''; ?>"></td>
                                            <td><input type="text" name="courses[<?php echo $index; ?>][pre_requisite_courses]" value="<?php echo isset($_SESSION['curriculum_2_new'][$index]['pre_requisite_courses']) ? $_SESSION['curriculum_2_new'][$index]['pre_requisite_courses'] : ''; ?>"></td>
                                            <td><input type="number" name="courses[<?php echo $index; ?>][credit_hours]" min="0" value="<?php echo isset($_SESSION['curriculum_2_new'][$index]['credit_hours']) ? $_SESSION['curriculum_2_new'][$index]['credit_hours'] : ''; ?>"></td>
                                            <td><input type="text" name="courses[<?php echo $index; ?>][requirement_type]" value="<?php echo isset($_SESSION['curriculum_2_new'][$index]['requirement_type']) ? $_SESSION['curriculum_2_new'][$index]['requirement_type'] : ''; ?>"></td>
                                        </tr>
                                <?php
                                        $index++;
                                    endfor;
                                endfor;
                                ?>
                            </table>

                            <div class="navigation-buttons">
                                <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Curriculum-3_Program_learning_Outcomes_Mapping_Matrix.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Curriculum-1_Curriculum_Structure.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
                <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                    <p><?= $translations['You have unsaved data. Do you want to leave without saving?'] ?></p>
                    <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none;"><?= $translations['Leave'] ?></button>
                    <button onclick="closeModal()" style="background: #ff0000; color: white; padding: 10px 20px; border: none;"><?= $translations['Stay'] ?></button>
                </div>
            </div>

    <?php
        }
    }
    ?>




    <?php
    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // التحقق إذا كان المستخدم قد اختار أي عنصر للتعديل
        if (isset($_POST['edit_item']) && $_POST['edit_item'] != '') {
            $edit_item = $_POST['edit_item'];

            // جلب البيانات الخاصة بالـ edit_item
            $query = mysqli_query($conn, "SELECT * FROM program_courses WHERE id = '$edit_item' AND program_id = '$program_id'");
            $row = mysqli_fetch_assoc($query);

            // فك تشفير البيانات المخزنة في JSON
            if (!empty($row['data'])) {
                $courses = json_decode($row['data'], true);  // تحويل JSON إلى مصفوفة
                $_SESSION['curriculum_2_edit'] = ['courses' => $courses, 'id' => $edit_item]; // تخزين البيانات مع الـ ID في الجلسة
            } else {
                $_SESSION['curriculum_2_edit'] = ['courses' => [], 'id' => $edit_item];
            }
        }

        // التحقق من أنه تم إرسال النموذج للتحديث
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            // جمع البيانات من المدخلات
            $courses = [];
            $all_filled = true;

            foreach ($_POST['courses'] as $course) {
                if (
                    empty($course['course_code']) || empty($course['course_title']) || empty($course['required_or_elective']) ||
                    empty($course['pre_requisite_courses']) || !is_numeric($course['credit_hours']) || empty($course['requirement_type'])
                ) {
                    $all_filled = false;
                    break;
                }

                $courses[] = [
                    'course_code' => $course['course_code'],
                    'course_title' => $course['course_title'],
                    'required_or_elective' => $course['required_or_elective'],
                    'pre_requisite_courses' => $course['pre_requisite_courses'],
                    'credit_hours' => (int)$course['credit_hours'],
                    'requirement_type' => $course['requirement_type'],
                ];
            }

            if (!$all_filled) {
                echo "يرجى تعبئة جميع الحقول بشكل صحيح.";
            } else {
                $data = json_encode($courses);

                // تحديث البيانات في قاعدة البيانات
                $stmt = $conn->prepare("UPDATE program_courses SET data = ? WHERE id = ?");
                $stmt->bind_param('si', $data, $_SESSION['curriculum_2_edit']['id']);

                if ($stmt->execute()) {
                    $_SESSION['curriculum_2_edit'] = ['courses' => $courses, 'id' => $_SESSION['curriculum_2_edit']['id']]; // تحديث الجلسة بالبيانات الجديدة
                    $_SESSION['message'] = 'Records updated successfully!';
                } else {
                    $_SESSION['message'] = 'Error occurred while updating data.';
                }

                // إعادة التوجيه بعد التحديث
                header("Location: Program_Specification_Curriculum-2_Program_Courses.php?edit=" . $program_name);
                exit;
            }
        }
    ?>

        <div class="container">
            <div class="sidebar">
                <div class="user-section">
                </div>
                <a href="Program_Specification_Curriculum-1_Curriculum_Structure.php?edit=<?php echo $program_name ?>"><button><?= $translations['Curriculum Structure'] ?></button></a>
                <a href="Program_Specification_Curriculum-2_Program_Courses.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Courses'] ?></button></a>
                <a href="Program_Specification_Curriculum-3_Program_learning_Outcomes_Mapping_Matrix.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program learning Outcomes Mapping Matrix'] ?></button></a>
            </div>

            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <div class="header-text">
                        <h3><?= $translations['Program Specification'] ?></h3>
                        <p><?= $translations['Curriculum'] ?></p>
                    </div>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                </div>
                <form method="post" id="coursesForm">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    }
                    ?>

                    <label><?= $translations['Select an item to edit'] ?></label>
                    <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                        <option value=""><?= $translations['Select'] ?></option>
                        <?php
                        // استعلام جلب الكورسات بناءً على البرنامج
                        $query = "SELECT * FROM program_courses WHERE program_id = '$program_id'";
                        $result = mysqli_query($conn, $query);

                        while ($row_edit = mysqli_fetch_assoc($result)) {
                            // تحويل البيانات من JSON إلى مصفوفة
                            $data = json_decode($row_edit['data'], true);

                            // التحقق إذا كانت البيانات موجودة
                            if (!empty($data) && is_array($data)) {
                                // أخذ أول عنصر من الكورسات
                                $first_course = $data[0];

                                // استخراج course_title لأول كورس
                                $course_title = $first_course['course_title'] ?? 'N/A';  // Default إذا لم توجد القيمة

                                // تعيين القيمة المحددة إذا كان هذا العنصر هو الذي يتم تحريره
                                $selected = ($row_edit['id'] == $_SESSION['curriculum_2_edit']['id']) ? 'selected' : '';
                                echo "<option value='{$row_edit['id']}' $selected>{$course_title}</option>";
                            }
                        }
                        ?>
                    </select>

                    <button type="submit" class="button"><?= $translations['Edit'] ?></button>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($_SESSION['curriculum_2_edit']['id'] ?? '') ?>">

                    <?php if (isset($_SESSION['curriculum_2_edit'])): ?>
                        <div id="programs" class="form-container">
                            <h2>Edit Program Courses</h2>
                            <table>
                                <tr>
                                    <th><?= $translations['Level'] ?></th>
                                    <th><?= $translations['Course Code'] ?></th>
                                    <th><?= $translations['Course Title'] ?></th>
                                    <th><?= $translations['Required or Elective'] ?></th>
                                    <th><?= $translations['Pre-Requisite Courses'] ?></th>
                                    <th><?= $translations['Credit Hours'] ?></th>
                                    <th><?= $translations['Type of Requirements'] ?></th>
                                </tr>
                                <?php
                                $level = 1;  // بداية مستوى Level 1
                                $count = 0;  // عداد الصفوف

                                foreach ($_SESSION['curriculum_2_edit']['courses'] as $index => $course):
                                    // كل 3 صفوف نغير المستوى
                                    if ($count == 3) {
                                        $count = 0;
                                        $level++;  // زيادة المستوى بعد 3 صفوف
                                    }
                                ?>
                                    <tr>
                                        <!-- عرض Level فقط في الصف الأول من كل مجموعة -->
                                        <?php if ($count == 0): ?>
                                            <td class="level" rowspan="3"><?= $translations['Level'] ?> <?php echo $level; ?></td>
                                        <?php endif; ?>
                                        <td><input type="text" name="courses[<?php echo $index; ?>][course_code]" value="<?php echo $course['course_code']; ?>"></td>
                                        <td><input type="text" name="courses[<?php echo $index; ?>][course_title]" value="<?php echo $course['course_title']; ?>"></td>
                                        <td><input type="text" name="courses[<?php echo $index; ?>][required_or_elective]" value="<?php echo $course['required_or_elective']; ?>"></td>
                                        <td><input type="text" name="courses[<?php echo $index; ?>][pre_requisite_courses]" value="<?php echo $course['pre_requisite_courses']; ?>"></td>
                                        <td><input type="number" name="courses[<?php echo $index; ?>][credit_hours]" value="<?php echo $course['credit_hours']; ?>"></td>
                                        <td><input type="text" name="courses[<?php echo $index; ?>][requirement_type]" value="<?php echo $course['requirement_type']; ?>"></td>
                                    </tr>
                                    <?php $count++; // زيادة العدّاد بعد كل صف 
                                    ?>
                                <?php endforeach; ?>
                            </table>

                            <div class="navigation-buttons">
                                <button name="update" class="nav-button" type="submit"><?= $translations['Update'] ?></button>
                                <button type="button" class="nav-button" onclick="location.href='Program_Specification_Curriculum-3_Program_learning_Outcomes_Mapping_Matrix.php?edit=<?php echo $program_name ?>'"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="location.href='Program_Specification_Curriculum-1_Curriculum_Structure.php?edit=<?php echo $program_name ?>'"><?= $translations['Back'] ?></button>
                            </div>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                <p><?= $translations['You have unsaved data. Do you want to leave without saving?'] ?></p>
                <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none;"><?= $translations['Leave'] ?></button>
                <button onclick="closeModal()" style="background: #ff0000; color: white; padding: 10px 20px; border: none;"><?= $translations['Stay'] ?></button>
            </div>
        </div>

    <?php } ?>



    <script>
        let unsavedData = false;
        const form = document.getElementById('coursesForm');
        const modal = document.getElementById('customModal');
        let nextPageUrl = "";

        // Check for unsaved data when any input is modified
        form.addEventListener('input', () => {
            unsavedData = true;
        });

        function handleNavigation(url) {
            if (unsavedData) {
                nextPageUrl = url;
                showCustomModal();
            } else {
                window.location.href = url;
            }
        }

        function showCustomModal() {
            modal.style.display = 'block';
        }

        function hideCustomModal() {
            modal.style.display = 'none';
        }

        function proceedToNextPage() {
            unsavedData = false;
            window.location.href = nextPageUrl;
        }
    </script>

</body>

</html>