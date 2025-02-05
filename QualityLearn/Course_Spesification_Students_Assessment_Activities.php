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
    <title><?= $translations['Course Specification-Student Assessment Activities'] ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;500&display=swap">
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
            height: 100vh;
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

        .content {
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

        .header h3 {
            color: #003f8a;
            font-size: 24px;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        }

        .header button {
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

        .header button:hover {
            background-color: #002244;
            transform: translateY(-3px);
        }

        .table-container {
            width: 100%;
            margin-top: 30px;
            padding: 10px;
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 95%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
        }

        table th {
            background: linear-gradient(to right, #003f8a, #0057b7);
            color: white;
            font-weight: 600;
            padding: 12px 15px;
            border: 1px solid #003f8a;
            text-align: center;
        }

        table td {
            border: 1px solid #003f8a;
            text-align: center;
            padding: 12px 15px;
            font-size: 16px;
            background-color: #f2f7fc;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .add-row-button {
            background-color: #003f8a;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .add-row-button:hover {
            background-color: #0057b7;
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

        .delete-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .delete-button:hover {
            background-color: #ff1a1a;
            transform: translateY(-2px);
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
    </style>
</head>

<body>

    <?php

    if (isset($_GET['new'])) {
        if ($_GET['new'] == 'IS' || $_GET['new'] == 'CS') {
            $program_name = $_GET['new'];

            // جلب ID الخاص بالبرنامج
            $id_query = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
            $row = mysqli_fetch_assoc($id_query);
            $program_id = $row["id"];

            // معالجة البيانات عند الإرسال
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
                if (!empty($_POST['activities']) && !empty($_POST['timing']) && !empty($_POST['percentage'])) {

                    // تخزين البيانات المدخلة في $_SESSION
                    $_SESSION['student_assessment_activities_new'] = [
                        'activities' => $_POST['activities'],
                        'timing' => $_POST['timing'],
                        'percentage' => $_POST['percentage']
                    ];

                    // دمج البيانات في JSON
                    $data = [];
                    foreach ($_POST['activities'] as $index => $activity) {
                        $data[] = [
                            'activity' => $activity,
                            'timing' => $_POST['timing'][$index],
                            'percentage' => $_POST['percentage'][$index]
                        ];
                    }

                    // تحويل البيانات إلى JSON
                    $jsonData = json_encode($data);

                    // إعداد الاستعلام
                    $stmt = $conn->prepare("INSERT INTO student_assessment_activities (user_id, data, program_id) VALUES (?, ?, ?)");
                    $stmt->bind_param("isi", $user_id, $jsonData, $program_id);

                    // تنفيذ الاستعلام
                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                        header("location: Course_Spesification_Students_Assessment_Activities.php?new=" . $program_name);
                        exit;
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }
            }
    ?>

            <div class="container">
                <div class="sidebar">
                    <a href="Course_Specification.php?new=<?php echo $program_name ?>"><button><?= $translations['Courses'] ?></button></a>
                    <a href="Course_Specification_General_Info_About_The_Course.php?new=<?php echo $program_name ?>"><button><?= $translations['General Information About The Course'] ?></button></a>
                    <a href="Course_Specification_Course_Learning_Outcomes.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes'] ?></button></a>
                    <a href="Course_Specification_Course_Content.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Content'] ?></button></a>
                    <a href="Course_Spesification_Students_Assessment_Activities.php?new=<?php echo $program_name ?>"><button><?= $translations['Student Assessment Activity'] ?></button></a>
                    <a href="Course_Spesification_Learning_Resources_and_Facilities.php?new=<?php echo $program_name ?>"><button><?= $translations['Learning Resources And Facilities'] ?></button></a>
                    <a href="Course_Spesification_Assessment_Of_Course_Quality.php?new=<?php echo $program_name ?>"><button><?= $translations['Assessment Of Course Quality'] ?></button></a>
                    <a href="Course_Spesification_Specification_Approval.php?new=<?php echo $program_name ?>"><button><?= $translations['Specification Approval'] ?></button></a>
                </div>
                <div class="content">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Course Specification'] ?></h3>
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>
                    <form method="post" id="coursesForm">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }

                        // إذا كانت البيانات موجودة في الجلسة
                        if (isset($_SESSION['student_assessment_activities_new'])) {
                            $formData = $_SESSION['student_assessment_activities_new'];
                        } else {
                            $formData = [
                                'activities' => [],
                                'timing' => [],
                                'percentage' => []
                            ];
                        }
                        ?>

                        <div class="table-container">
                            <h2><?= $translations['Student Assessment Activities'] ?></h2>
                            <table id="Student-assessment">
                                <thead>
                                    <tr>
                                        <th><?= $translations['No'] ?></th>
                                        <th><?= $translations['Assessment Activities'] ?></th>
                                        <th><?= $translations['Assessment Timing (in week no)'] ?></th>
                                        <th><?= $translations['Percentage Of Total Assessment Score'] ?></th>
                                        <th><?= $translations['Action'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // التأكد من وجود بيانات في الجلسة قبل استخدامها
                                    $formData = isset($_SESSION['student_assessment_activities_new']) ? $_SESSION['student_assessment_activities_new'] : [
                                        'activities' => [],
                                        'timing' => [],
                                        'percentage' => []
                                    ];

                                    // حساب عدد الصفوف بناءً على عدد الأنشطة المدخلة
                                    $rowCount = max(count($formData['activities']), 1); // التأكد من وجود صف واحد على الأقل
                                    for ($i = 0; $i < $rowCount; $i++) {
                                    ?>
                                        <tr>
                                            <td><?php echo $i + 1; ?></td>
                                            <td><input type="text" name="activities[]" value="<?php echo isset($formData['activities'][$i]) ? $formData['activities'][$i] : ''; ?>" required /></td>
                                            <td><input type="text" name="timing[]" value="<?php echo isset($formData['timing'][$i]) ? $formData['timing'][$i] : ''; ?>" required /></td>
                                            <td><input type="number" name="percentage[]" value="<?php echo isset($formData['percentage'][$i]) ? $formData['percentage'][$i] : ''; ?>" min="0" max="100" required /></td>
                                            <td><button type="button" class="delete-button" onclick="deleteRow(this)"><?= $translations['Delete'] ?></button></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                            <button type="button" class="add-row-button" onclick="addRow('Student-assessment')"><?= $translations['Add Row'] ?></button>
                            <div class="navigation-buttons">
                                <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Learning_Resources_and_Facilities.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_Course_Content.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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


            <script>
                let counter = 2;

                function addRow(sectionId) {
                    const table = document.getElementById(sectionId).getElementsByTagName('tbody')[0];
                    const rowCount = table.rows.length;

                    if (rowCount >= 20) {
                        alert("You can only add up to 20 rows.");
                        return;
                    }

                    const newRow = table.insertRow();
                    const newRowIndex = rowCount + 1;

                    for (let i = 0; i < 5; i++) {
                        const newCell = newRow.insertCell(i);
                        if (i === 0) {
                            newCell.textContent = newRowIndex;
                        } else if (i === 4) {
                            const deleteButton = document.createElement('button');
                            deleteButton.className = 'delete-button';
                            deleteButton.textContent = '<?= $translations['Delete'] ?>';
                            deleteButton.onclick = () => deleteRow(deleteButton);
                            newCell.appendChild(deleteButton);
                        } else {
                            const input = document.createElement('input');
                            input.type = (i === 3) ? 'number' : 'text';
                            if (i === 3) {
                                input.setAttribute('min', '0');
                                input.setAttribute('max', '100');
                                input.required = true;
                            }

                            if (i === 1) input.setAttribute('name', 'activities[]');
                            if (i === 2) input.setAttribute('name', 'timing[]');
                            if (i === 3) input.setAttribute('name', 'percentage[]');
                            input.required = true;

                            newCell.appendChild(input);
                        }
                    }
                }

                function deleteRow(button) {
                    const row = button.parentNode.parentNode;
                    const table = row.parentNode;
                    table.removeChild(row);

                    // إعادة ترتيب الأرقام في الصفوف
                    Array.from(table.rows).forEach((row, index) => {
                        row.cells[0].textContent = index + 1;
                    });
                    counter = table.rows.length + 1;
                }
            </script>

    <?php
        }
    }
    ?>




    <?php

    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        // جلب ID الخاص بالبرنامج
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // التحقق إذا تم اختيار عنصر للتعديل
        $edit_item = $_POST['edit_item'] ?? '';
        $edit_data = [];

        // عندما يتم الضغط على Edit
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_row'])) {
            if (!empty($edit_item)) {
                $query = mysqli_query($conn, "SELECT * FROM student_assessment_activities WHERE id = '$edit_item' AND user_id = '$user_id'");
                $row = mysqli_fetch_assoc($query);
                if ($row) {
                    $edit_data = json_decode($row['data'], true); // تحويل JSON إلى مصفوفة

                    // تخزين الـ ID والبيانات في الجلسة لتحديثها لاحقاً
                    $_SESSION['student_assessment_activities_edit'] = [
                        'id' => $edit_item,
                        'activities' => array_column($edit_data, 'activity'),
                        'timing' => array_column($edit_data, 'timing'),
                        'percentage' => array_column($edit_data, 'percentage')
                    ];
                } else {
                    $_SESSION['message'] = 'No data found for the selected item.';
                }
            } else {
                $_SESSION['message'] = 'Please select an item to edit.';
            }
        }

        // معالجة التحديث
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            if (!empty($_POST['activities']) && !empty($_POST['timing']) && !empty($_POST['percentage'])) {
                $data = [];
                foreach ($_POST['activities'] as $index => $activity) {
                    $data[] = [
                        'activity' => $activity,
                        'timing' => $_POST['timing'][$index],
                        'percentage' => $_POST['percentage'][$index]
                    ];
                }
                $jsonData = json_encode($data);

                // تحديث السجل في قاعدة البيانات
                $stmt = $conn->prepare("UPDATE student_assessment_activities SET data = ? WHERE id = ? AND user_id = ?");
                $stmt->bind_param("sii", $jsonData, $_SESSION['student_assessment_activities_edit']['id'], $user_id);

                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Record updated successfully!';

                    // بعد التحديث، تحديث بيانات الجلسة مباشرة
                    $_SESSION['student_assessment_activities_edit']['activities'] = $_POST['activities'];
                    $_SESSION['student_assessment_activities_edit']['timing'] = $_POST['timing'];
                    $_SESSION['student_assessment_activities_edit']['percentage'] = $_POST['percentage'];

                    // إعادة تحميل الصفحة لعرض التحديثات
                    header("Location: " . $_SERVER['PHP_SELF'] . "?edit=" . $program_name);
                    exit;
                } else {
                    $_SESSION['message'] = 'Error occurred while updating data.';
                }
            } else {
                $_SESSION['message'] = 'Please fill in all fields.';
            }
        }
    ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= $translations['Edit Student Assessment Activities'] ?></title>
            <style>
                .table-container {
                    margin: 20px;
                }

                .add-row-button,
                .delete-button,
                .nav-button {
                    margin: 5px;
                    padding: 5px 10px;
                }
            </style>
        </head>

        <body>
            <div class="container">

                <div class="sidebar">
                    <a href="Course_Specification.php?edit=<?php echo $program_name ?>"><button><?= $translations['Courses'] ?></button></a>
                    <a href="Course_Specification_General_Info_About_The_Course.php?edit=<?php echo $program_name ?>"><button><?= $translations['General Information About The Course'] ?></button></a>
                    <a href="Course_Specification_Course_Learning_Outcomes.php?edit=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes'] ?></button></a>
                    <a href="Course_Specification_Course_Content.php?edit=<?php echo $program_name ?>"><button><?= $translations['Course Content'] ?></button></a>
                    <a href="Course_Spesification_Students_Assessment_Activities.php?edit=<?php echo $program_name ?>"><button><?= $translations['Student Assessment Activity'] ?></button></a>
                    <a href="Course_Spesification_Learning_Resources_and_Facilities.php?edit=<?php echo $program_name ?>"><button><?= $translations['Learning Resources And Facilities'] ?></button></a>
                    <a href="Course_Spesification_Assessment_Of_Course_Quality.php?edit=<?php echo $program_name ?>"><button><?= $translations['Assessment Of Course Quality'] ?></button></a>
                    <a href="Course_Spesification_Specification_Approval.php?edit=<?php echo $program_name ?>"><button><?= $translations['Specification Approval'] ?></button></a>
                </div>

                <div class="content">

                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Course Spesification'] ?></h3>
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>


                    <h2><?= $translations['Student Assessment Activities'] ?></h2>
                    <form method="post" id="coursesForm">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <?php
                        // استعلام لجلب جميع الخيارات
                        $query = "SELECT * FROM student_assessment_activities WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);
                        ?>

                        <label><?= $translations['Select an item to edit'] ?></label>
                        <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                            <option value=""><?= $translations['Select'] ?></option>
                            <?php
                            while ($row_edit = mysqli_fetch_assoc($result)) {

                                $data = json_decode($row_edit['data'], true);

                                // التحقق إذا كانت البيانات موجودة
                                if (!empty($data) && is_array($data)) {
                                    // أخذ أول عنصر من الكورسات
                                    $first_course = $data[0];

                                    // استخراج course_title لأول كورس
                                    $activity = $first_course['activity'] ?? 'N/A';


                                    $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                                    echo "<option value='{$row_edit['id']}' $selected>{$activity}</option>";
                                }
                            }
                            ?>
                        </select>
                        <button type="submit" name="edit_row" class="button"><?= $translations['Edit'] ?></button>

                        <div class="table-container">
                            <h2><?= $translations['Student Assessment Activities'] ?></h2>
                            <table id="Student-assessment">
                                <thead>
                                    <tr>
                                        <th><?= $translations['No'] ?></th>
                                        <th><?= $translations['Assessment Activities'] ?></th>
                                        <th><?= $translations['Assessment Timing (in week no)'] ?></th>
                                        <th><?= $translations['Percentage Of Total Assessment Score'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($_SESSION['student_assessment_activities_edit']['activities'])) : ?>
                                        <?php foreach ($_SESSION['student_assessment_activities_edit']['activities'] as $index => $data) : ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><input type="text" name="activities[]" value="<?php echo htmlspecialchars($data); ?>" /></td>
                                                <td><input type="text" name="timing[]" value="<?php echo htmlspecialchars($_SESSION['student_assessment_activities_edit']['timing'][$index]); ?>" /></td>
                                                <td><input type="number" name="percentage[]" min="0" max="100" value="<?php echo htmlspecialchars($_SESSION['student_assessment_activities_edit']['percentage'][$index]); ?>" /></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td>1</td>
                                            <td><input type="text" name="activities[]" /></td>
                                            <td><input type="text" name="timing[]" /></td>
                                            <td><input type="number" name="percentage[]" min="0" max="100" /></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div>

                                <button name="update" class="nav-button" type="submit"><?= $translations['Update'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Learning_Resources_and_Facilities.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_Course_Content.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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

        <?php } ?>


        </body>

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

        </html>