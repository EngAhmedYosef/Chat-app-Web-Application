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
    <title><?= $translations['Annual Program Report-Program Assessment-6.Other Evaluation']?></title>
    <style>
        /* Reset & General Styling 
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }*/
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

        /* Container Layout */
        .container {
            display: flex;
            flex-direction: row;
            height: 250vh;
        }

        /* Sidebar Styling */
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

        .sidebar button:hover,
        .sidebar button.active {
            background-color: #0073e6;
            transform: translateY(-3px);
        }

        /* Main Content */
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

        .table-container {
            width: 100%;
            margin-top: 30px;
            padding: 10px;
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }


        .table-container h2 {
            margin-bottom: 20px;
        }

        .table-container .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
            /* مسافة بين المجموعات */
        }

        .table-container label {
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

            $id_query = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
            $row = mysqli_fetch_assoc($id_query);
            $program_id = $row["id"];

            // التحقق من الطلب
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
                // الحصول على القيم المدخلة
                $strength_1 = $_POST['strength_1'] ?? null;
                $strength_2 = $_POST['strength_2'] ?? null;
                $improvement_1 = $_POST['improvement_1'] ?? null;
                $improvement_2 = $_POST['improvement_2'] ?? null;
                $suggestion_1 = $_POST['suggestion_1'] ?? null;
                $suggestion_2 = $_POST['suggestion_2'] ?? null;

                // حفظ البيانات في الـ session
                $_SESSION['other_evaluation_new'] = [
                    'strength_1' => $strength_1,
                    'strength_2' => $strength_2,
                    'improvement_1' => $improvement_1,
                    'improvement_2' => $improvement_2,
                    'suggestion_1' => $suggestion_1,
                    'suggestion_2' => $suggestion_2
                ];

                // التحقق من ملء جميع الحقول
                if ($strength_1 && $strength_2 && $improvement_1 && $improvement_2 && $suggestion_1 && $suggestion_2) {
                    // إدخال البيانات في قاعدة البيانات
                    $stmt = $conn->prepare("INSERT INTO evaluator_review (user_id, strength_1, strength_2, improvement_1, improvement_2, suggestion_1, suggestion_2, program_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("issssssi", $user_id, $strength_1, $strength_2, $improvement_1, $improvement_2, $suggestion_1, $suggestion_2, $program_id);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("location: Annual_Program_Report_Program_Assessment_Other_Evaluation.php?new=" . $program_name);
                exit;
            }

    ?>

            <div class="container">
                <!-- Sidebar -->
                <div class="sidebar">
                <a href="PLOs.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Program Assessment']?></button>
                    </a>
                    <a href="PLOs.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Program Learning Outcomes']?></button>
                    </a>
                    <a href="StudentEv.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Students Evaluation Of Courses']?></button>
                    </a>
                    <a href="Students_Evaluation_of_progrm_Q.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Students Evaluation Of Program Quality']?></button>
                    </a>
                    <a href="Scientific_research_and_innovation.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Scientific Research And Innovation']?></button>
                    </a>
                    <a href="Annual_Program_Report_Program_Assessment_Community_Partnership.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Community Partnership']?></button>
                    </a>
                    <a href="Annual_Program_Report_Program_Assessment_Other_Evaluation.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Other Evaluation']?></button>
                    </a>
                </div>

                <!-- Main Content -->
                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <div class="header-text">
                            <h3><?= $translations['Annual Program Report']?></h3>
                            <p><?= $translations['Program Assessment']?></p>
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

                        <div class="table-container">
                            <h2>6.<?= $translations['Other Evaluation(if any)']?></h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="2"><?= $translations['Summary Of Evaluator Review']?></th>
                                        <th><?= $translations['Program Response']?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="label"><?= $translations['Strengths']?>:</td>
                                        <td colspan="2">
                                            <input type="text" name="strength_1" value="<?= $_SESSION['other_evaluation_new']['strength_1'] ?? '' ?>" required>
                                            <input type="text" name="strength_2" value="<?= $_SESSION['other_evaluation_new']['strength_2'] ?? '' ?>" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label"><?= $translations['Areas of Improvement']?>:</td>
                                        <td colspan="2">
                                            <input type="text" name="improvement_1" value="<?= $_SESSION['other_evaluation_new']['improvement_1'] ?? '' ?>" required>
                                            <input type="text" name="improvement_2" value="<?= $_SESSION['other_evaluation_new']['improvement_2'] ?? '' ?>" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label"><?= $translations['Suggestions for Improvement']?>:</td>
                                        <td colspan="2">
                                            <input type="text" name="suggestion_1" value="<?= $_SESSION['other_evaluation_new']['suggestion_1'] ?? '' ?>" required>
                                            <input type="text" name="suggestion_2" value="<?= $_SESSION['other_evaluation_new']['suggestion_2'] ?? '' ?>" required>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="navigation-buttons">
                                <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Program_Assessment_Community_Partnership.php?new=<?= $program_name ?>')"><?= $translations['Back']?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_KPIs_Table.php?new=<?= $program_name ?>')"><?= $translations['Next']?></button>
                                <button type="submit" name="save" class="nav-button"><?= $translations['Save']?></button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
                <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                    <p><?= $translations['You have unsaved data. Do you want to leave without saving?']?></p>
                    <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Leave']?></button>
                    <button onclick="hideCustomModal()" style="background: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Stay']?></button>
                </div>

    <?php }
    } ?>







    <?php
    if (isset($_POST['edit_item'])) {
        // تخزين الـ id المختار في الـ session
        $_SESSION['selected_id'] = $_POST['edit_item'];
    }

    // التحقق إذا كانت الجلسة تحتوي على id
    $edit_item = $_SESSION['selected_id'] ?? ''; // إذا كان يوجد id في الجلسة استخدمه

    // في حالة الـ edit أو التعديل
    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // جلب بيانات الـ id المختار
        $row = [];
        if ($edit_item) {
            // استعلام لجلب بيانات العنصر المختار
            $query = mysqli_query($conn, "SELECT * FROM evaluator_review WHERE id = '$edit_item' AND user_id = '$user_id'");
            if ($query) {
                $row = mysqli_fetch_assoc($query);
            }
        }

        // تنفيذ التحديث عند الضغط على زر Update
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
            $strength_1 = $_POST['strength_1'] ?? null;
            $strength_2 = $_POST['strength_2'] ?? null;
            $improvement_1 = $_POST['improvement_1'] ?? null;
            $improvement_2 = $_POST['improvement_2'] ?? null;
            $suggestion_1 = $_POST['suggestion_1'] ?? null;
            $suggestion_2 = $_POST['suggestion_2'] ?? null;

            if ($strength_1 && $strength_2 && $improvement_1 && $improvement_2 && $suggestion_1 && $suggestion_2) {
                if ($edit_item) {
                    // تحديث البيانات إذا كان العنصر موجودًا
                    $stmt = $conn->prepare("UPDATE evaluator_review SET strength_1 = ?, strength_2 = ?, improvement_1 = ?, improvement_2 = ?, suggestion_1 = ?, suggestion_2 = ? WHERE id = ? AND user_id = ?");
                    $stmt->bind_param("ssssssii", $strength_1, $strength_2, $improvement_1, $improvement_2, $suggestion_1, $suggestion_2, $edit_item, $user_id);
                } else {
                    // إدخال البيانات الجديدة إذا لم يكن هناك عنصر محدد
                    $stmt = $conn->prepare("INSERT INTO evaluator_review (user_id, strength_1, strength_2, improvement_1, improvement_2, suggestion_1, suggestion_2, program_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("issssssi", $user_id, $strength_1, $strength_2, $improvement_1, $improvement_2, $suggestion_1, $suggestion_2, $program_id);
                }

                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Records updated successfully!';
                    // تحديث الـ session بالبيانات الجديدة
                    $_SESSION['other_evaluation_edit'] = [
                        'strength_1' => $strength_1,
                        'strength_2' => $strength_2,
                        'improvement_1' => $improvement_1,
                        'improvement_2' => $improvement_2,
                        'suggestion_1' => $suggestion_1,
                        'suggestion_2' => $suggestion_2,
                        'edit_item' => $edit_item
                    ];
                } else {
                    $_SESSION['message'] = 'Error occurred while updating data.';
                }
            } else {
                $_SESSION['message'] = 'Please fill all inputs.';
            }

            header("location: Annual_Program_Report_Program_Assessment_Other_Evaluation.php?edit=" . $program_name);
            exit;
        }
    ?>

        <div class="container">
            <div class="sidebar">
            <a href="PLOs.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Program Assessment']?></button>
                    </a>
                    <a href="PLOs.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Program Learning Outcomes']?></button>
                    </a>
                    <a href="StudentEv.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Students Evaluation Of Courses']?></button>
                    </a>
                    <a href="Students_Evaluation_of_progrm_Q.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Students Evaluation Of Program Quality']?></button>
                    </a>
                    <a href="Scientific_research_and_innovation.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Scientific Research And Innovation']?></button>
                    </a>
                    <a href="Annual_Program_Report_Program_Assessment_Community_Partnership.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Community Partnership']?></button>
                    </a>
                    <a href="Annual_Program_Report_Program_Assessment_Other_Evaluation.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Other Evaluation']?></button>
                    </a>
            </div>

            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <div class="header-text">
                        <h3><?= $translations['Annual Program Report']?></h3>
                        <p><?= $translations['Program Assessment']?></p>
                    </div>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>

                <form method="post" id="coursesForm">
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="message">
                            <?php
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <label><?= $translations['Select an item to edit']?>:</label>
                    <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                        <option value=""><?= $translations['Select']?></option>
                        <?php
                        // استعلام لاستخراج الـ items الموجودة في البرنامج
                        $query = "SELECT * FROM evaluator_review WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);
                        while ($row_edit = mysqli_fetch_assoc($result)):
                        ?>
                            <option value="<?php echo $row_edit['id']; ?>" <?php echo ($row_edit['id'] == $edit_item) ? 'selected' : ''; ?>>
                                <?php echo $row_edit['strength_1']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <button type="submit" class="button" name="edit_row"><?= $translations['Edit']?></button>

                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($edit_item); ?>">

                    <div class="table-container">
                    <h2>6.<?= $translations['Other Evaluation(if any)']?></h2>
                    <table>
                            <thead>
                                <tr>
                                    <th colspan="2"><?= $translations['Summary Of Evaluator Review']?></th>
                                    <th><?= $translations['Program Response']?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="label"><?= $translations['Strengths']?>:</td>
                                    <td colspan="2">
                                        <input type="text" name="strength_1" value="<?php echo $row['strength_1'] ?? ''; ?>">
                                        <input type="text" name="strength_2" value="<?php echo $row['strength_2'] ?? ''; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><?= $translations['Areas of Improvement']?>:</td>
                                    <td colspan="2">
                                        <input type="text" name="improvement_1" value="<?php echo $row['improvement_1'] ?? ''; ?>">
                                        <input type="text" name="improvement_2" value="<?php echo $row['improvement_2'] ?? ''; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><?= $translations['Suggestions for Improvement']?>:</td>
                                    <td colspan="2">
                                        <input type="text" name="suggestion_1" value="<?php echo $row['suggestion_1'] ?? ''; ?>">
                                        <input type="text" name="suggestion_2" value="<?php echo $row['suggestion_2'] ?? ''; ?>">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="navigation-buttons">
                            <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Program_Assessment_Community_Partnership.php?edit=<?= $program_name ?>')"><?= $translations['Back']?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_KPIs_Table.php?edit=<?= $program_name ?>')"><?= $translations['Next']?></button>
                            <button type="submit" name="update" class="nav-button"><?= $translations['Update']?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
                <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                    <p><?= $translations['You have unsaved data. Do you want to leave without saving?']?></p>
                    <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Leave']?></button>
                    <button onclick="hideCustomModal()" style="background: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Stay']?></button>
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