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
    <title><?= $translations['Program Statistics'] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e5e9ec;
            /* لون الخلفية العام */
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

        .sidebar button:hover,
        .sidebar button.active {
            background-color: #0073e6;
            transform: translateY(-3px);
        }

        .main {
            flex: 1;
            padding: 20px;
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
        }

        .header h3 {
            color: #003f8a;
            font-size: 24px;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        }

        .form-container {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-container .form-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }



        .next-button {
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

        .next-button:hover {
            background: #0057b7;
        }

        .back-button {
            display: inline-block;
            background: #003f8a;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            margin-top: 20px;
            margin-right: 10px;
        }

        .back-button:hover {
            background: #0057b7;
        }

        .title-logo {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            /* محاذاة النصوص إلى اليسار */
            color: #003f8a;
            /* لون النص */
        }

        .title-logo h1 {
            margin: 10;
            font-size: 24px;
            font-weight: bold;
        }

        .title-logo h2 {
            margin: 0;
            font-size: 16px;
            font-weight: normal;
            color: #6a7a8c;
            /* لون النص الفرعي */
        }

        .logo {
            width: 60px;
            /* حجم الشعار */
            height: 60px;
            border-radius: 50%;
            /* إذا أردت جعله دائريًا */
        }

        .logout-button {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #003f8a;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
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

        .form-group h2 {
            margin-bottom: 20px;
            /* مسافة بين المجموعات */
        }

        .form-container label {
            flex: 1 0 30%;
            margin-bottom: 5px;
        }

        .form-container input {
            flex: 2 0 60%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .main {
            width: 80%;
            padding: 20px;
            background: linear-gradient(to top, #d7dce9, #f0f4fa);
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
                $enrolled = $_POST['enrolled'] ?? '';
                $started = $_POST['started'] ?? '';
                $completed = $_POST['completed'] ?? '';

                // تخزين البيانات في الجلسة
                $_SESSION['statistics_new'] = [
                    'enrolled' => $enrolled,
                    'started' => $started,
                    'completed' => $completed
                ];

                if (!empty($enrolled) && !empty($started) && !empty($completed)) {
                    $query = "INSERT INTO program_statistics (user_id, enrolled, started, completed, program_id)
                          VALUES ('$user_id', '$enrolled', '$started', '$completed', '$program_id')";

                    if (mysqli_query($conn, $query)) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("location: ProgramStatistics.php?new=" . $program_name);
                exit;
            }

            if (isset($_POST["next"])) {
                header("location: PLOs.php?new=" . $program_name);
                exit;
            }
    ?>

            <div class="container">
                <div class="sidebar">

                    <a href="Annual_Program_Report_Programs.php?new=<?php echo $program_name ?>"><button><?= $translations['Programs'] ?></button></a>
                    <a href="ProgramStatistics.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Statistics'] ?></button></a>
                    <a href="PLOs.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Assessment'] ?></button></a>
                    <a href="Program_KPIs_Table.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Key Performance Indicators (KPIs)'] ?></button></a>
                    <a href="Annual_Program_Report_Challenges&Difficulties.php?new=<?php echo $program_name ?>"><button><?= $translations['Challenges and Difficulties'] ?></button></a>
                    <a href="Annual_Program_Report_Program_Devalopment_Plan.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Development Plan'] ?></button></a>
                    <a href="Annual_Program_Report_Approval_Of_Annual_Program_Report.php?new=<?php echo $program_name ?>"><button><?= $translations['Approval of Annual Program Report'] ?></button></a>



                </div>

                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Annual Program Report'] ?></h3>

                        <a href="logout.php" class="button"><?= $translations['Log out'] ?></a>
                    </div>

                    <form id="coursesForm" method="post">
                        <div class="form-container">
                            <?php

                            if (isset($_SESSION['message'])) {
                                echo $translations[$_SESSION['message']];
                                unset($_SESSION['message']);
                            }

                            $enrolled = $_SESSION['statistics_new']['enrolled'] ?? '';
                            $started = $_SESSION['statistics_new']['started'] ?? '';
                            $completed = $_SESSION['statistics_new']['completed'] ?? '';
                            ?>
                            <h2><?= $translations['Statistics Form'] ?></h2>
                            <div class="form-group">
                                <label for="enrolled"><?= $translations['Number of students enrolled in the program'] ?>:</label>
                                <input name="enrolled" type="number" id="enrolled" placeholder="<?= $translations['Enter number of students enrolled'] ?>" value="<?php echo htmlspecialchars($enrolled); ?>">

                                <label for="started"><?= $translations['Number of students who started the program (in reporting year)'] ?>:</label>
                                <input name="started" type="number" id="started" placeholder="<?= $translations['Enter number of students started'] ?>" value="<?php echo htmlspecialchars($started); ?>">

                                <label for="completed"><?= $translations['Number of students who completed the program'] ?>:</label>
                                <input name="completed" type="number" id="completed" placeholder="<?= $translations['Enter number of students completed'] ?>" value="<?php echo htmlspecialchars($completed); ?>">
                            </div>

                            <button name="save" class="next-button" type="submit"><?= $translations['Save'] ?></button>
                            <button type="button" class="next-button" onclick="handleNavigation('PLOs.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="button" class="next-button" onclick="handleNavigation('Annual_Program_Report_Programs.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>

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

        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // التحقق من وجود اختيار للتعديل
        $edit_item = $_POST['edit_item'] ?? ($_SESSION['statistics_edit']['id'] ?? '');

        // جلب بيانات السجل المطلوب إذا كان id موجود
        if ($edit_item) {
            $query = mysqli_query($conn, "SELECT * FROM program_statistics WHERE id = '$edit_item' AND user_id = '$user_id'");
            $row = mysqli_fetch_assoc($query);

            // تخزين البيانات في الجلسة لعرضها لاحقًا
            if ($row) {
                $_SESSION['statistics_edit'] = [
                    'id' => $row['id'],
                    'enrolled' => $row['enrolled'],
                    'started' => $row['started'],
                    'completed' => $row['completed'],
                ];
            }
        }

        // تحديث البيانات
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $enrolled = $_POST['enrolled'] ?? $_SESSION['statistics_edit']['enrolled'] ?? '';
            $started = $_POST['started'] ?? $_SESSION['statistics_edit']['started'] ?? '';
            $completed = $_POST['completed'] ?? $_SESSION['statistics_edit']['completed'] ?? '';
            $update_id = $_SESSION['statistics_edit']['id'] ?? '';

            if (!empty($enrolled) && !empty($started) && !empty($completed) && !empty($update_id)) {
                $update_query = "UPDATE program_statistics 
                             SET enrolled = '$enrolled', started = '$started', completed = '$completed' 
                             WHERE id = '$update_id'";

                if (mysqli_query($conn, $update_query)) {
                    $_SESSION['message'] = 'Records updated successfully!';
                    // تحديث بيانات الجلسة بعد الحفظ
                    $_SESSION['statistics_edit']['enrolled'] = $enrolled;
                    $_SESSION['statistics_edit']['started'] = $started;
                    $_SESSION['statistics_edit']['completed'] = $completed;
                } else {
                    $_SESSION['message'] = 'Error occurred while updating data.';
                }
            } else {
                $_SESSION['message'] = 'Please All Fields Are Required!';
            }

            header("location: ProgramStatistics.php?edit=" . $program_name);
            exit;
        }

        // التنقل إلى الصفحة التالية
        if (isset($_POST["next"])) {
            header("location: PLOs.php?edit=" . $program_name);
            exit;
        }
    ?>
        <div class="container">
            <div class="sidebar">
                <a href="Annual_Program_Report_Programs.php?edit=<?php echo $program_name ?>"><button><?= $translations['Programs'] ?></button></a>
                <a href="ProgramStatistics.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Statistics'] ?></button></a>
                <a href="PLOs.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Assessment'] ?></button></a>
                <a href="Program_KPIs_Table.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Key Performance Indicators (KPIs)'] ?></button></a>
                <a href="Annual_Program_Report_Challenges&Difficulties.php?edit=<?php echo $program_name ?>"><button><?= $translations['Challenges and Difficulties'] ?></button></a>
                <a href="Annual_Program_Report_Program_Devalopment_Plan.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Development Plan'] ?></button></a>
                <a href="Annual_Program_Report_Approval_Of_Annual_Program_Report.php?edit=<?php echo $program_name ?>"><button><?= $translations['Approval of Annual Program Report'] ?></button></a>
            </div>

            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <h3><?= $translations['Annual Program Report'] ?></h3>

                    <a href="logout.php" class="button"><?= $translations['Log out'] ?></a>
                </div>

                <form id="coursesForm" method="post">
                    <div class="form-container">
                        <?php
                        // عرض الرسائل
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }

                        // استعلام لجلب جميع الخيارات
                        $query = "SELECT id FROM program_statistics WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);

                        // استرجاع القيم المخزنة في الجلسة
                        $enrolled = $_SESSION['statistics_edit']['enrolled'] ?? '';
                        $started = $_SESSION['statistics_edit']['started'] ?? '';
                        $completed = $_SESSION['statistics_edit']['completed'] ?? '';
                        $current_id = $_SESSION['statistics_edit']['id'] ?? '';
                        ?>

                        <label><?= $translations['Select an item to edit'] ?></label>
                        <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                            <option value=""><?= $translations['Select'] ?></option>
                            <?php
                            // عرض الخيارات
                            while ($row_edit = mysqli_fetch_assoc($result)) {
                                $selected = ($row_edit['id'] == $current_id) ? 'selected' : '';
                                echo "<option value='{$row_edit['id']}' $selected>{$row_edit['id']}</option>";
                            }
                            ?>
                        </select>

                        <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>

                        <h2><?= $translations['Statistics Form'] ?></h2>
                        <div class="form-group">
                            <label for="enrolled"><?= $translations['Number of students enrolled in the program'] ?>:</label>
                            <input value="<?= htmlspecialchars($enrolled) ?>" name="enrolled" type="number" id="enrolled">

                            <label for="started"><?= $translations['Number of students who started the program (in reporting year)'] ?>:</label>
                            <input value="<?= htmlspecialchars($started) ?>" name="started" type="number" id="started">

                            <label for="completed"><?= $translations['Number of students who completed the program'] ?>:</label>
                            <input value="<?= htmlspecialchars($completed) ?>" name="completed" type="number" id="completed">
                        </div>

                        <button name="update" class="next-button" type="submit"><?= $translations['Update'] ?></button>
                        <button type="button" class="next-button" onclick="handleNavigation('PLOs.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                        <button type="button" class="next-button" onclick="handleNavigation('HomePage.php')"><?= $translations['Back'] ?></button>
                    </div>
                </form>
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