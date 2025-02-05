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
    <title><?= $translations['Program Specification-Curriculum-3 Program learning Outcomes Mapping Matrix'] ?></title>
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
            height: 175vh;
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
            /* يجعل النصوص في الوسط */
            margin-top: 0px;
            /* مسافة من الأعلى */
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
            width: 70%;
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
            font-size: 10px;
            background-color: #f2f7fc;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 80%;
            padding: 4px;
            font-size: 6px;
            text-align: center;

        }

        textarea {
            width: 90%;
            height: 50px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
            margin-bottom: 0px;
            background-color: #f9f9f9;
        }

        textarea:focus {
            outline: none;
            border-color: #003f8a;
            background-color: #fff;
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

            // جلب معرّف البرنامج من قاعدة البيانات
            $id_query = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
            $row = mysqli_fetch_assoc($id_query);
            $program_id = $row["id"];

            // Initialize session data if not set
            if (!isset($_SESSION['curriculum_3_new'])) {
                $_SESSION['curriculum_3_new'] = [];
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
                // تحقق من أن جميع الحقول تم تعبئتها
                $isValid = true;

                // مصفوفة لتخزين بيانات الجدول
                $courses_data = [];

                // تحقق من الحقول الخاصة بالجدول
                for ($i = 1; $i <= 8; $i++) {
                    for ($j = 1; $j <= 9; $j++) {
                        $field_name = "course_{$i}_{$j}";
                        if (empty($_POST[$field_name])) {
                            $isValid = false;
                            echo "Field {$field_name} is empty. ";
                            break 2; // الخروج من الحلقتين إذا كانت أي حقل فارغ
                        }
                        // إضافة القيمة إلى المصفوفة
                        $courses_data["row_{$i}_col_{$j}"] = $_POST[$field_name];
                    }
                }

                // تحقق من الحقول الخاصة بالنصوص
                if (empty($_POST['teaching_strategies']) || empty($_POST['assessment_methods'])) {
                    $isValid = false;
                    echo "Teaching strategies or Assessment methods are empty. ";
                }

                // If form is valid, save to database
                if ($isValid) {
                    $data = [
                        'courses' => $courses_data,
                        'teaching_strategies' => $_POST['teaching_strategies'],
                        'assessment_methods' => $_POST['assessment_methods']
                    ];

                    $json_data = json_encode($data);

                    // إدخال البيانات في قاعدة البيانات
                    $stmt = $conn->prepare("INSERT INTO program_learning_outcomes (user_id, data, program_id) VALUES (?, ?, ?)");
                    $stmt->bind_param("iss", $user_id, $json_data, $program_id);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all the fields.';
                }

                // Save the form data in session to keep it in the inputs
                $_SESSION['curriculum_3_new'] = $_POST;

                header("location: Program_Specification_Curriculum-3_Program_learning_Outcomes_Mapping_Matrix.php?new=" . $program_name);
                exit;
            }
    ?>

            <div class="container">
                <div class="sidebar">
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
                            <h3><?= $translations['Program learning Outcomes Mapping Matrix'] ?>:</h3>
                            <p><?= $translations['Align the program learning outcomes with program courses, according to the following desired levels of performance (I = Introduced & P = Practiced & M = Mastered)'] ?>.</p>

                            <table>
                                <tr>
                                    <th rowspan="2"><?= $translations['Course Code'] ?></th>
                                    <th colspan="3"><?= $translations['Knowledge and Understanding'] ?></th>
                                    <th colspan="3"><?= $translations['Skills'] ?></th>
                                    <th colspan="3"><?= $translations['Values, Autonomy, and Responsibility'] ?></th>
                                </tr>
                                <tr>
                                    <th>K1</th>
                                    <th>K2</th>
                                    <th>K3</th>
                                    <th>S1</th>
                                    <th>S2</th>
                                    <th>S3</th>
                                    <th>V1</th>
                                    <th>V2</th>
                                    <th>V3</th>
                                </tr>
                                <?php for ($i = 1; $i <= 8; $i++) { ?>
                                    <tr>
                                        <td><?= $translations['Course...'] ?></td>
                                        <?php for ($j = 1; $j <= 9; $j++) { ?>
                                            <td><input type="text" name="course_<?= $i ?>_<?= $j ?>" value="<?php echo isset($_SESSION['curriculum_3_new']["course_{$i}_{$j}"]) ? $_SESSION['curriculum_3_new']["course_{$i}_{$j}"] : ''; ?>" /></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </table>

                            <div class="form-group">
                                <label for="special-support1"><?= $translations['Teaching and learning strategies applied to achieve program learning outcomes'] ?>.</label>
                                <textarea name="teaching_strategies" id="special-support1"><?php echo isset($_SESSION['curriculum_3_new']['teaching_strategies']) ? $_SESSION['curriculum_3_new']['teaching_strategies'] : ''; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="special-support2"><?= $translations['Assessment Methods for program learning outcomes'] ?>.</label>
                                <textarea name="assessment_methods" id="special-support2"><?php echo isset($_SESSION['curriculum_3_new']['assessment_methods']) ? $_SESSION['curriculum_3_new']['assessment_methods'] : ''; ?></textarea>
                            </div>

                            <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Student_Admission_and_Support.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Curriculum-2_Program_Courses.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
                <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                    <p><?= $translations['You have unsaved data. Do you want to leave without saving?'] ?></p>
                    <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Leave'] ?></button>
                    <button onclick="hideCustomModal()" style="background: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Stay'] ?></button>
                </div>
            </div>
    <?php
        }
    }
    ?>



    <?php

    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        // استعلام لجلب id البرنامج
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // التحقق من أن المستخدم قد اختار العنصر للتعديل
        $edit_item = $_POST['edit_item'] ?? $_SESSION['curriculum_3_edit']['id'] ?? '';

        if ($edit_item) {
            // جلب البيانات الخاصة بالعنصر للتعديل
            $query = mysqli_query($conn, "SELECT * FROM program_learning_outcomes WHERE id = '$edit_item' AND user_id = '$user_id'");
            if ($query && mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_assoc($query);
                $saved_data = json_decode($row['data'], true);  // تأكد من تحويل JSON إلى مصفوفة

                // تخزين البيانات في $_SESSION بما في ذلك الـ id
                $_SESSION['curriculum_3_edit'] = [
                    'id' => $row['id'],
                    'data' => $saved_data
                ];
            } else {
                echo "<p>Error: Data not found.</p>";
            }
        }

        // التحقق من أن النموذج تم تقديمه وحفظ التغييرات
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            $isValid = true;
            $courses_data = [];

            // تحقق من الحقول الخاصة بالجدول
            for ($i = 1; $i <= 8; $i++) {
                for ($j = 1; $j <= 9; $j++) {
                    $field_name = "course_{$i}_{$j}";
                    if (empty($_POST[$field_name])) {
                        $isValid = false;
                        break 2;
                    }
                    $courses_data["row_{$i}_col_{$j}"] = $_POST[$field_name];
                }
            }

            // تحقق من الحقول النصية
            if (empty($_POST['teaching_strategies']) || empty($_POST['assessment_methods'])) {
                $isValid = false;
            }

            if ($isValid) {
                // جمع البيانات في مصفوفة
                $data = [
                    'courses' => $courses_data,
                    'teaching_strategies' => $_POST['teaching_strategies'],
                    'assessment_methods' => $_POST['assessment_methods']
                ];

                // تحويل البيانات إلى JSON
                $json_data = json_encode($data);

                if ($edit_item) {
                    // تحديث البيانات في قاعدة البيانات
                    $stmt = $conn->prepare("UPDATE program_learning_outcomes SET data = ?, program_id = ? WHERE id = ? AND user_id = ?");
                    $stmt->bind_param("siii", $json_data, $program_id, $edit_item, $user_id);
                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Record updated successfully!';
                        // بعد التحديث، نحدث البيانات المخزنة في الجلسة
                        $_SESSION['curriculum_3_edit'] = [
                            'id' => $edit_item,
                            'data' => $data
                        ];
                    } else {
                        $_SESSION['message'] = 'Error occurred while updating data.';
                    }
                } else {
                    // إدخال البيانات جديدة في حالة عدم وجود `edit_item`
                    $stmt = $conn->prepare("INSERT INTO program_learning_outcomes (user_id, data, program_id) VALUES (?, ?, ?)");
                    $stmt->bind_param("iss", $user_id, $json_data, $program_id);
                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Record created successfully!';
                        // بعد الإدخال، نحدث البيانات المخزنة في الجلسة
                        $_SESSION['curriculum_3_edit'] = [
                            'id' => $stmt->insert_id,
                            'data' => $data
                        ];
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                }

                // إعادة التوجيه بعد الحفظ
                header("location: Program_Specification_Curriculum-3_Program_learning_Outcomes_Mapping_Matrix.php?edit=" . $program_name);
                exit;
            } else {
                echo "Please fill in all the fields.";
            }
        }
    ?>

        <div class="container">
            <div class="sidebar">
                <div class="user-section"></div>
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
                        // استعلام لجلب جميع العناصر من البرنامج_learning_outcomes
                        $result = mysqli_query($conn, "SELECT * FROM program_learning_outcomes WHERE program_id = '$program_id' AND user_id = '$user_id'");

                        while ($row_edit = mysqli_fetch_assoc($result)) {
                            // فك تشفير بيانات الـ JSON المخزنة في الحقل "data"
                            $saved_data = json_decode($row_edit['data'], true);

                            // التحقق من وجود مصفوفة "courses" داخل البيانات وفحص إذا كانت row_1_col_1 موجودة
                            if (isset($saved_data['courses']['row_1_col_1'])) {
                                // استخراج القيمة من row_1_col_1
                                $row_1_col_1_value = $saved_data['courses']['row_1_col_1'];

                                // تحديد إذا كان هذا الخيار هو الخيار المحدد بناءً على edit_item
                                $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';

                                // عرض القيمة في القائمة المنسدلة
                                echo "<option value='{$row_edit['id']}' $selected>{$row_1_col_1_value}</option>";
                            }
                        }
                        ?>
                    </select>


                    <button class="button" type="submit" name="edit_row"><?= $translations['Edit'] ?></button>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>">

                    <div id="programs" class="form-container">
                        <h3><?= $translations['Program learning Outcomes Mapping Matrix'] ?>:</h3>
                        <table>
                            <tr>
                                <th rowspan="2"><?= $translations['Course Code'] ?></th>
                                <th colspan="3"><?= $translations['Knowledge and Understanding'] ?></th>
                                <th colspan="3"><?= $translations['Skills'] ?></th>
                                <th colspan="3"><?= $translations['Values, Autonomy, and Responsibility'] ?></th>
                            </tr>
                            <tr>
                                <th>K1</th>
                                <th>K2</th>
                                <th>K3</th>
                                <th>S1</th>
                                <th>S2</th>
                                <th>S3</th>
                                <th>V1</th>
                                <th>V2</th>
                                <th>V3</th>
                            </tr>

                            <?php
                            // إذا كانت البيانات موجودة في الجلسة، قم بعرضها في الجدول
                            if (isset($_SESSION['curriculum_3_edit']) && isset($_SESSION['curriculum_3_edit']['data']['courses'])) {
                                // عرض البيانات المحفوظة
                                for ($i = 1; $i <= 8; $i++) {
                                    echo '<tr><td>Course ' . $i . '</td>';
                                    for ($j = 1; $j <= 9; $j++) {
                                        // استخدام البيانات المخزنة في الجلسة
                                        $value = $_SESSION['curriculum_3_edit']['data']['courses']["row_{$i}_col_{$j}"] ?? '';
                                        echo "<td><input type='text' name='course_{$i}_{$j}' value='{$value}' /></td>";
                                    }
                                    echo '</tr>';
                                }
                            } else {
                                // الحقول فارغة إذا لم يكن هناك عنصر للتعديل
                                for ($i = 1; $i <= 8; $i++) {
                                    echo '<tr><td>Course ' . $i . '</td>';
                                    for ($j = 1; $j <= 9; $j++) {
                                        echo "<td><input type='text' name='course_{$i}_{$j}' /></td>";
                                    }
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </table>
                    </div>

                    <div class="form-group">
                        <label for="special-support1"><?= $translations['Teaching and learning strategies applied to achieve program learning outcomes'] ?>.</label>
                        <textarea name="teaching_strategies" id="special-support1"><?php echo $_SESSION['curriculum_3_edit']['data']['teaching_strategies'] ?? ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="special-support2"><?= $translations['Assessment Methods for program learning outcomes'] ?>.</label>
                        <textarea name="assessment_methods" id="special-support2"><?php echo $_SESSION['curriculum_3_edit']['data']['assessment_methods'] ?? ''; ?></textarea>
                    </div>

                    <div class="navigation-buttons">
                        <button name="update" class="nav-button" type="submit"><?= $translations['Update'] ?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Student_Admission_and_Support.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Curriculum-2_Program_Courses.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                    </div>
                </form>
            </div>
        </div>
        <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                <p><?= $translations['You have unsaved data. Do you want to leave without saving?'] ?></p>
                <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Leave'] ?></button>
                <button onclick="hideCustomModal()" style="background: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Stay'] ?></button>
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