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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $translations['Course Report-Course Learning Outcomes'] ?></title>
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
      font-family: "Poppins", sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #001f5b, #d7dce9);
    }

    .container {
      display: flex;
      flex-direction: row;
      height: 180vh;
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

    .form-container h3 {
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

    .form-group {
      margin-bottom: 20px;
      /* مسافة بين المجموعات */
    }

    .form-container label {
      flex: 1 0 30%;
      margin-bottom: 5px;
    }

    table {
      width: 95%;
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

    .sub-header {
      background-color: #0057b7;
      font-weight: bold;
    }

    textarea {
      width: 95%;
      height: 80px;
      margin-top: 0px;
      border-radius: 8px;
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

    .actionTd {
      display: flex;
      gap: 10px;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }

    .actionTd .btnDelete {
      width: 100px;
      background-color: rgb(182, 5, 5);
      color: white;
      border: none;
      border-radius: 6px;
      padding: 5px 10px;
      cursor: pointer;
      font-size: 14px;
      transition: 0.3s;
    }

    .btnAdd {
      width: 100px;
      background-color: #0057b7;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 5px 10px;
      cursor: pointer;
      font-size: 14px;
      transition: 0.3s;
    }

    .actionTd button:hover {
      filter: brightness(1.1);
      transform: scale(1.03);
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
        // الحصول على البيانات من الفورم
        $recommendations = $_POST['recommendations']; // نص التوصيات الذي يكتبه المستخدم

        // التحقق من أن جميع الحقول تم ملؤها
        $allFieldsFilled = true;
        $data = [];

        // التحقق لكل صف في البيانات
        foreach ($_POST['data'] as $key => $value) {
          if (
            empty($value['program_outcome']) || empty($value['related_plos_code']) || empty($value['assessment_methods']) ||
            empty($value['targeted_level']) || empty($value['actual_level']) || empty($value['comment'])
          ) {
            $allFieldsFilled = false;
            break; // إذا كان هناك أي حقل فارغ، نوقف التحقق
          }

          $data[] = [
            'key' => $key,
            'program_outcome' => $value['program_outcome'],
            'related_plos_code' => $value['related_plos_code'],
            'assessment_methods' => $value['assessment_methods'],
            'targeted_level' => $value['targeted_level'],
            'actual_level' => $value['actual_level'],
            'comment' => $value['comment']
          ];
        }

        if ($allFieldsFilled) {
          // تحويل البيانات إلى JSON
          $data_json = json_encode($data);

          // إدخال البيانات في قاعدة البيانات
          $sql = "INSERT INTO course_outcomes (user_id, data, program_id, recommendations)
                  VALUES ('$user_id', '$data_json', '$program_id', '$recommendations')";

          if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = 'Records created successfully!';
          } else {
            $_SESSION['message'] = 'Error occurred while inserting data.';
          }
        } else {
          $_SESSION['message'] = 'Please fill in all fields.';
        }

        // حفظ البيانات المدخلة في الجلسة
        $_SESSION['cource_report_clos_new'] = $_POST;

        header("location: Course_Report_Course_Learning _Outcomes.php?new=" . $program_name);
        exit;
      }

      // استرجاع البيانات المخزنة في الجلسة
      $cource_report_clos_new = isset($_SESSION['cource_report_clos_new']) ? $_SESSION['cource_report_clos_new'] : [];

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
            <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px" />
            <h3><?= $translations['Course Report'] ?></h3>
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
              <h2><?= $translations['Course Learning Outcomes'] ?></h2>
              <p><?= $translations['Course Learning Outcomes Assessment Results'] ?></p>
              <table id="coursesTable">
                <thead>
                  <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2"><?= $translations['Program Learning Outcomes'] ?></th>
                    <th rowspan="2"><?= $translations['Related PLOs Code'] ?></th>
                    <th rowspan="2"><?= $translations['Assessment Methods'] ?></th>
                    <th colspan="2"><?= $translations['Assessment Results'] ?></th>
                    <th rowspan="2"><?= $translations['Comment on Assessment Results'] ?></th>
                    <th rowspan="4"><?= $translations['Actions'] ?></th>
                  </tr>
                  <tr>
                    <th class="sub-header"><?= $translations['Targeted Level'] ?></th>
                    <th class="sub-header"><?= $translations['Actual Level'] ?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="8" class="section-header"><?= $translations['Knowledge and Understanding'] ?></td>
                  </tr>
                  <?php
                  $k_counter = 1;
                  if (isset($cource_report_clos_new['data']['k1'])) {
                    // عرض البيانات المخزنة في الجلسة لكل صف
                    foreach ($cource_report_clos_new['data'] as $key => $value) {
                      if (strpos($key, 'k') === 0) {
                        echo "<tr class='dataRow'>";
                        echo "<td>" . htmlspecialchars($key) . "</td>";
                        echo "<td><input type='text' name='data[$key][program_outcome]' value='" . htmlspecialchars($value['program_outcome']) . "' /></td>";
                        echo "<td><input type='text' name='data[$key][related_plos_code]' value='" . htmlspecialchars($value['related_plos_code']) . "' /></td>";
                        echo "<td><input type='text' name='data[$key][assessment_methods]' value='" . htmlspecialchars($value['assessment_methods']) . "' /></td>";
                        echo "<td><input type='number' name='data[$key][targeted_level]' value='" . htmlspecialchars($value['targeted_level']) . "' /></td>";
                        echo "<td><input type='number' name='data[$key][actual_level]' value='" . htmlspecialchars($value['actual_level']) . "' /></td>";
                        echo "<td><input type='text' name='data[$key][comment]' value='" . htmlspecialchars($value['comment']) . "' /></td>";
                        echo "<td class='actionTd'><button class='btnDelete' type='button' onclick='deleteRow(this, \"k\")'>Delete</button></td>";
                        echo "</tr>";
                        $k_counter++;
                      }
                    }
                  }
                  ?>
                  <tr>
                    <td colspan="8">
                      <button type="button" class="btnAdd" name="addRow" onclick="coursesTableAddRow(this, 'k')"><?= $translations['Add Row'] ?></button>
                    </td>
                  </tr>
                </tbody>

                <!-- قسم المهارات -->
                <tbody>
                  <tr>
                    <td colspan="8" class="section-header"><?= $translations['Skills'] ?></td>
                  </tr>
                  <?php
                  $s_counter = 1;
                  if (isset($cource_report_clos_new['data']['s1'])) {
                    // عرض البيانات المخزنة في الجلسة لكل صف
                    foreach ($cource_report_clos_new['data'] as $key => $value) {
                      if (strpos($key, 's') === 0) {
                        echo "<tr class='dataRow'>";
                        echo "<td>" . htmlspecialchars($key) . "</td>";
                        echo "<td><input type='text' name='data[$key][program_outcome]' value='" . htmlspecialchars($value['program_outcome']) . "' /></td>";
                        echo "<td><input type='text' name='data[$key][related_plos_code]' value='" . htmlspecialchars($value['related_plos_code']) . "' /></td>";
                        echo "<td><input type='text' name='data[$key][assessment_methods]' value='" . htmlspecialchars($value['assessment_methods']) . "' /></td>";
                        echo "<td><input type='number' name='data[$key][targeted_level]' value='" . htmlspecialchars($value['targeted_level']) . "' /></td>";
                        echo "<td><input type='number' name='data[$key][actual_level]' value='" . htmlspecialchars($value['actual_level']) . "' /></td>";
                        echo "<td><input type='text' name='data[$key][comment]' value='" . htmlspecialchars($value['comment']) . "' /></td>";
                        echo "<td class='actionTd'><button class='btnDelete' type='button' onclick='deleteRow(this, \"s\")'>Delete</button></td>";
                        echo "</tr>";
                        $s_counter++;
                      }
                    }
                  }
                  ?>
                  <tr>
                    <td colspan="8">
                      <button type="button" class="btnAdd" name="addRow" onclick="coursesTableAddRow(this,'s')"><?= $translations['Add Row'] ?></button>
                    </td>
                  </tr>
                </tbody>

                <!-- قسم القيم والمسؤولية -->
                <tbody>
                  <tr>
                    <td colspan="8" class="section-header"><?= $translations['Values, Autonomy, and Responsibility'] ?></td>
                  </tr>
                  <?php
                  $v_counter = 1;
                  if (isset($cource_report_clos_new['data']['v1'])) {
                    // عرض البيانات المخزنة في الجلسة لكل صف
                    foreach ($cource_report_clos_new['data'] as $key => $value) {
                      if (strpos($key, 'v') === 0) {
                        echo "<tr class='dataRow'>";
                        echo "<td>" . htmlspecialchars($key) . "</td>";
                        echo "<td><input type='text' name='data[$key][program_outcome]' value='" . htmlspecialchars($value['program_outcome']) . "' /></td>";
                        echo "<td><input type='text' name='data[$key][related_plos_code]' value='" . htmlspecialchars($value['related_plos_code']) . "' /></td>";
                        echo "<td><input type='text' name='data[$key][assessment_methods]' value='" . htmlspecialchars($value['assessment_methods']) . "' /></td>";
                        echo "<td><input type='number' name='data[$key][targeted_level]' value='" . htmlspecialchars($value['targeted_level']) . "' /></td>";
                        echo "<td><input type='number' name='data[$key][actual_level]' value='" . htmlspecialchars($value['actual_level']) . "' /></td>";
                        echo "<td><input type='text' name='data[$key][comment]' value='" . htmlspecialchars($value['comment']) . "' /></td>";
                        echo "<td class='actionTd'><button class='btnDelete' type='button' onclick='deleteRow(this, \"v\")'>Delete</button></td>";
                        echo "</tr>";
                        $v_counter++;
                      }
                    }
                  }
                  ?>
                  <tr>
                    <td colspan="8">
                      <button type="button" class="btnAdd" name="addRow" onclick="coursesTableAddRow(this,'v')"><?= $translations['Add Row'] ?></button>
                    </td>
                  </tr>
                </tbody>
              </table>

              <h3><?= $translations['Recommendations'] ?></h3>
              <textarea name="recommendations"><?php echo htmlspecialchars(isset($cource_report_clos_new['recommendations']) ? $cource_report_clos_new['recommendations'] : ''); ?></textarea>

              <div class="navigation-buttons">
                <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Topics_not_covered.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Student_Results.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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
        function coursesTableAddRow(el, key) {
          const sectionHead = el.closest("tr").parentElement;
          const lastRow = sectionHead.lastElementChild;
          const rowsLinth = sectionHead.querySelectorAll(".dataRow").length;
          const newRow = document.createElement("tr");
          newRow.classList.add("dataRow");
          const row = `
            <td>${key}${rowsLinth + 1}</td>
            <td><input type="text" name="data[${key}${rowsLinth + 1}][program_outcome]" /></td>
            <td><input type="text" name="data[${key}${rowsLinth + 1}][related_plos_code]" /></td>
            <td><input type="text" name="data[${key}${rowsLinth + 1}][assessment_methods]" /></td>
            <td><input type="number" name="data[${key}${rowsLinth + 1}][targeted_level]" /></td>
            <td><input type="number" name="data[${key}${rowsLinth + 1}][actual_level]" /></td>
            <td><input type="text" name="data[${key}${rowsLinth + 1}][comment]" /></td>
            <td class="actionTd">
                <button class="btnDelete" type="button" onclick="deleteRow(this, '${key}')">Delete</button>
            </td>
        `;
          newRow.innerHTML = row;
          sectionHead.insertBefore(newRow, lastRow);
        }

        function deleteRow(button, key) {
          const row = button.closest("tr");
          const sectionHead = row.parentNode;
          row.parentNode.removeChild(row);
          reFillKeys(key, sectionHead);
        }

        function reFillKeys(key, element) {
          const tdKeys = element.querySelectorAll("tr.dataRow td:first-child");
          tdKeys.forEach((el, index) => {
            el.innerHTML = key + "" + (index + 1);
          });
        }
      </script>
  <?php }
  } ?>






  <?php

  if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
    $program_name = $_GET['edit'];

    // استعلام للحصول على معرّف البرنامج
    $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
    $row_program = mysqli_fetch_assoc($query_program);
    $program_id = $row_program["id"];

    // التحقق إذا كان المستخدم قد اختار أي عنصر للتعديل
    $edit_item = $_POST['edit_item'] ?? ($_SESSION['edit_item'] ?? '');

    // المتغيرات التي سيتم عرضها في النموذج
    $data = []; // التأكد من تعريف المصفوفة لتجنب تحذير undefined variable
    $recommendations = '';

    // إذا تم اختيار item للتعديل
    if ($edit_item) {
      $query = mysqli_query($conn, "SELECT * FROM course_outcomes WHERE id = '$edit_item' AND user_id = '$user_id'");
      if ($row = mysqli_fetch_assoc($query)) {
        $update_id = $row["id"];
        $data = json_decode($row['data'], true); // فك تشفير البيانات
        $recommendations = $row['recommendations']; // التأكد من أن البيانات موجودة

        // تخزين الـ id في الجلسة لاستخدامه لاحقًا
        $_SESSION['edit_item'] = $edit_item;
        $_SESSION['cource_report_clos_edit'] = [
          'id' => $update_id,
          'data' => $data,
          'recommendations' => $recommendations
        ];
      }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
      // الحصول على البيانات من الفورم
      $recommendations = $_POST['recommendations']; // نص التوصيات الذي يكتبه المستخدم

      // التحقق من أن جميع الحقول تم ملؤها
      $allFieldsFilled = true;
      $data = [];

      // التحقق لكل صف في البيانات
      foreach ($_POST['data'] as $key => $value) {
        if (
          empty($value['program_outcome']) || empty($value['related_plos_code']) || empty($value['assessment_methods']) ||
          empty($value['targeted_level']) || empty($value['actual_level']) || empty($value['comment'])
        ) {
          $allFieldsFilled = false;
          break; // إذا كان هناك أي حقل فارغ، نوقف التحقق
        }

        $data[] = [
          'key' => $key,
          'program_outcome' => $value['program_outcome'],
          'related_plos_code' => $value['related_plos_code'],
          'assessment_methods' => $value['assessment_methods'],
          'targeted_level' => $value['targeted_level'],
          'actual_level' => $value['actual_level'],
          'comment' => $value['comment']
        ];
      }

      if ($allFieldsFilled) {
        // تحويل البيانات إلى JSON
        $data_json = json_encode($data);

        // تنفيذ عملية التحديث بدلاً من الإدخال
        $sql = "UPDATE course_outcomes SET 
                    data = '$data_json', 
                    recommendations = '$recommendations'
                    WHERE id = '$update_id' AND user_id = '$user_id'";

        if ($conn->query($sql) === TRUE) {
          $_SESSION['message'] = 'Records updated successfully!';
        } else {
          $_SESSION['message'] = 'Error occurred while updating data.';
        }

        // تحديث البيانات في الجلسة بعد التحديث
        $_SESSION['cource_report_clos_edit'] = [
          'id' => $update_id,
          'data' => $data,
          'recommendations' => $recommendations
        ];
      } else {
        $_SESSION['message'] = 'Please fill in all fields.';
      }

      header("Location: Course_Report_Course_Learning _Outcomes.php?edit=" . $program_name);
      exit;
    }
  ?>

    <div class="container">
      <div class="sidebar">
        <a href="Course_Report_Reports.php?edit=<?php echo $program_name ?>"><button><?= $translations['Reports'] ?></button></a>
        <a href="Course_Report_Student_Results.php?edit=<?php echo $program_name ?>"><button><?= $translations['Student Results'] ?></button></a>
        <a href="Course_Report_Course_Learning _Outcomes.php?edit=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes (CLO)'] ?></button></a>
        <a href="Course_Report_Topics_not_covered.php?edit=<?php echo $program_name ?>"><button><?= $translations['Topics not covered'] ?></button></a>
        <a href="Course_Report_Course_Improvement_Plan_if_any.php?edit=<?php echo $program_name ?>"><button><?= $translations['Course Improvement Plan (if any)'] ?></button></a>
      </div>

      <div class="main">

        <div class="header">
          <img
            src="ql-removebg-preview (1).png"
            alt="Logo"
            width="200"
            style="margin-bottom: 20px" />

          <h3><?= $translations['Course Report'] ?></h3>
          <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
        </div>

        <?php
        if (isset($_SESSION['message'])) {
          echo $_SESSION['message'];
          unset($_SESSION['message']);
        }
        ?>

        <h3><?= $translations['Course Report'] ?></h3>
        <form method="post" id="coursesForm">

          <label><?= $translations['Select an item to edit'] ?></label>
          <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
            <option value=""><?= $translations['Select'] ?></option>
            <?php
            // استعلام لجلب جميع الخيارات
            $query = "SELECT * FROM course_outcomes WHERE program_id = '$program_id' AND user_id = '$user_id'";
            $result = mysqli_query($conn, $query);

            // عرض الخيارات
            while ($row_edit = mysqli_fetch_assoc($result)) {
              $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
              echo "<option value='{$row_edit['id']}' $selected>{$row_edit['recommendations']}</option>";
            }
            ?>
          </select>

          <button class="button" type="submit" name="edit_row"><?= $translations['Edit'] ?></button>

          <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>" readonly>

          <div id="programs" class="form-container">
            <h2><?= $translations['Course Learning Outcomes'] ?></h2>
            <table id="coursesTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?= $translations['Program Learning Outcomes'] ?></th>
                  <th><?= $translations['Related PLOs Code'] ?></th>
                  <th><?= $translations['Assessment Methods'] ?></th>
                  <th><?= $translations['Targeted Level'] ?></th>
                  <th><?= $translations['Actual Level'] ?></th>
                  <th><?= $translations['Comment'] ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                // عرض البيانات لتعديلها
                if (isset($_SESSION['cource_report_clos_edit'])) {
                  $cource_report_clos_edit = $_SESSION['cource_report_clos_edit'];
                  foreach ($cource_report_clos_edit['data'] as $key => $value) {
                    echo "
                            <tr class='dataRow'>
                                <td>$key</td>
                                <td><input type='text' name='data[$key][program_outcome]' value='{$value['program_outcome']}' /></td>
                                <td><input type='text' name='data[$key][related_plos_code]' value='{$value['related_plos_code']}' /></td>
                                <td><input type='text' name='data[$key][assessment_methods]' value='{$value['assessment_methods']}' /></td>
                                <td><input type='number' name='data[$key][targeted_level]' value='{$value['targeted_level']}' /></td>
                                <td><input type='number' name='data[$key][actual_level]' value='{$value['actual_level']}' /></td>
                                <td><input type='text' name='data[$key][comment]' value='{$value['comment']}' /></td>
                            </tr>";
                  }
                }
                ?>
              </tbody>
            </table>

            <h3><?= $translations['Recommendations'] ?></h3>
            <textarea name="recommendations"><?= htmlspecialchars(isset($cource_report_clos_edit['recommendations']) ? $cource_report_clos_edit['recommendations'] : '') ?></textarea>

            <button name="update" class="nav-button" type="submit"><?= $translations['Update'] ?></button>
            <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Topics_not_covered.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
            <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Student_Results.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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