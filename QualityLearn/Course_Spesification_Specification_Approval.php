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
    <title><?= $translations['Approval of Annual Program Report']?></title>
    <style>
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
                // الحصول على القيم المدخلة
                $council_committee = $_POST['council_committee'];
                $reference_no = $_POST['reference_no'];
                $date = $_POST['date'];

                // التحقق من أن جميع الحقول تم تعبئتها
                if (!empty($council_committee) && !empty($reference_no) && !empty($date)) {

                    // التحقق من الاتصال
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // إدخال البيانات في قاعدة البيانات
                    $sql = "INSERT INTO cource_specification_approval (user_id, council_committee, reference_no, date, program_id) 
            VALUES ('$user_id', '$council_committee', '$reference_no', '$date', '$program_id')";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['message'] = 'Records Created successfully!';
                        // تخزين البيانات المدخلة في الجلسة
                        $_SESSION['annual_approval_new'] = $_POST;
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }
                header("location: Course_Spesification_Specification_Approval.php?new=" . $program_name);
                exit;
            }

            if (isset($_POST["homepage"])) {
                $user_id = $_SESSION['user_id'];
                $lang = $_SESSION['lang'];

                $program_repeat = $_SESSION['program_repeat'];
                $department_repeat =  $_SESSION['department_repeat'];
                $college_repeat = $_SESSION['college_repeat'];
                $institution_repeat = $_SESSION['institution_repeat'];


                // unset($_SESSION["course_specification_new"]);
                // unset($_SESSION["general_information_new"]);
                // unset($_SESSION["course_content_new"]);
                // unset($_SESSION["student_assessment_activities_new"]);
                // unset($_SESSION["specification_learning_resources_new"]);
                // unset($_SESSION["specification_course_quality_new"]);
                // unset($_SESSION["specification_approval_new"]);
                // unset($_SESSION["clos_new"]);
                // unset($_SESSION["course_specification_general_info_new"]);

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


                        <div id="programs" class="form-container">
                            <h2><?= $translations['Specification Approval']?></h2>
                            <table>
                                <tr>
                                    <th><?= $translations['COUNCIL / COMMITTEE']?></th>
                                    <td><input type="text" name="council_committee" value="<?php echo isset($_SESSION['annual_approval_new']['council_committee']) ? $_SESSION['annual_approval_new']['council_committee'] : ''; ?>"></td>
                                </tr>
                                <tr>
                                    <th><?= $translations['REFERENCE NO']?>.</th>
                                    <td><input type="text" name="reference_no" value="<?php echo isset($_SESSION['annual_approval_new']['reference_no']) ? $_SESSION['annual_approval_new']['reference_no'] : ''; ?>"></td>
                                </tr>
                                <tr>
                                    <th><?= $translations['DATE']?>:</th>
                                    <td><input type="date" name="date" value="<?php echo isset($_SESSION['annual_approval_new']['date']) ? $_SESSION['annual_approval_new']['date'] : ''; ?>"></td>
                                </tr>
                            </table>

                            <button class="nav-button" style="position: relative; top: -1px; left: 85%;"><?= $translations['Print']?></button>
                            <div class="navigation-buttons">
                                <button type="submit" name="save" class="nav-button"><?= $translations['Save']?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Assessment_Of_Course_Quality.php?new=<?= $program_name ?>')"><?= $translations['Back']?></button>
                                <button type="submit" name="homepage" class="nav-button"><?= $translations['Home Page']?></button>
                            </div>
                        </div>
                    </form>

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

                $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
                $row_program = mysqli_fetch_assoc($query_program);
                $program_id = $row_program["id"];

                // التحقق إذا كان المستخدم قد اختار أي عنصر للتعديل
                $edit_item = $_POST['edit_item'] ?? '';

                // جلب البيانات الخاصة بالـ ID المحدد
                if ($edit_item) {
                    $query = mysqli_query($conn, "SELECT * FROM cource_specification_approval WHERE id = '$edit_item' AND user_id = '$user_id'");
                    $row = mysqli_fetch_assoc($query);

                    // تعبئة المدخلات بالبيانات
                    $council_committee = $row['council_committee'];
                    $reference_no = $row['reference_no'];
                    $date = $row['date'];

                    // تخزين البيانات في الجلسة ليمكن استخدامها بعد التعديل
                    $_SESSION['annual_approval_edit'] = [
                        'council_committee' => $council_committee,
                        'reference_no' => $reference_no,
                        'date' => $date
                    ];
                }

                // التحقق إذا كان قد تم ضغط زر "Save" لتنفيذ التحديث
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
                    // الحصول على القيم المدخلة
                    $council_committee = $_POST['council_committee'];
                    $reference_no = $_POST['reference_no'];
                    $date = $_POST['date'];

                    // التحقق من أن جميع الحقول تم تعبئتها
                    if (!empty($council_committee) && !empty($reference_no) && !empty($date)) {
                        // تحديث البيانات في قاعدة البيانات
                        $update_sql = "UPDATE cource_specification_approval SET council_committee = '$council_committee', reference_no = '$reference_no', date = '$date' WHERE id = '$edit_item' AND user_id = '$user_id'";

                        if ($conn->query($update_sql) === TRUE) {
                            $_SESSION['message'] = 'Record updated successfully!';
                            // بعد التحديث، نخزن القيم المعدلة في الجلسة لكي تظل ظاهرة في الحقول
                            $_SESSION['annual_approval_edit'] = [
                                'council_committee' => $council_committee,
                                'reference_no' => $reference_no,
                                'date' => $date
                            ];
                        } else {
                            $_SESSION['message'] = 'Error occurred while updating data.';
                        }
                    } else {
                        $_SESSION['message'] = 'Please fill in all fields.';
                    }

                    // إعادة توجيه بعد التحديث
                    header("Location: Course_Spesification_Specification_Approval.php?edit=" . $program_name);
                    exit;
                }

                if (isset($_POST["homepage"])) {
                    $user_id = $_SESSION['user_id'];
                    $lang = $_SESSION['lang'];
                    // unset($_SESSION["course_specification_edit"]);
                    // unset($_SESSION["general_information_edit"]);
                    // unset($_SESSION["course_content_edit"]);
                    // unset($_SESSION["student_assessment_activities_edit"]);
                    // unset($_SESSION["specification_learning_resources_edit"]);
                    // unset($_SESSION["specification_course_quality_edit"]);
                    // unset($_SESSION["apecification_approval_edit"]);
                    // unset($_SESSION["clos_edit"]);
                    // unset($_SESSION["course_specification_general_info_edit"]);

                    session_unset();

                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['lang'] = $lang;

                    header("location: HomePage.php");
                    exit;
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

                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <form method="post" id="coursesForm">
                            <label><?= $translations['Select an item to edit']?></label>
                            <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                                <option value=""><?= $translations['Select']?></option>
                                <?php
                                // استعلام لجلب جميع الخيارات
                                $query = "SELECT * FROM cource_specification_approval WHERE program_id = '$program_id' AND user_id = '$user_id'";
                                $result = mysqli_query($conn, $query);

                                // عرض الخيارات
                                while ($row_edit = mysqli_fetch_assoc($result)) {
                                    $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                                    echo "<option value='{$row_edit['id']}' $selected>{$row_edit['council_committee']}</option>";
                                }
                                ?>
                            </select>

                            <button type="submit" class="button" name="edit_row"><?= $translations['Edit']?></button>

                            <div id="programs" class="form-container">
                                <h2><?= $translations['Specification Approval']?></h2>
                                <table>
                                    <tr>
                                        <th><?= $translations['COUNCIL / COMMITTEE']?></th>
                                        <td><input type="text" name="council_committee" value="<?= htmlspecialchars($_SESSION['annual_approval_edit']['council_committee'] ?? '') ?>"></td>
                                    </tr>
                                    <tr>
                                        <th><?= $translations['REFERENCE NO']?>.</th>
                                        <td><input type="text" name="reference_no" value="<?= htmlspecialchars($_SESSION['annual_approval_edit']['reference_no'] ?? '') ?>"></td>
                                    </tr>
                                    <tr>
                                        <th><?= $translations['DATE']?>:</th>
                                        <td><input type="date" name="date" value="<?= htmlspecialchars($_SESSION['annual_approval_edit']['date'] ?? '') ?>"></td>
                                    </tr>
                                </table>
                                <button class="nav-button" style="position: relative; top: -1px; left: 85%;"><?= $translations['Print'] ?></button>

                                <div class="navigation-buttons">
                                    <button type="submit" name="update" class="nav-button"><?= $translations['Update']?></button>
                                    <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Assessment_Of_Course_Quality.php?edit=<?= $program_name ?>')"><?= $translations['Back']?></button>
                                    <button type="submit" name="homepage" class="nav-button"><?= $translations['Home Page']?></button>
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