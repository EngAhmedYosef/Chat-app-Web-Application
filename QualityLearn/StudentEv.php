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
    <title><?= $translations['Annual Program Report-Program Assessment-2.Students Evaluation of Courses'] ?></title>
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
            height: 130vh;
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
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
        }

        .sidebar button:hover {
            background-color: #0073e6;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .content {
            width: 80%;
            padding: 20px;
            background: linear-gradient(to top, #d7dce9, #f0f4fa);
            overflow-y: auto;
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

        p {
            color: #003f8a;
            font-size: 15px;
            font-weight: 200;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
            margin: 0;
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
            transition: background-color 0.3s;
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
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
        }

        .add-row-button:hover {
            background-color: #0057b7;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
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
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $course_titles = $_POST['course_title'];
                $num_students = $_POST['number_of_students'];
                $percentages = $_POST['percentage'];
                $evaluation_results = $_POST['evaluation_results'];
                $recommendations = $_POST['recommendations'];

                // حفظ البيانات في $_SESSION
                $_SESSION['student_ev_new'] = [
                    'course_title' => $course_titles,
                    'number_of_students' => $num_students,
                    'percentage' => $percentages,
                    'evaluation_results' => $evaluation_results,
                    'recommendations' => $recommendations,
                ];

                if (
                    !empty($course_titles) &&
                    !empty($num_students) &&
                    !empty($percentages) &&
                    !empty($evaluation_results) &&
                    !empty($recommendations)
                ) {
                    $data = [];
                    for ($i = 0; $i < count($course_titles); $i++) {
                        $data[] = [
                            'course_title' => $conn->real_escape_string($course_titles[$i]),
                            'number_of_students' => $conn->real_escape_string($num_students[$i]),
                            'percentage' => $conn->real_escape_string($percentages[$i]),
                            'evaluation_results' => $conn->real_escape_string($evaluation_results[$i]),
                            'recommendations' => $conn->real_escape_string($recommendations[$i]),
                        ];
                    }

                    // تحويل البيانات إلى JSON
                    $data_json = json_encode($data);

                    $stmt = $conn->prepare("INSERT INTO evaluation_cources (user_id, program_id, data) VALUES (?, ?, ?)");
                    $stmt->bind_param("iis", $user_id, $program_id, $data_json);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }
                header("location: StudentEv.php?new=" . $program_name);
                exit;
            }

            // استرجاع البيانات المدخلة من الجلسة لعرضها
            if (isset($_SESSION['student_ev_new'])) {
                $course_titles = $_SESSION['student_ev_new']['course_title'];
                $num_students = $_SESSION['student_ev_new']['number_of_students'];
                $percentages = $_SESSION['student_ev_new']['percentage'];
                $evaluation_results = $_SESSION['student_ev_new']['evaluation_results'];
                $recommendations = $_SESSION['student_ev_new']['recommendations'];
            } else {
                $course_titles = [];
                $num_students = [];
                $percentages = [];
                $evaluation_results = [];
                $recommendations = [];
            }
    ?>



            <div class="container">
                <div class="sidebar">
                    <a href="PLOs.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Program Assessment'] ?></button>
                    </a>
                    <a href="PLOs.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Program Learning Outcomes'] ?></button>
                    </a>
                    <a href="StudentEv.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Students Evaluation Of Courses'] ?></button>
                    </a>
                    <a href="Students_Evaluation_of_progrm_Q.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Students Evaluation Of Program Quality'] ?></button>
                    </a>
                    <a href="Scientific_research_and_innovation.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Scientific Research And Innovation'] ?></button>
                    </a>
                    <a href="Annual_Program_Report_Program_Assessment_Community_Partnership.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Community Partnership'] ?></button>
                    </a>
                    <a href="Annual_Program_Report_Program_Assessment_Other_Evaluation.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Other Evaluation'] ?></button>
                    </a>
                </div>
                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <div class="header-text">
                            <h3><?= $translations['Annual Program Report'] ?></h3>
                            <p><?= $translations['Program Assessment'] ?></p>
                        </div>
                        <a href="logout.php" class="button"><?= $translations['Log out'] ?></a>
                    </div>
                    <form method="post" id="coursesForm">

                        <?php

                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>


                        <div class="table-container">
                            <h2>2. <?= $translations['Students Evaluation Of Courses'] ?></h2>

                            <table id="Student-Evaluation">
                                <thead>
                                    <tr>
                                        <th><?= $translations['Course Code'] ?></th>
                                        <th><?= $translations['Course Title'] ?></th>
                                        <th><?= $translations['Number Of Students'] ?></th>
                                        <th><?= $translations['Percentage (%)'] ?></th>
                                        <th><?= $translations['Evaluation Results'] ?></th>
                                        <th><?= $translations['Recommendations'] ?></th>
                                        <th><?= $translations['Action'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($course_titles)) {
                                        foreach ($course_titles as $index => $title) {
                                            echo "<tr>";
                                            echo "<td>" . ($index + 1) . "</td>";
                                            echo "<td><input type='text' name='course_title[]' value='" . htmlspecialchars($title) . "' required></td>";
                                            echo "<td><input type='text' name='number_of_students[]' value='" . htmlspecialchars($num_students[$index]) . "' required></td>";
                                            echo "<td><input type='text' name='percentage[]' value='" . htmlspecialchars($percentages[$index]) . "' required></td>";
                                            echo "<td><input type='text' name='evaluation_results[]' value='" . htmlspecialchars($evaluation_results[$index]) . "' required></td>";
                                            echo "<td><input type='number' name='recommendations[]' value='" . htmlspecialchars($recommendations[$index]) . "' min='0' max='100' required></td>";
                                            echo "<td><button type='button' class='delete-button' onclick='deleteRow(this)'>$translations[Delete]</button></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr>";
                                        echo "<td>1</td>";
                                        echo "<td><input type='text' name='course_title[]' required></td>";
                                        echo "<td><input type='text' name='number_of_students[]' required></td>";
                                        echo "<td><input type='text' name='percentage[]' required></td>";
                                        echo "<td><input type='text' name='evaluation_results[]' required></td>";
                                        echo "<td><input type='number' name='recommendations[]' min='0' max='100' required></td>";
                                        echo "<td><button type='button' class='delete-button' onclick='deleteRow(this)'> $translations[Delete]</button></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <button class="add-row-button" type="button" onclick="addRow()"><?= $translations['Add Row'] ?></button>

                            <div class="navigation-buttons">
                                <button type="submit" name="save" class="nav-button"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Students_Evaluation_of_progrm_Q.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('PLOs.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            </div>
            <script>
                let counter = 2;

                function addRow() {
                    const table = document.getElementById("Student-Evaluation").getElementsByTagName("tbody")[0];
                    const newRow = table.insertRow();
                    const newRowIndex = counter++;

                    for (let i = 0; i < 7; i++) {
                        const newCell = newRow.insertCell(i);
                        if (i === 0) {
                            newCell.textContent = newRowIndex;
                        } else if (i === 6) {
                            const deleteButton = document.createElement("button");
                            deleteButton.className = "delete-button";
                            deleteButton.textContent = "<?= $translations['Delete'] ?>";
                            deleteButton.type = "button";
                            deleteButton.onclick = () => deleteRow(deleteButton);
                            newCell.appendChild(deleteButton);
                        } else {
                            const input = document.createElement("input");
                            input.type = i === 5 ? "number" : "text";
                            input.name = [
                                "course_title[]",
                                "number_of_students[]",
                                "percentage[]",
                                "evaluation_results[]",
                                "recommendations[]",
                            ][i - 1];
                            input.required = true;
                            if (i === 5) {
                                input.setAttribute("min", "0");
                                input.setAttribute("max", "100");
                            }
                            newCell.appendChild(input);
                        }
                    }
                }

                function deleteRow(button) {
                    const row = button.parentNode.parentNode;
                    row.remove();

                    // Re-index row numbers
                    const rows = document.getElementById("Student-Evaluation").getElementsByTagName("tbody")[0].rows;
                    for (let i = 0; i < rows.length; i++) {
                        rows[i].cells[0].textContent = i + 1;
                    }
                    counter = rows.length + 1;
                }
            </script>


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
        $edit_item = $_POST['edit_item'] ?? ($_SESSION['student_ev_edit']['edit_item'] ?? '');

        // التحقق من أن العنصر المختار موجود في قاعدة البيانات
        if ($edit_item) {
            $query = mysqli_query($conn, "SELECT * FROM evaluation_cources WHERE id = '$edit_item' AND user_id = '$user_id'");
            $row = mysqli_fetch_assoc($query);
            $data = json_decode($row['data'], true); // فك تشفير البيانات من JSON

            // تخزين البيانات في الجلسة
            $_SESSION['student_ev_edit'] = [
                'edit_item' => $edit_item,
                'data' => $data
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update'])) {
                // التحقق من المدخلات
                $course_titles = $_POST['course_title'];
                $num_students = $_POST['number_of_students'];
                $percentages = $_POST['percentage'];
                $evaluation_results = $_POST['evaluation_results'];
                $recommendations = $_POST['recommendations'];

                if (
                    !empty($course_titles) &&
                    !empty($num_students) &&
                    !empty($percentages) &&
                    !empty($evaluation_results) &&
                    !empty($recommendations)
                ) {
                    $data = [];
                    for ($i = 0; $i < count($course_titles); $i++) {
                        $data[] = [
                            'course_title' => $conn->real_escape_string($course_titles[$i]),
                            'number_of_students' => $conn->real_escape_string($num_students[$i]),
                            'percentage' => $conn->real_escape_string($percentages[$i]),
                            'evaluation_results' => $conn->real_escape_string($evaluation_results[$i]),
                            'recommendations' => $conn->real_escape_string($recommendations[$i]),
                        ];
                    }

                    // تحويل البيانات إلى JSON
                    $data_json = json_encode($data);

                    // تحديث البيانات
                    if ($edit_item) {
                        $stmt = $conn->prepare("UPDATE evaluation_cources SET data = ? WHERE id = ? AND user_id = ?");
                        $stmt->bind_param("sii", $data_json, $edit_item, $user_id);
                    }

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records Updated successfully!';
                        // تحديث الجلسة بالبيانات بعد التحديث
                        $_SESSION['student_ev_edit'] = [
                            'edit_item' => $edit_item,
                            'data' => $data
                        ];
                    } else {
                        $_SESSION['message'] = 'Error occurred while updating data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("location: StudentEv.php?edit=" . $program_name);
                exit;
            }
        }

    ?>

        <div class="container">
            <div class="sidebar">
                <a href="PLOs.php?edit=<?php echo $program_name ?>">
                    <button><?= $translations['Program Assessment'] ?></button>
                </a>
                <a href="PLOs.php?edit=<?php echo $program_name ?>">
                    <button><?= $translations['Program Learning Outcomes'] ?></button>
                </a>
                <a href="StudentEv.php?edit=<?php echo $program_name ?>">
                    <button><?= $translations['Students Evaluation Of Courses'] ?></button>
                </a>
                <a href="Students_Evaluation_of_progrm_Q.php?edit=<?php echo $program_name ?>">
                    <button><?= $translations['Students Evaluation Of Program Quality'] ?></button>
                </a>
                <a href="Scientific_research_and_innovation.php?edit=<?php echo $program_name ?>">
                    <button><?= $translations['Scientific Research And Innovation'] ?></button>
                </a>
                <a href="Annual_Program_Report_Program_Assessment_Community_Partnership.php?edit=<?php echo $program_name ?>">
                    <button><?= $translations['Community Partnership'] ?></button>
                </a>
                <a href="Annual_Program_Report_Program_Assessment_Other_Evaluation.php?edit=<?php echo $program_name ?>">
                    <button><?= $translations['Other Evaluation'] ?></button>
                </a>
            </div>
            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <div class="header-text">
                        <h3><?= $translations['Annual Program Report'] ?></h3>
                        <p><?= $translations['Program Assessment'] ?></p>
                    </div>
                    <a href="logout.php" class="button"><?= $translations['Log out'] ?></a>
                </div>
                <form method="post" id="coursesForm">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    }
                    ?>

                    <?php
                    // استعلام لجلب جميع الخيارات
                    $query = "SELECT * FROM evaluation_cources WHERE program_id = '$program_id' AND user_id = '$user_id'";
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
                                $course_title = $first_course['course_title'] ?? 'N/A';

                                $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                                echo "<option value='{$row_edit['id']}' $selected>{$course_title}</option>";
                            }
                        }
                        ?>
                    </select>

                    <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>">

                    <div class="table-container">
                        <h2>2. <?= $translations['Students Evaluation Of Courses'] ?></h2>

                        <table id="Student-Evaluation">
                            <thead>
                                <tr>
                                    <th><?= $translations['Course Code'] ?></th>
                                    <th><?= $translations['Course Title'] ?></th>
                                    <th><?= $translations['Number Of Students'] ?></th>
                                    <th><?= $translations['Percentage (%)'] ?></th>
                                    <th><?= $translations['Evaluation Results'] ?></th>
                                    <th><?= $translations['Recommendations'] ?></th>
                                    <th><?= $translations['Action'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // تحميل البيانات من الجلسة لعرضها في الحقول
                                $data = $_SESSION['student_ev_edit']['data'] ?? [];
                                if (!empty($data)) {
                                    $row_number = 1; // عداد لرقم الصف
                                    foreach ($data as $item) {
                                        echo "<tr>
                        <td>{$row_number}</td>
                        <td><input type='text' name='course_title[]' value='{$item['course_title']}' required /></td>
                        <td><input type='text' name='number_of_students[]' value='{$item['number_of_students']}' required /></td>
                        <td><input type='text' name='percentage[]' value='{$item['percentage']}' required /></td>
                        <td><input type='text' name='evaluation_results[]' value='{$item['evaluation_results']}' required /></td>
                        <td><input type='number' name='recommendations[]' value='{$item['recommendations']}' min='0' max='100' required /></td>
                    </tr>";
                                        $row_number++; // زيادة العداد
                                    }
                                } else {
                                    echo "<tr>
                            <td>1</td>
                            <td><input type='text' name='course_title[]' /></td>
                            <td><input type='text' name='number_of_students[]' /></td>
                            <td><input type='text' name='percentage[]' /></td>
                            <td><input type='text' name='evaluation_results[]' /></td>
                            <td><input type='number' name='recommendations[]' min='0' max='100' /></td>
                        </tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <div class="navigation-buttons">
                            <button type="submit" name="update" class="nav-button"><?= $translations['Update'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Students_Evaluation_of_progrm_Q.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('PLOs.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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