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
    <title><?= $translations['Course Specification'] ?></title>
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
            height: 115vh;
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

        .header h3 {
            color: #003f8a;
            font-size: 24px;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        }

        .form-container {
            width: 97%;
            margin-top: 30px;
            padding: 10px;
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .form-container .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-container label {
            flex: 1 0 40%;
            margin-bottom: 5px;
        }

        .form-container input {
            flex: 2 0 50%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
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

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
                // الحصول على القيم المدخلة في الفورم
                $course_title = $_POST['course_title'];
                $course_code = $_POST['course_code'];
                $program = $_POST['program'];
                $department = $_POST['department'];
                $college = $_POST['college'];
                $institution = $_POST['institution'];
                $version = $_POST['version'];
                $last_revision_date = $_POST['last_revision_date'];

                // التحقق من أن جميع الحقول تم ملؤها
                if (empty($course_title) || empty($course_code) || empty($program) || empty($department) || empty($college) || empty($institution) || empty($version) || empty($last_revision_date)) {
                    $_SESSION['message'] = "Please fill in all fields.";
                } else {
                    // التحقق من الاتصال
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // إضافة البيانات إلى الجدول
                    $sql = "INSERT INTO course_specifications (user_id, course_title, course_code, program, department, college, institution, version, last_revision_date, program_id)
                    VALUES ('$user_id', '$course_title', '$course_code', '$program', '$department', '$college', '$institution', '$version', '$last_revision_date', '$program_id')";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                }

                // حفظ البيانات في الـ session للمحافظة عليها بعد إعادة تحميل الصفحة
                $_SESSION['course_specification_new'] = $_POST;

                header("location: Course_Specification.php?new=" . $program_name);
                exit;
            }

            // إذا كانت البيانات في الـ session موجودة، قم بإعادة تعيينها للـ inputs
            $course_specification_new = isset($_SESSION['course_specification_new']) ? $_SESSION['course_specification_new'] : [];

            $program_repeat =  $_SESSION['program_repeat'] ?? '' ;
            $department_repeat = $_SESSION['department_repeat'] ?? '';
            $college_repeat =  $_SESSION['college_repeat'] ?? '';
            $institution_repeat =  $_SESSION['institution_repeat'] ?? '';
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
                        <h3><?= $translations['Course Specification'] ?></h3>
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>
                    <form method="post" id="coursesForm">

                        <div class="form-container">
                            <?php
                            if (isset($_SESSION['message'])) {
                                echo $translations[$_SESSION['message']];
                                unset($_SESSION['message']);
                            }
                            ?>

                            <div id="Courses" class="form-container">
                                <h2><?= $translations['Course Specification'] ?></h2>
                                <div class="form-group">
                                    <label for="course_title"><?= $translations['Course Title'] ?> : </label>
                                    <input type="text" name="course_title" placeholder="<?= $translations['Enter Course Title'] ?>" required value="<?php echo isset($course_specification_new['course_title']) ? $course_specification_new['course_title'] : ''; ?>">

                                    <label for="course_code"><?= $translations['Course Code'] ?>:</label>
                                    <input type="text" name="course_code" placeholder="<?= $translations['Enter Course Code'] ?>" required value="<?php echo isset($course_specification_new['course_code']) ? $course_specification_new['course_code'] : ''; ?>">

                                    <label for="program"><?= $translations['Program'] ?>:</label>
                                    <input type="text" name="program" placeholder="<?= $translations['Enter Program Name'] ?>" required value="<?php echo isset($course_specification_new['program']) ? $course_specification_new['program'] : $program_repeat; ?>">

                                    <label for="department"><?= $translations['Department'] ?> :</label>
                                    <input type="text" name="department" placeholder="<?= $translations['Enter Department Name'] ?>" required value="<?php echo isset($course_specification_new['department']) ? $course_specification_new['department'] : $department_repeat; ?>">

                                    <label for="college"><?= $translations['College'] ?>:</label>
                                    <input type="text" name="college" placeholder="<?= $translations['Enter College Name'] ?>" required value="<?php echo isset($course_specification_new['college']) ? $course_specification_new['college'] : $college_repeat; ?>">

                                    <label for="institution"><?= $translations['Institution'] ?>:</label>
                                    <input type="text" name="institution" placeholder="<?= $translations['Enter Institution Name'] ?>" required value="<?php echo isset($course_specification_new['institution']) ? $course_specification_new['institution'] : $institution_repeat; ?>">

                                    <label for="version"><?= $translations['Version'] ?>:</label>
                                    <input type="text" name="version" placeholder="<?= $translations['Course Specification Version Number'] ?>" required value="<?php echo isset($course_specification_new['version']) ? $course_specification_new['version'] : ''; ?>">

                                    <label for="last_revision_date"><?= $translations['Last Revision Date'] ?>:</label>
                                    <input type="date" name="last_revision_date" placeholder="Pick Revision Date" required value="<?php echo isset($course_specification_new['last_revision_date']) ? $course_specification_new['last_revision_date'] : ''; ?>">
                                </div>
                                <div class="navigation-buttons">

                                    <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                                    <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_General_Info_About_The_Course.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                    <button type="button" class="nav-button" onclick="handleNavigation('HomePage.php')"><?= $translations['Back'] ?></button>

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

        // جلب الـ program_id بناءً على البرنامج المختار
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // إذا تم الضغط على زر "Edit" لجلب البيانات
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_row'])) {
            $edit_item = $_POST['edit_item'];

            if (!empty($edit_item)) {
                // جلب بيانات العنصر المختار
                $query = mysqli_query($conn, "SELECT * FROM course_specifications WHERE id = '$edit_item' AND program_id = '$program_id'");
                $row = mysqli_fetch_assoc($query);
                $edit_data = $row; // تخزين البيانات لعرضها في الحقول

                // حفظ البيانات في الـ SESSION
                $_SESSION['course_specification_edit'] = $edit_data;
            }
        }

        // إذا تم الضغط على زر "Update" لتحديث البيانات
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
            // الحصول على القيم المدخلة
            $course_title = $_POST['course_title'];
            $course_code = $_POST['course_code'];
            $program = $_POST['program'];
            $department = $_POST['department'];
            $college = $_POST['college'];
            $institution = $_POST['institution'];
            $version = $_POST['version'];
            $last_revision_date = $_POST['last_revision_date'];
            $edit_item = $_POST['id'];

            // التحقق من ملء جميع الحقول
            if (empty($course_title) || empty($course_code) || empty($program) || empty($department) || empty($college) || empty($institution) || empty($version) || empty($last_revision_date)) {
                echo "Please fill in all fields.";
            } else {
                // جملة SQL لتحديث البيانات
                $sql = "UPDATE course_specifications 
                SET course_title = '$course_title', 
                    course_code = '$course_code', 
                    program = '$program', 
                    department = '$department', 
                    college = '$college', 
                    institution = '$institution', 
                    version = '$version', 
                    last_revision_date = '$last_revision_date' 
                WHERE id = '$edit_item' AND program_id = '$program_id'";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['message'] = 'Record updated successfully!';
                } else {
                    $_SESSION['message'] = 'Error occurred while updating data.';
                }

                // إعادة تخزين البيانات المعدلة في الـ session لتظل موجودة عند التعديل مرة أخرى
                $_SESSION['course_specification_edit'] = [
                    'course_title' => $course_title,
                    'course_code' => $course_code,
                    'program' => $program,
                    'department' => $department,
                    'college' => $college,
                    'institution' => $institution,
                    'version' => $version,
                    'last_revision_date' => $last_revision_date,
                    'id' => $edit_item
                ];

                header("location: Course_Specification.php?edit=" . $program_name);
                exit;
            }
        }
    ?>

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

            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <h3><?= $translations['Course Specification'] ?></h3>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                </div>

                <form method="post" id="coursesForm">
                    <div class="form-container">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <!-- استعلام لجلب العناصر من جدول course_specifications -->
                        <label><?= $translations['Select an item to edit'] ?></label>
                        <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                            <option value=""><?= $translations['Select'] ?></option>
                            <?php
                            $query = "SELECT * FROM course_specifications WHERE program_id = '$program_id'";
                            $result = mysqli_query($conn, $query);
                            while ($row_edit = mysqli_fetch_assoc($result)) {
                                $selected = (isset($edit_item) && $row_edit['id'] == $edit_item) ? 'selected' : '';
                                echo "<option value='{$row_edit['id']}' $selected>{$row_edit['course_title']}</option>";
                            }
                            ?>
                        </select>

                        <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>

                        <input type="hidden" name="id" value="<?= isset($_SESSION['course_specification_edit']['id']) ? htmlspecialchars($_SESSION['course_specification_edit']['id']) : '' ?>">

                        <?php if (isset($_SESSION['course_specification_edit'])) { ?>
                            <div id="Courses" class="form-container">
                                <h2><?= $translations['Course Specification'] ?></h2>
                                <div class="form-group">
                                    <label for="course_title"><?= $translations['Course Title'] ?> : </label>
                                    <input type="text" name="course_title" value="<?= htmlspecialchars($_SESSION['course_specification_edit']['course_title']) ?>" required>

                                    <label for="course_code"><?= $translations['Course Code'] ?>:</label>
                                    <input type="text" name="course_code" value="<?= htmlspecialchars($_SESSION['course_specification_edit']['course_code']) ?>" required>

                                    <label for="program"><?= $translations['Program'] ?>:</label>
                                    <input type="text" name="program" value="<?= htmlspecialchars($_SESSION['course_specification_edit']['program']) ?>" required>

                                    <label for="department"><?= $translations['Department'] ?> :</label>
                                    <input type="text" name="department" value="<?= htmlspecialchars($_SESSION['course_specification_edit']['department']) ?>" required>

                                    <label for="college"><?= $translations['College'] ?>:</label>
                                    <input type="text" name="college" value="<?= htmlspecialchars($_SESSION['course_specification_edit']['college']) ?>" required>

                                    <label for="institution"><?= $translations['Institution'] ?>:</label>
                                    <input type="text" name="institution" value="<?= htmlspecialchars($_SESSION['course_specification_edit']['institution']) ?>" required>

                                    <label for="version"><?= $translations['Version'] ?>:</label>
                                    <input type="text" name="version" value="<?= htmlspecialchars($_SESSION['course_specification_edit']['version']) ?>" required>

                                    <label for="last_revision_date"><?= $translations['Last Revision Date'] ?>:</label>
                                    <input type="date" name="last_revision_date" value="<?= htmlspecialchars($_SESSION['course_specification_edit']['last_revision_date']) ?>" required>
                                </div>
                                <div class="navigation-buttons">

                                    <button name="update" class="nav-button" type="submit"><?= $translations['Update'] ?></button>
                                    <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_General_Info_About_The_Course.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                    <button type="button" class="nav-button" onclick="handleNavigation('HomePage.php')"><?= $translations['Back'] ?></button>
                                </div>
                            </div>
                        <?php } ?>
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