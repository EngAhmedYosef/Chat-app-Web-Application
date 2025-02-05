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
    <title><?= $translations['Course Report-Course Improvement Plan (if any)'] ?></title>
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
            height: 110vh;
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

        h2 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 0px;
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

        .form-container label {
            flex: 1 0 30%;
            margin-bottom: 5px;
        }

        table {
            width: 80%;
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
            width: 100%;
            border: none;
            outline: none;
            padding: 4px;
            font-size: 12px;
            box-sizing: border-box;
        }

        .footer-text {
            font-size: 14px;
            margin-top: 5px;
        }

        .print-button {
            background-color: #003f8a;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 5px;
            float: right;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;

        }

        .print-button:hover {
            background-color: #0057b7;
            transform: translateY(-3px);

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
            margin-top: 50px;
        }

        .nav-button {
            background-color: #003f8a;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 5px;
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
                // Get data from the form
                $recommendations = $_POST['recommendation'];
                $actions = $_POST['action'];
                $needed_supports = $_POST['needed_support'];

                // Store form data in session to preserve it
                $_SESSION['cource_report_improvment_plane_new'] = [
                    'recommendation' => $recommendations,
                    'action' => $actions,
                    'needed_support' => $needed_supports
                ];

                // Process the data and save to database
                $data = [];
                for ($i = 0; $i < count($recommendations); $i++) {
                    $recommendation = mysqli_real_escape_string($conn, $recommendations[$i]);
                    $action = mysqli_real_escape_string($conn, $actions[$i]);
                    $needed_support = mysqli_real_escape_string($conn, $needed_supports[$i]);

                    if (!empty($recommendation) || !empty($action) || !empty($needed_support)) {
                        $data[] = [
                            'recommendation' => $recommendation,
                            'action' => $action,
                            'needed_support' => $needed_support
                        ];
                    }
                }

                // If valid data, insert into the database
                if (!empty($data)) {
                    $data_json = mysqli_real_escape_string($conn, json_encode($data));

                    $sql = "INSERT INTO cource_improvment_plane (user_id, program_id, data) 
                    VALUES ('$user_id', '$program_id', '$data_json')";

                    if (!$conn->query($sql)) {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    } else {
                        $_SESSION['message'] = 'Records created successfully!';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("Location: Course_Report_Course_Improvement_Plan_if_any.php?new=" . $program_name);
                exit();
            }

            if (isset($_POST['back'])) {
                header("location: Course_Report_Topics_not_covered.php?new=" . $program_name);
                exit;
            }
            if (isset($_POST["homepage"])) {
                $user_id = $_SESSION['user_id'];
                $lang = $_SESSION['lang'];

                $program_repeat = $_SESSION['program_repeat'];
                $department_repeat =  $_SESSION['department_repeat'];
                $college_repeat = $_SESSION['college_repeat'];
                $institution_repeat = $_SESSION['institution_repeat'];

                
                // unset($_SESSION["cource_report_reports_new"]);
                // unset($_SESSION["cource_report_results_new"]);
                // unset($_SESSION["cource_report_clos_new"]);
                // unset($_SESSION["cource_report_topic_not_covered_new"]);
                // unset($_SESSION["cource_report_improvment_plane_new"]);

                session_unset();

                $_SESSION['program_repeat']  = $program_repeat;
                $_SESSION['department_repeat'] = $department_repeat;
                $_SESSION['college_repeat'] = $college_repeat;
                $_SESSION['institution_repeat'] = $institution_repeat;

                $_SESSION['user_id'] = $user_id;
                $_SESSION['lang'] = $lang;


                header(header: "location: HomePage.php");
                exit;
            }

            // Load the form data from session if available
            $cource_report_improvment_plane_new = isset($_SESSION['cource_report_improvment_plane_new']) ? $_SESSION['cource_report_improvment_plane_new'] : ['recommendation' => ['', '', ''], 'action' => ['', '', ''], 'needed_support' => ['', '', '']];
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
                        <h2><?= $translations['Course Improvement Plan (if any)'] ?></h2>
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
                                        <th><?= $translations['Recommendations'] ?></th>
                                        <th><?= $translations['Actions'] ?></th>
                                        <th><?= $translations['Needed Support'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Loop through the form data and populate the input fields
                                    for ($i = 0; $i < 3; $i++) {
                                        echo '<tr>';
                                        echo '<td><input name="recommendation[]" type="text" value="' . htmlspecialchars($cource_report_improvment_plane_new['recommendation'][$i]) . '" placeholder="' . ($i + 1) . '." ></td>';
                                        echo '<td><input name="action[]" type="text" value="' . htmlspecialchars($cource_report_improvment_plane_new['action'][$i]) . '" placeholder="' .  $translations['Enter action'] . '."></td>';
                                        echo '<td><input name="needed_support[]" type="text" value="' . htmlspecialchars($cource_report_improvment_plane_new['needed_support'][$i]) . '" placeholder="' .  $translations['Enter needed support'] . '."></td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="footer-text">
                                <?= $translations['Improvement plans should be discussed at the department council and included in the Annual Program Report'] ?>.
                            </div>
                            <button name="print" class="print-button"><?= $translations['Print'] ?></button>

                            <div class="navigation-buttons">
                                <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Topics_not_covered.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                                <button name="homepage" type="submit" class="nav-button"><?= $translations['Home Page'] ?></button>
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
    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        // استعلام للحصول على ID البرنامج
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // التحقق من الضغط على زر Edit واختيار ID لتعديل البيانات
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_row'])) {
            $edit_item = $_POST['edit_item'] ?? '';

            // إذا تم اختيار عنصر لتعديله، استرجاع بياناته من قاعدة البيانات
            if (!empty($edit_item)) {
                $query = mysqli_query($conn, "SELECT * FROM cource_improvment_plane WHERE id = '$edit_item' AND user_id = '$user_id'");
                $row = mysqli_fetch_assoc($query);

                // حفظ البيانات في الجلسة لتعديلها لاحقًا
                $_SESSION['cource_report_improvment_plane_edit'] = [
                    'id' => $edit_item,
                    'recommendations' => json_decode($row['data'], true) ?? []
                ];
            }
        }

        // عند الضغط على زر "Save" لتحديث البيانات
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $recommendations = $_POST['recommendation'];
            $actions = $_POST['action'];
            $needed_supports = $_POST['needed_support'];

            $data = [];
            for ($i = 0; $i < count($recommendations); $i++) {
                $recommendation = mysqli_real_escape_string($conn, $recommendations[$i]);
                $action = mysqli_real_escape_string($conn, $actions[$i]);
                $needed_support = mysqli_real_escape_string($conn, $needed_supports[$i]);

                if (!empty($recommendation) || !empty($action) || !empty($needed_support)) {
                    $data[] = [
                        'recommendation' => $recommendation,
                        'action' => $action,
                        'needed_support' => $needed_support
                    ];
                }
            }

            if (!empty($data)) {
                $data_json = mysqli_real_escape_string($conn, json_encode($data));
                $edit_item = $_SESSION['cource_report_improvment_plane_edit']['id']; // استرجاع الـ ID من الجلسة

                if (!empty($edit_item)) {
                    // تحديث السجل باستخدام الـ ID المخزن في الجلسة
                    $sql = "UPDATE cource_improvment_plane SET data = '$data_json' WHERE id = '$edit_item' AND user_id = '$user_id'";
                    $message = "Record updated successfully!";
                }

                if ($conn->query($sql)) {
                    $_SESSION['cource_report_improvment_plane_edit']['recommendations'] = $data; // تحديث البيانات في الجلسة
                    $_SESSION['message'] = $message;
                } else {
                    $_SESSION['message'] = 'Error occurred while saving data.';
                }
            } else {
                $_SESSION['message'] = 'Please fill in all fields.';
            }

            // إعادة توجيه الصفحة بعد التحديث
            header("Location: Course_Report_Course_Improvement_Plan_if_any.php?edit=" . $program_name);
            exit();
        }

        // عند الضغط على زر "Back"
        if (isset($_POST['back'])) {
            header("location: Course_Report_Topics_not_covered.php?edit=" . $program_name);
            exit;
        }

        if (isset($_POST["homepage"])) {
            $user_id = $_SESSION['user_id'];

            // unset($_SESSION["cource_report_reports_edit"]);
            // unset($_SESSION["cource_report_results_edit"]);
            // unset($_SESSION["cource_report_clos_edit"]);
            // unset($_SESSION["cource_report_topic_not_covered_edit"]);
            // unset($_SESSION["cource_report_improvment_plane_edit"]);

            session_unset();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['lang'] = $lang;

            header("location: HomePage.php");
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
                    <h2><?= $translations['Course Improvement Plan (if any)'] ?></h2>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    }
                    ?>
                    <form method="post" id="coursesForm">
                        <label><?= $translations['Select an item to edit'] ?></label>
                        <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                            <option value=""><?= $translations['Select'] ?></option>
                            <?php
                            // عرض الخيارات
                            $query = "SELECT * FROM cource_improvment_plane WHERE program_id = '$program_id' AND user_id = '$user_id'";
                            $result = mysqli_query($conn, $query);
                            while ($row_edit = mysqli_fetch_assoc($result)) {

                                $data = json_decode($row_edit['data'], true);

                                // التحقق إذا كانت البيانات موجودة
                                if (!empty($data) && is_array($data)) {
                                    // أخذ أول عنصر من الكورسات
                                    $first_course = $data[0];

                                    // استخراج course_title لأول كورس
                                    $recommendation = $first_course['recommendation'] ?? 'N/A';


                                    $selected = (isset($_SESSION['cource_report_improvment_plane_edit']['id']) && $row_edit['id'] == $_SESSION['cource_report_improvment_plane_edit']['id']) ? 'selected' : '';
                                    echo "<option value='{$row_edit['id']}' $selected>{$recommendation}</option>";
                                }
                            }
                            ?>
                        </select>
                        <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>

                        <input type="hidden" name="id" value="<?= htmlspecialchars($_SESSION['cource_report_improvment_plane_edit']['id'] ?? '') ?>">

                        <table>
                            <thead>
                                <tr>
                                    <th><?= $translations['Recommendations'] ?></th>
                                    <th><?= $translations['Actions'] ?></th>
                                    <th><?= $translations['Needed Support'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $existing_data = $_SESSION['cource_report_improvment_plane_edit']['recommendations'] ?? [];
                                for ($i = 0; $i < 3; $i++) {
                                    $rec = $existing_data[$i]['recommendation'] ?? '';
                                    $act = $existing_data[$i]['action'] ?? '';
                                    $sup = $existing_data[$i]['needed_support'] ?? '';
                                ?>
                                    <tr>
                                        <td><input name="recommendation[]" type="text" value="<?= htmlspecialchars($rec) ?>"></td>
                                        <td><input name="action[]" type="text" value="<?= htmlspecialchars($act) ?>"></td>
                                        <td><input name="needed_support[]" type="text" value="<?= htmlspecialchars($sup) ?>"></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <button name="print" class="print-button"><?= $translations['Print'] ?></button>

                        <div class="footer-text">
                            <?= $translations['Improvement plans should be discussed at the department council and included in the Annual Program Report'] ?>.

                        </div>

                        <div class="navigation-buttons">
                            <button name="update" class="nav-button" type="submit"><?= $translations['Update'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Topics_not_covered.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            <button name="homepage" type="submit" class="nav-button"><?= $translations['Home Page'] ?></button>

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