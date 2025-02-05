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
    <title><?= $translations['Program Specification- Specification Approval Data']?></title>
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
            height: 120vh;
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

        table {
            width: 90%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            margin-bottom: 20px;
            border-radius: 7px;
            overflow: hidden;
        }

        table th {
            background: linear-gradient(to right, #003f8a, #0057b7);
            color: white;
            font-weight: 400;
            padding: 7px;
            width: 30%;
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
        }

        input {
            width: 100%;
            border: none;
            outline: none;
            padding: 5px;
            font-size: 14px;
            box-sizing: border-box;
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

        .header h1 {
            color: #003f8a;
            font-size: 28px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .header h3 {
            color: #003f8a;
            font-size: 24px;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
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

            $id_query = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
            $row = mysqli_fetch_assoc($id_query);
            $program_id = $row["id"];

            // عند الضغط على زر "Save"
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
                // التحقق من الاتصال
                if ($conn->connect_error) {
                    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
                }

                // الحصول على القيم من الحقول
                $effectiveness_of_teaching = $_POST['effectiveness_of_teaching'];
                $teaching_methods = $_POST['teaching_methods'];
                $effectiveness_of_student_assessment = $_POST['effectiveness_of_student_assessment'];
                $assessment_methods = $_POST['assessment_methods'];
                $quality_of_learning_resources = $_POST['quality_of_learning_resources'];
                $learning_methods = $_POST['learning_methods'];
                $clo_achievement = $_POST['clo_achievement'];
                $achievement_methods = $_POST['achievement_methods'];
                $other_assessment = $_POST['other_assessment'];
                $other_methods = $_POST['other_methods'];

                // تخزين البيانات المدخلة في $_SESSION
                $_SESSION['specification_course_quality_new'] = [
                    'effectiveness_of_teaching' => $effectiveness_of_teaching,
                    'teaching_methods' => $teaching_methods,
                    'effectiveness_of_student_assessment' => $effectiveness_of_student_assessment,
                    'assessment_methods' => $assessment_methods,
                    'quality_of_learning_resources' => $quality_of_learning_resources,
                    'learning_methods' => $learning_methods,
                    'clo_achievement' => $clo_achievement,
                    'achievement_methods' => $achievement_methods,
                    'other_assessment' => $other_assessment,
                    'other_methods' => $other_methods,
                ];

                // التحقق من أن جميع الحقول ممتلئة
                if (
                    !empty($effectiveness_of_teaching) && !empty($teaching_methods) &&
                    !empty($effectiveness_of_student_assessment) && !empty($assessment_methods) &&
                    !empty($quality_of_learning_resources) && !empty($learning_methods) &&
                    !empty($clo_achievement) && !empty($achievement_methods) &&
                    !empty($other_assessment) && !empty($other_methods)
                ) {
                    // إعداد استعلام الإدخال
                    $stmt = $conn->prepare("INSERT INTO assessment_quality (
                        user_id, effectiveness_of_teaching, teaching_methods, 
                        effectiveness_of_student_assessment, assessment_methods, 
                        quality_of_learning_resources, learning_methods, 
                        clo_achievement, achievement_methods, 
                        other_assessment, other_methods, program_id
                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

                    $stmt->bind_param(
                        'issssssssssi',
                        $user_id,
                        $effectiveness_of_teaching,
                        $teaching_methods,
                        $effectiveness_of_student_assessment,
                        $assessment_methods,
                        $quality_of_learning_resources,
                        $learning_methods,
                        $clo_achievement,
                        $achievement_methods,
                        $other_assessment,
                        $other_methods,
                        $program_id
                    );

                    // تنفيذ الاستعلام
                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }

                    $stmt->close();
                } else {
                    $_SESSION['message'] = "Please fill in all fields.";
                }

                header("location: Course_Spesification_Assessment_Of_Course_Quality.php?new=" . $program_name);
                exit;
            }
    ?>

            <div class="container">
                <div class="sidebar">
                    <div class="user-section">
                    </div>
                    <a href="Course_Specification.php?new=<?php echo $program_name ?>"><button><?= $translations['Courses'] ?></button></a>
                    <a href="Course_Specification_General_Info_About_The_Course.php?new=<?php echo $program_name ?>"><button><?= $translations['General Information About The Course'] ?></button></a>
                    <a href="Course_Specification_Course_Learning_Outcomes.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes'] ?></button></a>
                    <a href="Course_Specification_Course_Content.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Content'] ?></button></a>
                    <a href="Course_Spesification_Students_Assessment_Activities.php?new=<?php echo $program_name ?>"><button><?= $translations['Student Assessment Activity'] ?></button></a>
                    <a href="Course_Spesification_Learning_Resources_and_Facilities.php?new=<?php echo $program_name ?>"><button><?= $translations['Learning Resources And Facilities'] ?></button></a>
                    <a href="Course_Spesification_Assessment_Of_Course_Quality.php?new=<?php echo $program_name ?>"><button><?= $translations['Assessment Of Course Quality'] ?></button></a>
                    <a href="Course_Spesification_Specification_Approval.php?new=<?php echo $program_name ?>"><button><?= $translations['Specification Approval'] ?></button></a>

                </div>

                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Course Specification']?></h3>
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
                            <h2><?= $translations['Assessment Of Course Quality']?></h2>

                            <table>
                                <thead>
                                    <tr>
                                        <th><?= $translations['Assessment Areas/Issues']?></th>
                                        <th><?= $translations['Assessor']?></th>
                                        <th><?= $translations['Assessment Methods']?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $translations['Effectiveness of teaching']?></td>
                                        <td><input type="text" name="effectiveness_of_teaching" value="<?= isset($_SESSION['specification_course_quality_new']['effectiveness_of_teaching']) ? $_SESSION['specification_course_quality_new']['effectiveness_of_teaching'] : '' ?>" required></td>
                                        <td><input type="text" name="teaching_methods" value="<?= isset($_SESSION['specification_course_quality_new']['teaching_methods']) ? $_SESSION['specification_course_quality_new']['teaching_methods'] : '' ?>" required></td>
                                    </tr>
                                    <tr>
                                        <td><?= $translations['Effectiveness of Students assessment']?></td>
                                        <td><input type="text" name="effectiveness_of_student_assessment" value="<?= isset($_SESSION['specification_course_quality_new']['effectiveness_of_student_assessment']) ? $_SESSION['specification_course_quality_new']['effectiveness_of_student_assessment'] : '' ?>" required></td>
                                        <td><input type="text" name="assessment_methods" value="<?= isset($_SESSION['specification_course_quality_new']['assessment_methods']) ? $_SESSION['specification_course_quality_new']['assessment_methods'] : '' ?>" required></td>
                                    </tr>
                                    <tr>
                                        <td><?= $translations['Quality of learning resources']?></td>
                                        <td><input type="text" name="quality_of_learning_resources" value="<?= isset($_SESSION['specification_course_quality_new']['quality_of_learning_resources']) ? $_SESSION['specification_course_quality_new']['quality_of_learning_resources'] : '' ?>" required></td>
                                        <td><input type="text" name="learning_methods" value="<?= isset($_SESSION['specification_course_quality_new']['learning_methods']) ? $_SESSION['specification_course_quality_new']['learning_methods'] : '' ?>" required></td>
                                    </tr>
                                    <tr>
                                        <td><?= $translations['The extent to which CLOs have been achieved']?></td>
                                        <td><input type="text" name="clo_achievement" value="<?= isset($_SESSION['specification_course_quality_new']['clo_achievement']) ? $_SESSION['specification_course_quality_new']['clo_achievement'] : '' ?>" required></td>
                                        <td><input type="text" name="achievement_methods" value="<?= isset($_SESSION['specification_course_quality_new']['achievement_methods']) ? $_SESSION['specification_course_quality_new']['achievement_methods'] : '' ?>" required></td>
                                    </tr>
                                    <tr>
                                        <td><?= $translations['Others']?></td>
                                        <td><input type="text" name="other_assessment" value="<?= isset($_SESSION['specification_course_quality_new']['other_assessment']) ? $_SESSION['specification_course_quality_new']['other_assessment'] : '' ?>" required></td>
                                        <td><input type="text" name="other_methods" value="<?= isset($_SESSION['specification_course_quality_new']['other_methods']) ? $_SESSION['specification_course_quality_new']['other_methods'] : '' ?>" required></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p><?= $translations['Assessors (Students, Faculty, Program Leaders, Peer Reviewers, Others (specify) Assessment Methods (Direct, Indirect))']?></p>
                            <div class="navigation-buttons">

                                <button name="save" class="nav-button" type="submit"><?= $translations['Save']?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Specification_Approval.php?new=<?= $program_name ?>')"><?= $translations['Next']?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Learning_Resources_and_Facilities.php?new=<?= $program_name ?>')"><?= $translations['Back']?></button>
                            </div>
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
    <?php }
    } ?>


    <?php
    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        // جلب id البرنامج
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program['id'];

        // التحقق إذا تم اختيار عنصر للتعديل
        $edit_item = $_POST['edit_item'] ?? '';

        if ($edit_item) {
            // جلب بيانات العنصر المحدد
            $query = mysqli_query($conn, "SELECT * FROM assessment_quality WHERE id = '$edit_item' AND user_id = '$user_id'");
            $row = mysqli_fetch_assoc($query);

            // حفظ البيانات في الجلسة لتبقى في الـ inputs
            $_SESSION['specification_course_quality_edit'] = $row;  // حفظ البيانات في الجلسة
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            // الحصول على القيم من الحقول
            $effectiveness_of_teaching = $_POST['effectiveness_of_teaching'];
            $teaching_methods = $_POST['teaching_methods'];
            $effectiveness_of_student_assessment = $_POST['effectiveness_of_student_assessment'];
            $assessment_methods = $_POST['assessment_methods'];
            $quality_of_learning_resources = $_POST['quality_of_learning_resources'];
            $learning_methods = $_POST['learning_methods'];
            $clo_achievement = $_POST['clo_achievement'];
            $achievement_methods = $_POST['achievement_methods'];
            $other_assessment = $_POST['other_assessment'];
            $other_methods = $_POST['other_methods'];

            if (
                !empty($effectiveness_of_teaching) && !empty($teaching_methods) &&
                !empty($effectiveness_of_student_assessment) && !empty($assessment_methods) &&
                !empty($quality_of_learning_resources) && !empty($learning_methods) &&
                !empty($clo_achievement) && !empty($achievement_methods) &&
                !empty($other_assessment) && !empty($other_methods)
            ) {
                if ($edit_item) {
                    // تحديث البيانات إذا كان العنصر موجودًا
                    $stmt = $conn->prepare("UPDATE assessment_quality SET 
                effectiveness_of_teaching = ?, 
                teaching_methods = ?, 
                effectiveness_of_student_assessment = ?, 
                assessment_methods = ?, 
                quality_of_learning_resources = ?, 
                learning_methods = ?, 
                clo_achievement = ?, 
                achievement_methods = ?, 
                other_assessment = ?, 
                other_methods = ? 
                WHERE id = ? AND user_id = ?");

                    $stmt->bind_param(
                        'ssssssssssii',
                        $effectiveness_of_teaching,
                        $teaching_methods,
                        $effectiveness_of_student_assessment,
                        $assessment_methods,
                        $quality_of_learning_resources,
                        $learning_methods,
                        $clo_achievement,
                        $achievement_methods,
                        $other_assessment,
                        $other_methods,
                        $edit_item,
                        $user_id
                    );
                }

                if ($stmt->execute()) {
                    $_SESSION['message'] = $edit_item ? 'Record updated successfully!' : 'Record inserted successfully!';
                    // تحديث البيانات في الجلسة بعد التحديث
                    $_SESSION['specification_course_quality_edit'] = [
                        'effectiveness_of_teaching' => $effectiveness_of_teaching,
                        'teaching_methods' => $teaching_methods,
                        'effectiveness_of_student_assessment' => $effectiveness_of_student_assessment,
                        'assessment_methods' => $assessment_methods,
                        'quality_of_learning_resources' => $quality_of_learning_resources,
                        'learning_methods' => $learning_methods,
                        'clo_achievement' => $clo_achievement,
                        'achievement_methods' => $achievement_methods,
                        'other_assessment' => $other_assessment,
                        'other_methods' => $other_methods,
                        'id' => $edit_item  // حفظ الـ id في الجلسة
                    ];
                } else {
                    $_SESSION['message'] = 'Error occurred while saving data.';
                }

                $stmt->close();
                header("Location: Course_Spesification_Assessment_Of_Course_Quality.php?edit=$program_name");
                exit;
            } else {
                $_SESSION['message'] = "Please fill in all fields.";
            }
        }
    ?>

        <div class="container">
            <div class="sidebar">
                <div class="user-section">
                </div>
                <a href="Course_Specification.php?edit=<?php echo $program_name ?>"><button><?= $translations['Courses'] ?></button></a>
                <a href="Course_Specification_General_Info_About_The_Course.php?edit=<?php echo $program_name ?>"><button><?= $translations['General Information About The Course'] ?></button></a>
                <a href="Course_Specification_Course_Learning_Outcomes.php?edit=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes'] ?></button></a>
                <a href="Course_Specification_Course_Content.php?edit=<?php echo $program_name ?>"><button><?= $translations['Course Content'] ?></button></a>
                <a href="Course_Spesification_Students_Assessment_Activities.php?edit=<?php echo $program_name ?>"><button><?= $translations['Student Assessment Activity'] ?></button></a>
                <a href="Course_Spesification_Learning_Resources_and_Facilities.php?edit=<?php echo $program_name ?>"><button><?= $translations['Learning Resources And Facilities'] ?></button></a>
                <a href="Course_Spesification_Assessment_Of_Course_Quality.php?edit=<?php echo $program_name ?>"><button><?= $translations['Assessment Of Course Quality'] ?></button></a>
                <a href="Course_Spesification_Specification_Approval.php?edit=<?php echo $program_name ?>"><button><?= $translations['Specification Approval'] ?></button></a>

            </div>

            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <h3><?= $translations['Course Spesification']?></h3>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>
                <form method="post" id="coursesForm">

                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    }
                    ?>

                    <label><?= $translations['Select an item to edit']?></label>
                    <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                        <option value=""><?= $translations['Select']?></option>
                        <?php
                        // عرض الخيارات
                        $query = "SELECT * FROM assessment_quality WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);
                        while ($row_edit = mysqli_fetch_assoc($result)) {
                            $selected = ($row_edit['id'] == $_SESSION['specification_course_quality_edit']['id'] ?? '') ? 'selected' : '';
                            echo "<option value='{$row_edit['id']}' $selected>{$row_edit['effectiveness_of_teaching']}</option>";
                        }
                        ?>
                    </select>

                    <button type="submit" class="button" name="edit_row"><?= $translations['Edit']?></button>

                    <div id="programs" class="form-container">
                        <h2><?= $translations['Assessment Of Course Quality']?></h2>
                        <table>
                            <thead>
                                <tr>
                                    <th><?= $translations['Assessment Areas/Issues']?></th>
                                    <th><?= $translations['Assessor']?></th>
                                    <th><?= $translations['Assessment Methods']?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $translations['Effectiveness of teaching']?></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['specification_course_quality_edit']['effectiveness_of_teaching'] ?? '') ?>" type="text" name="effectiveness_of_teaching"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['specification_course_quality_edit']['teaching_methods'] ?? '') ?>" type="text" name="teaching_methods"></td>
                                </tr>
                                <tr>
                                    <td><?= $translations['Effectiveness of Students assessment']?></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['specification_course_quality_edit']['effectiveness_of_student_assessment'] ?? '') ?>" type="text" name="effectiveness_of_student_assessment"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['specification_course_quality_edit']['assessment_methods'] ?? '') ?>" type="text" name="assessment_methods"></td>
                                </tr>
                                <tr>
                                    <td><?= $translations['Quality of learning resources']?></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['specification_course_quality_edit']['quality_of_learning_resources'] ?? '') ?>" type="text" name="quality_of_learning_resources"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['specification_course_quality_edit']['learning_methods'] ?? '') ?>" type="text" name="learning_methods"></td>
                                </tr>
                                <tr>
                                    <td><?= $translations['The extent to which CLOs have been achieved']?></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['specification_course_quality_edit']['clo_achievement'] ?? '') ?>" type="text" name="clo_achievement"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['specification_course_quality_edit']['achievement_methods'] ?? '') ?>" type="text" name="achievement_methods"></td>
                                </tr>
                                <tr>
                                    <td><?= $translations['Others']?></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['specification_course_quality_edit']['other_assessment'] ?? '') ?>" type="text" name="other_assessment"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['specification_course_quality_edit']['other_methods'] ?? '') ?>" type="text" name="other_methods"></td>
                                </tr>
                            </tbody>
                        </table>
                        <p><?= $translations['Assessors (Students, Faculty, Program Leaders, Peer Reviewers, Others (specify) Assessment Methods (Direct, Indirect))']?></p>
                        <div class="navigation-buttons">

                            <button name="update" class="nav-button" type="submit"><?= $translations['Update']?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Specification_Approval.php?edit=<?= $program_name ?>')"><?= $translations['Next']?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Learning_Resources_and_Facilities.php?edit=<?= $program_name ?>')"><?= $translations['Back']?></button>
                        </div>
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
    <?php }
    ?>


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