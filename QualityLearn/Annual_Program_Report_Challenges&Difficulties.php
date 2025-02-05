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
    <title><?= $translations['Challenges and Difficulties']?></title>
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
            padding: 20px;
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
        }

        table th {
            background: linear-gradient(to right, #0057b7, #0073e6);
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

        table td input[type="text"] {
            width: 90%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
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


        .logout-button {
            background: #003f8a;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-button:hover {
            background: #0057b7;
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

            if (isset($_POST['save'])) {
                $teaching = $_POST['teaching'];
                $assessment = $_POST['assessment'];
                $guidance = $_POST['guidance'];
                $learning_resources = $_POST['learning_resources'];
                $faculty = $_POST['faculty'];
                $research_activities = $_POST['research_activities'];
                $others = $_POST['others'];

                if (
                    !empty($teaching) && !empty($assessment) && !empty($guidance)
                    && !empty($learning_resources) && !empty($faculty) && !empty($research_activities)
                    && !empty($others)
                ) {
                    $sql = "INSERT INTO challenges (user_id, teaching, assessment, guidance, learning_resources, faculty, research_activities, others, program_id) 
                VALUES ('$user_id', '$teaching', '$assessment', '$guidance', '$learning_resources', '$faculty', '$research_activities', '$others', '$program_id')";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }

                    // Save form data to session to retain it
                    $_SESSION['challenges_new'] = $_POST;

                    // Redirect to avoid resubmission of form data
                    header("Location: Annual_Program_Report_Challenges&Difficulties.php?new=" . $program_name);
                    exit;
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }
            }

            // Check if form data exists in the session
            $challenges_new = isset($_SESSION['challenges_new']) ? $_SESSION['challenges_new'] : [];

            if (isset($_POST["next"])) {
                header("location: nextpage.php?new=" . $program_name);
                exit;
            }

            if (isset($_POST["back"])) {
                header("location: Program_KPIs_Table.php?new=" . $program_name);
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
                <div class="content">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Annual Program Report'] ?></h3>
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>

                    <?php if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    } ?>
                    <form method="POST" id="coursesForm">
                        <h2><?= $translations['Challenges and Difficulties'] ?></h2>
                        <div class="table-container">
                            <table id="Challenges&Difficulties">
                                <tr>
                                    <th><?= $translations['Category'] ?></th>
                                    <th><?= $translations['Details'] ?></th>
                                </tr>
                                <tr>
                                    <td><?= $translations['Teaching'] ?></td>
                                    <td><input type="text" name="teaching" value="<?php echo isset($challenges_new['teaching']) ? $challenges_new['teaching'] : ''; ?>" placeholder="<?= $translations['Enter details for Teaching'] ?>" id="teaching"></td>
                                </tr>
                                <tr>
                                    <td><?= $translations['Assessment'] ?></td>
                                    <td><input type="text" name="assessment" value="<?php echo isset($challenges_new['assessment']) ? $challenges_new['assessment'] : ''; ?>" placeholder="<?= $translations['Enter details for Assessment'] ?>" id="assessment"></td>
                                </tr>
                                <tr>
                                    <td><?= $translations['Guidance and Counseling'] ?></td>
                                    <td><input type="text" name="guidance" value="<?php echo isset($challenges_new['guidance']) ? $challenges_new['guidance'] : ''; ?>" placeholder="<?= $translations['Enter details for Guidance and Counseling'] ?>" id="guidance"></td>
                                </tr>
                                <tr>
                                    <td><?= $translations['Learning Resources'] ?></td>
                                    <td><input type="text" name="learning_resources" value="<?php echo isset($challenges_new['learning_resources']) ? $challenges_new['learning_resources'] : ''; ?>" placeholder="<?= $translations['Enter details for Learning Resources'] ?>" id="learning_resources"></td>
                                </tr>
                                <tr>
                                    <td><?= $translations['Faculty'] ?></td>
                                    <td><input type="text" name="faculty" value="<?php echo isset($challenges_new['faculty']) ? $challenges_new['faculty'] : ''; ?>" placeholder="<?= $translations['Enter details for Faculty'] ?>" id="faculty"></td>
                                </tr>
                                <tr>
                                    <td><?= $translations['Research Activities'] ?></td>
                                    <td><input type="text" name="research_activities" value="<?php echo isset($challenges_new['research_activities']) ? $challenges_new['research_activities'] : ''; ?>" placeholder="<?= $translations['Enter details for Research Activities'] ?>" id="research_activities"></td>
                                </tr>
                                <tr>
                                    <td><?= $translations['Others'] ?></td>
                                    <td><input type="text" name="others" value="<?php echo isset($challenges_new['others']) ? $challenges_new['others'] : ''; ?>" placeholder="<?= $translations['Enter other challenges'] ?>" id="others"></td>
                                </tr>
                            </table>

                            <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Program_Devalopment_Plan.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button> <!-- لسه صفحته متعملتش -->
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_KPIs_Table.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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

        // التحقق إذا تم اختيار id جديد من الـ Select
        if (isset($_POST['edit_item']) && !empty($_POST['edit_item'])) {
            $_SESSION['selected_id'] = $_POST['edit_item']; // تخزين id في الجلسة
        }

        // التحقق من أن الـ id في الجلسة موجود لجلب البيانات
        if (isset($_SESSION['selected_id'])) {
            $edit_item = $_SESSION['selected_id'];
            $query = mysqli_query($conn, "SELECT * FROM challenges WHERE id = '$edit_item' AND user_id = '$user_id'");
            $row = mysqli_fetch_assoc($query);
        }

        // حفظ البيانات في الـ SESSION بعد التعديل
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $teaching = $_POST['teaching'];
            $assessment = $_POST['assessment'];
            $guidance = $_POST['guidance'];
            $learning_resources = $_POST['learning_resources'];
            $faculty = $_POST['faculty'];
            $research_activities = $_POST['research_activities'];
            $others = $_POST['others'];

            // حفظ البيانات المدخلة في الـ SESSION
            $_SESSION['challenges_edit'] = [
                'teaching' => $teaching,
                'assessment' => $assessment,
                'guidance' => $guidance,
                'learning_resources' => $learning_resources,
                'faculty' => $faculty,
                'research_activities' => $research_activities,
                'others' => $others
            ];

            if (
                !empty($teaching) && !empty($assessment) && !empty($guidance)
                && !empty($learning_resources) && !empty($faculty) && !empty($research_activities)
                && !empty($others)
            ) {
                $sql = "UPDATE challenges SET teaching = '$teaching', assessment = '$assessment',
                guidance = '$guidance', learning_resources = '$learning_resources',
                faculty = '$faculty', research_activities = '$research_activities',
                others = '$others' WHERE id = '$edit_item'";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['message'] = 'Records Updated successfully!';
                    unset($_SESSION['challenges_edit']); // مسح البيانات من الجلسة بعد التحديث
                } else {
                    $_SESSION['message'] = 'Error occurred while updating data.';
                }
            } else {
                $_SESSION['message'] = 'Enter Your Data.';
            }

            header("location: Annual_Program_Report_Challenges&Difficulties.php?edit=" . $program_name);
            exit;
        }

        // عرض النموذج
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
            <div class="content">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <h3><?= $translations['Annual Program Report'] ?></h3>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                </div>

                <?php if (isset($_SESSION['message'])) {
                    echo $translations[$_SESSION['message']];
                    unset($_SESSION['message']);
                } ?>

                <form method="POST" id="coursesForm">
                    <?php
                    // استعلام لجلب جميع الخيارات
                    $query = "SELECT * FROM challenges WHERE program_id = '$program_id' AND user_id = '$user_id'";
                    $result = mysqli_query($conn, $query);
                    ?>

                    <label><?= $translations['Select an item to edit'] ?></label>
                    <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                        <option value=""><?= $translations['Select'] ?></option>
                        <?php
                        // عرض الخيارات
                        while ($row_edit = mysqli_fetch_assoc($result)) {
                            $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                            echo "<option value='{$row_edit['id']}' $selected>{$row_edit['teaching']}</option>";
                        }
                        ?>
                    </select>

                    <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>" readonly>

                    <h2><?= $translations['Challenges and Difficulties'] ?></h2>
                    <div class="table-container">
                        <table id="Challenges&Difficulties">
                            <tr>
                                <th><?= $translations['Category'] ?></th>
                                <th><?= $translations['Details'] ?></th>
                            </tr>

                            <tr>
                                <td><?= $translations['Teaching'] ?></td>
                                <td><input value="<?= htmlspecialchars($_SESSION['challenges_edit']['teaching'] ?? $row['teaching'] ?? '') ?>" type="text" name="teaching" id="teaching"></td>
                            </tr>
                            <tr>
                                <td><?= $translations['Assessment'] ?></td>
                                <td><input value="<?= htmlspecialchars($_SESSION['challenges_edit']['assessment'] ?? $row['assessment'] ?? '') ?>" type="text" name="assessment" id="assessment"></td>
                            </tr>
                            <tr>
                                <td><?= $translations['Guidance and Counseling'] ?></td>
                                <td><input value="<?= htmlspecialchars($_SESSION['challenges_edit']['guidance'] ?? $row['guidance'] ?? '') ?>" type="text" name="guidance" id="guidance"></td>
                            </tr>
                            <tr>
                                <td><?= $translations['Learning Resources'] ?></td>
                                <td><input value="<?= htmlspecialchars($_SESSION['challenges_edit']['learning_resources'] ?? $row['learning_resources'] ?? '') ?>" type="text" name="learning_resources" id="learning_resources"></td>
                            </tr>
                            <tr>
                                <td><?= $translations['Faculty'] ?></td>
                                <td><input value="<?= htmlspecialchars($_SESSION['challenges_edit']['faculty'] ?? $row['faculty'] ?? '') ?>" type="text" name="faculty" id="faculty"></td>
                            </tr>
                            <tr>
                                <td><?= $translations['Research Activities'] ?></td>
                                <td><input value="<?= htmlspecialchars($_SESSION['challenges_edit']['research_activities'] ?? $row['research_activities'] ?? '') ?>" type="text" name="research_activities" id="research_activities"></td>
                            </tr>
                            <tr>
                                <td><?= $translations['Others'] ?></td>
                                <td><input value="<?= htmlspecialchars($_SESSION['challenges_edit']['others'] ?? $row['others'] ?? '') ?>" type="text" name="others" id="others"></td>
                            </tr>
                        </table> <button name="update" class="nav-button" type="submit"><?= $translations['Update'] ?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Program_Devalopment_Plan.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button> <!-- لسه صفحته متعملتش -->
                        <button type="button" class="nav-button" onclick="handleNavigation('Program_KPIs_Table.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>

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