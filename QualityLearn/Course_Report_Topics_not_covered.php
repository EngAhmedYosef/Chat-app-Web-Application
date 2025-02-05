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
    <title><?= $translations['Course Report- Topics not covered'] ?></title>
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
            height: 150vh;
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

        table {
            width: 70%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            margin-bottom: 20px;
            border-radius: 7px;
            overflow: hidden;
        }

        td {
            border: 1px solid #003f8a;
            text-align: center;
            padding: 7px;
            font-size: 15px;
            background-color: #f2f7fc;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th {
            background: linear-gradient(to right, #003f8a, #0057b7);
            color: white;
            font-weight: 400;
            padding: 7px;
            /* تقليص التباعد داخل الخلايا */
            font-size: 15px;
            border: 1px solid #003f8a;
            text-align: center;
        }

        input {
            width: 90%;
            padding: 4px;
            font-size: 12px;
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

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
                $topics = $_POST['topic'];
                $reasons = $_POST['reason'];
                $impacts = $_POST['impact'];
                $actions = $_POST['action'];

                $data = []; // مصفوفة لتجميع جميع البيانات

                // جمع البيانات من جميع الحقول
                for ($i = 0; $i < count($topics); $i++) {
                    if (!empty($topics[$i]) && !empty($reasons[$i]) && !empty($impacts[$i]) && !empty($actions[$i])) {
                        $data[] = [
                            'topic' => mysqli_real_escape_string($conn, $topics[$i]),
                            'reason' => mysqli_real_escape_string($conn, $reasons[$i]),
                            'impact' => mysqli_real_escape_string($conn, $impacts[$i]),
                            'action' => mysqli_real_escape_string($conn, $actions[$i]),
                        ];
                    }
                }

                if (!empty($data)) {
                    // تحويل المصفوفة إلى JSON
                    $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE);

                    // إدخال البيانات كصف واحد
                    $sql = "INSERT INTO topics_not_covered (user_id, program_id, data) 
                        VALUES ('$user_id', '$program_id', '$jsonData')";

                    if (!$conn->query($sql)) {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    } else {
                        $_SESSION['message'] = 'Records created successfully!';
                    }

                    // تخزين البيانات المدخلة في الجلسة للاستخدام في إعادة تعبئة الحقول
                    $_SESSION['cource_report_topic_not_covered_new'] = $_POST;
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("Location: Course_Report_Topics_not_covered.php?new=" . $program_name);
                exit();
            }

            // عند تحميل الصفحة، استرجاع البيانات المخزنة في الجلسة لتعبئة الحقول
            $cource_report_topic_not_covered_new = isset($_SESSION['cource_report_topic_not_covered_new']) ? $_SESSION['cource_report_topic_not_covered_new'] : [];
    ?>
            <div class="container">
                <div class="sidebar">
                    <div class="user-section"></div>
                    <a href="Course_Report_Reports.php?new=<?php echo $program_name ?>"><button><?= $translations['Reports'] ?></button></a>
                    <a href="Course_Report_Student_Results.php?new=<?php echo $program_name ?>"><button><?= $translations['Student Results'] ?></button></a>
                    <a href="Course_Report_Course_Learning _Outcomes.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes (CLO)'] ?></button></a>
                    <a href="Course_Report_Topics_not_covered.php?new=<?php echo $program_name ?>"><button><?= $translations['Topics not covered'] ?></button></a>
                    <a href="Course_Report_Course_Improvement_Plan_if_any.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Improvement Plan (if any)'] ?></button></a>
                </div>

                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Course Report'] ?></h3>
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>
                    <div id="programs" class="form-container">
                        <h2><?= $translations['Topics not covered'] ?></h2>
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>
                        <form method="post" id="coursesForm">
                            <table>
                                <thead>
                                    <tr>
                                        <th><?= $translations['Topic'] ?></th>
                                        <th><?= $translations['Reason for Not Covering/Discrepancies'] ?></th>
                                        <th><?= $translations['Extent of their Impact on Learning Outcomes'] ?></th>
                                        <th><?= $translations['Compensating Action'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < 4; $i++) { ?>
                                        <tr>
                                            <td><input name="topic[]" type="text" value="<?php echo isset($cource_report_topic_not_covered_new['topic'][$i]) ? $cource_report_topic_not_covered_new['topic'][$i] : ''; ?>"></td>
                                            <td><input name="reason[]" type="text" value="<?php echo isset($cource_report_topic_not_covered_new['reason'][$i]) ? $cource_report_topic_not_covered_new['reason'][$i] : ''; ?>"></td>
                                            <td><input name="impact[]" type="text" value="<?php echo isset($cource_report_topic_not_covered_new['impact'][$i]) ? $cource_report_topic_not_covered_new['impact'][$i] : ''; ?>"></td>
                                            <td><input name="action[]" type="text" value="<?php echo isset($cource_report_topic_not_covered_new['action'][$i]) ? $cource_report_topic_not_covered_new['action'][$i] : ''; ?>"></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <div class="navigation-buttons">

                                <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Course_Improvement_Plan_if_any.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Course_Learning _Outcomes.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            </div>
                        </form>
                    </div>
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

    if (isset($_GET['edit'])) {
        if ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS') {
            $program_name = $_GET['edit'];

            $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
            $row_program = mysqli_fetch_assoc($query_program);
            $program_id = $row_program["id"];

            // التحقق إذا كان المستخدم قد اختار أي عنصر للتعديل
            $edit_item = $_POST['edit_item'] ?? '';

            $row_data = [];
            if (!empty($edit_item)) {
                $query = mysqli_query($conn, "SELECT * FROM topics_not_covered WHERE id = '$edit_item' AND user_id = '$user_id'");
                $row_data = mysqli_fetch_assoc($query);
            }

            // عند الضغط على "Edit" أو تحميل البيانات
            if (isset($_POST['edit_item']) && !empty($_POST['edit_item'])) {
                $_SESSION['cource_report_topic_not_covered_edit'] = [
                    'edit_item' => $_POST['edit_item'],
                    'topics' => json_decode($row_data['data'], true) // حفظ البيانات في الجلسة
                ];
            }

            // عند الضغط على "Update" لتحديث البيانات
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
                // استخدام البيانات من الجلسة لتحديث البيانات
                $topics = $_POST['topic'];
                $reasons = $_POST['reason'];
                $impacts = $_POST['impact'];
                $actions = $_POST['action'];

                $data = []; // مصفوفة لتجميع جميع البيانات

                for ($i = 0; $i < count($topics); $i++) {
                    if (!empty($topics[$i]) && !empty($reasons[$i]) && !empty($impacts[$i]) && !empty($actions[$i])) {
                        $data[] = [
                            'topic' => mysqli_real_escape_string($conn, $topics[$i]),
                            'reason' => mysqli_real_escape_string($conn, $reasons[$i]),
                            'impact' => mysqli_real_escape_string($conn, $impacts[$i]),
                            'action' => mysqli_real_escape_string($conn, $actions[$i]),
                        ];
                    }
                }

                if (!empty($data)) {
                    // تحويل المصفوفة إلى JSON
                    $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE);

                    // التحديث في قاعدة البيانات
                    $edit_item = $_SESSION['cource_report_topic_not_covered_edit']['edit_item'] ?? '';
                    if (!empty($edit_item)) {
                        $sql = "UPDATE topics_not_covered SET data = '$jsonData' WHERE id = '$edit_item' AND user_id = '$user_id'";
                    } else {
                        $sql = "INSERT INTO topics_not_covered (user_id, program_id, data) 
                            VALUES ('$user_id', '$program_id', '$jsonData')";
                    }

                    if (!$conn->query($sql)) {
                        $_SESSION['message'] = 'Error occurred while updating data.';
                    } else {
                        $_SESSION['message'] = 'Records updated successfully!';
                    }

                    // تحديث الجلسة لتخزين البيانات بعد التحديث
                    $_SESSION['cource_report_topic_not_covered_edit'] = [
                        'edit_item' => $edit_item,
                        'topics' => $data
                    ];

                    header("Location: Course_Report_Topics_not_covered.php?edit=" . $program_name);
                    exit();
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }
            }

            if (isset($_POST['next'])) {
                header("location: Course_Report_Course_Improvement_Plan_if_any.php?edit=" . $program_name);
                exit;
            }
            if (isset($_POST['back'])) {
                header("location: Course_Report_Course_Learning_Outcomes.php?edit=" . $program_name);
                exit;
            }
    ?>
            <div class="container">
                <div class="sidebar">
                    <div class="user-section"></div>
                    <a href="Course_Report_Reports.php?edit=<?php echo $program_name ?>"><button><?= $translations['Reports'] ?></button></a>
                    <a href="Course_Report_Student_Results.php?edit=<?php echo $program_name ?>"><button><?= $translations['Student Results'] ?></button></a>
                    <a href="Course_Report_Course_Learning _Outcomes.php?edit=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes (CLO)'] ?></button></a>
                    <a href="Course_Report_Topics_not_covered.php?edit=<?php echo $program_name ?>"><button><?= $translations['Topics not covered'] ?></button></a>
                    <a href="Course_Report_Course_Improvement_Plan_if_any.php?edit=<?php echo $program_name ?>"><button><?= $translations['Course Improvement Plan (if any)'] ?></button></a>
                </div>

                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Course Report'] ?></h3>
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>
                    <div id="programs" class="form-container">
                        <h2><?= $translations['Topics not covered'] ?></h2>
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>
                        <form method="post" id="coursesForm">

                            <?php
                            // استعلام لجلب جميع الخيارات
                            $query = "SELECT * FROM topics_not_covered WHERE program_id = '$program_id' AND user_id = '$user_id'";
                            $result = mysqli_query($conn, $query);
                            ?>

                            <label><?= $translations['Select an item to edit'] ?></label>
                            <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                                <option value=""><?= $translations['Select'] ?></option>
                                <?php
                                // عرض الخيارات
                                while ($row_edit = mysqli_fetch_assoc($result)) {

                                    $data = json_decode($row_edit['data'], true);

                                    // التحقق إذا كانت البيانات موجودة
                                    if (!empty($data) && is_array($data)) {
                                        // أخذ أول عنصر من الكورسات
                                        $first_course = $data[0];

                                        // استخراج course_title لأول كورس
                                        $topic = $first_course['topic'] ?? 'N/A';


                                        $selected = ($row_edit['id'] == $_SESSION['cource_report_topic_not_covered_edit']['edit_item']) ? 'selected' : '';
                                        echo "<option value='{$row_edit['id']}' $selected>{$topic}</option>";
                                    }
                                }
                                ?>
                            </select>

                            <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>">

                            <table>
                                <thead>
                                    <tr>
                                        <th><?= $translations['Topic'] ?></th>
                                        <th><?= $translations['Reason for Not Covering/Discrepancies'] ?></th>
                                        <th><?= $translations['Extent of their Impact on Learning Outcomes'] ?></th>
                                        <th><?= $translations['Compensating Action'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // عرض البيانات الحالية إذا تم اختيار عنصر للتعديل
                                    $current_data = $_SESSION['cource_report_topic_not_covered_edit']['topics'] ?? [];
                                    for ($i = 0; $i < 4; $i++) {
                                        $topic = $current_data[$i]['topic'] ?? '';
                                        $reason = $current_data[$i]['reason'] ?? '';
                                        $impact = $current_data[$i]['impact'] ?? '';
                                        $action = $current_data[$i]['action'] ?? '';
                                    ?>
                                        <tr>
                                            <td><input name="topic[]" type="text" value="<?= htmlspecialchars($topic) ?>"></td>
                                            <td><input name="reason[]" type="text" value="<?= htmlspecialchars($reason) ?>"></td>
                                            <td><input name="impact[]" type="text" value="<?= htmlspecialchars($impact) ?>"></td>
                                            <td><input name="action[]" type="text" value="<?= htmlspecialchars($action) ?>"></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <div class="navigation-buttons">
                                <button name="update" class="nav-button" type="submit"><?= $translations['Update'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Course_Improvement_Plan_if_any.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Course_Learning _Outcomes.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            </div>
                        </form>
                    </div>
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