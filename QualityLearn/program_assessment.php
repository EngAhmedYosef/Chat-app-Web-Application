<?php
include_once "conn.php";
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location:login.php');
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QualityLearn - PLOs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #b3c6d1;
        }

        .container {
            display: flex;
            flex-direction: row;
            height: 100vh;
        }

        .sidebar {
            background-color: #b3c6d1;
            width: 20%;
            padding: 10px;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.2);
        }

        .sidebar button {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #003f8a;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            text-align: left;
            border-radius: 5px;
        }

        .sidebar button:hover {
            background-color: #0073e6;
        }


        .content {
            width: 80%;
            padding: 20px;
        }

        .header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #003f8a;
        }

        .header button {
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
        }

        .header button:hover {
            background-color: #002244;
        }

        .table-container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #003f8a;
            text-align: center;
            padding: 8px;
            font-size: 14px;
        }

        table th {
            background-color: #003f8a;
            color: white;
        }

        .section-title {
            background-color: #d6d7d8;
            font-weight: bold;
            text-align: left;
            padding: 5px;
            border: 1px solid #003366;
        }

        .textarea-container {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .textarea-container textarea {
            width: 100%;
            height: 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
        }

        .navigation-buttons {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            gap: 10px;
        }

        .nav-button {
            padding: 10px 20px;
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .nav-button:hover {
            background-color: #002244;
        }

        /* تنسيق الفقرات */
        .section-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $program_learning_outcomes = $_POST['program_learning_outcomes'] ?? [];
        $assessment_methods = $_POST['assessment_methods'] ?? [];
        $targeted_performance = $_POST['targeted_performance'] ?? [];
        $assessment_results = $_POST['assessment_results'] ?? [];


        $errors = [];
        $successCount = 0;

        for ($i = 0; $i < count($program_learning_outcomes); $i++) {
            // Validate inputs
            $plo = mysqli_real_escape_string($conn, $program_learning_outcomes[$i] ?? '');
            $method = mysqli_real_escape_string($conn, $assessment_methods[$i] ?? '');
            $target = mysqli_real_escape_string($conn, $targeted_performance[$i] ?? '');
            $result = mysqli_real_escape_string($conn, $assessment_results[$i] ?? '');


            if (!empty($plo) && !empty($method) && !empty($target) && !empty($result)) {
                $sql = "INSERT INTO plos_assessment 
                        (user_id,program_learning_outcome, assessment_method, targeted_performance, assessment_result) 
                        VALUES ('$user_id','$plo', '$method', '$target', '$result')";

                if ($conn->query($sql)) {
                    $successCount++;
                } else {
                    $errors[] = "Error for PLO $plo: " . $conn->error;
                }
            } else {
                $_SESSION['message'] = 'Error occurred while inserting data.';
            }
        }

        // Display result messages
        if ($successCount > 0) {
            echo "<p>$successCount records created successfully.</p>";
        }
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        }


        $strength = mysqli_real_escape_string($conn, $_POST['strengths']  ?? '');
        $improvement = mysqli_real_escape_string($conn, $_POST['improvements'] ?? '');

        if (!empty($strength) && !empty($improvement)) {
            $sql = "INSERT INTO strength_improvement 
                    (user_id,strength, improvement) 
                    VALUES ('$user_id', '$strength', '$improvement')";

            if ($conn->query($sql)) {

                $_SESSION['message'] = 'Records created successfully!';
            } else {
                $_SESSION['message'] = 'Error occurred while inserting data.';
            }
        }

        header("location: PLOS.php");
        exit;
    }
    ?>

    <div class="container">
        <div class="sidebar">
            <!-- <button onclick="showSection('ProgramSpecification.html')">Program Assessment</button> -->
            <a href="program_assessment.php">
                <button>Program Assessment</button>
            </a>
            <a href="PLOs.php">
                <button>Program Learning Outcomes</button>
            </a>

            <!-- <button onclick="showSection('ProgramStatistics')">Program Learning Outcomes</button> -->
            <!-- <button onclick="showSection('assessment')">Students Evaluation Of Courses</button> -->
            <a href="StudentEv.php">
                <button>Students Evaluation Of Courses</button>

            </a>
            <a href="Students_Evaluation_of_progrm_Q.php">
                <button>Students Evaluation Of Program Quality</button>
            </a>
            <a href="Scientific_research_and_innovation.php">
                <button>Scientific Research And Innovation</button>
            </a>
                        <a href="Annual_Program_Report_Program_Assessment_Community_Partnership.php">
                <button>Community Partnership</button>
            </a>
            <!-- <button onclick="showSection('kpis')">Students Evaluation Of Program Quality</button>
            <button onclick="showSection('challenges')">Scientific Research And Innovation</button>
            <button onclick="showSection('development')">Community Partnership</button>-->
            <button onclick="showSection('approval')">Other Evaluation</button> 

        </div>
        <div class="content">
            <div class="header">
                <h1>QualityLearn</h1>
                <button>Log Out</button>
            </div>
            <form action="" method="post">
                <div class="table-container">
                    <h2> 1. Program Learning Outcomes Assessment and analysis according to PLOs assessment plan</h2>
                    <?php

                    if (isset($_SESSION['message'])) {
                        echo "<p>" . $_SESSION['message'] . "</p>";
                        unset($_SESSION['message']);
                    }
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Program Learning Outcomes</th>
                                <th>Assessment Methods (Direct and Indirect)</th>
                                <th>Targeted Performance (%)</th>
                                <th>Assessment Results</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="section-title">Knowledge and Understanding</td>
                            </tr>
                            <tr>
                                <td>k1</td>
                                <td><input name="program_learning_outcomes[]" type="text" /></td>
                                <td><input name="assessment_methods[]" type="text" /></td>
                                <td><input name="targeted_performance[]" type="text" /></td>
                                <td><input name="assessment_results[]" type="text" /></td>
                            </tr>
                            <tr>
                                <td>k2</td>
                                <td><input name="program_learning_outcomes[]" type="text" /></td>
                                <td><input name="assessment_methods[]" type="text" /></td>
                                <td><input name="targeted_performance[]" type="text" /></td>
                                <td><input name="assessment_results[]" type="text" /></td>
                            </tr>
                            <tr>
                                <td>k3</td>
                                <td><input name="program_learning_outcomes[]" type="text" /></td>
                                <td><input name="assessment_methods[]" type="text" /></td>
                                <td><input name="targeted_performance[]" type="text" /></td>
                                <td><input name="assessment_results[]" type="text" /></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="section-title">Skills</td>
                            </tr>
                            <tr>
                                <td>s1</td>
                                <td><input name="program_learning_outcomes[]" type="text" /></td>
                                <td><input name="assessment_methods[]" type="text" /></td>
                                <td><input name="targeted_performance[]" type="text" /></td>
                                <td><input name="assessment_results[]" type="text" /></td>
                            </tr>
                            <tr>
                                <td>s2</td>
                                <td><input name="program_learning_outcomes[]" type="text" /></td>
                                <td><input name="assessment_methods[]" type="text" /></td>
                                <td><input name="targeted_performance[]" type="text" /></td>
                                <td><input name="assessment_results[]" type="text" /></td>
                            </tr>
                            <tr>
                                <td>s3</td>
                                <td><input name="program_learning_outcomes[]" type="text" /></td>
                                <td><input name="assessment_methods[]" type="text" /></td>
                                <td><input name="targeted_performance[]" type="text" /></td>
                                <td><input name="assessment_results[]" type="text" /></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="section-title">Values, Autonomy, and Responsibility</td>
                            </tr>
                            <tr>
                                <td>v1</td>
                                <td><input name="program_learning_outcomes[]" type="text" /></td>
                                <td><input name="assessment_methods[]" type="text" /></td>
                                <td><input name="targeted_performance[]" type="text" /></td>
                                <td><input name="assessment_results[]" type="text" /></td>
                            </tr>
                            <tr>
                                <td>v2</td>
                                <td><input name="program_learning_outcomes[]" type="text" /></td>
                                <td><input name="assessment_methods[]" type="text" /></td>
                                <td><input name="targeted_performance[]" type="text" /></td>
                                <td><input name="assessment_results[]" type="text" /></td>
                            </tr>
                            <tr>
                                <td>v3</td>
                                <td><input name="program_learning_outcomes[]" type="text" /></td>
                                <td><input name="assessment_methods[]" type="text" /></td>
                                <td><input name="targeted_performance[]" type="text" /></td>
                                <td><input name="assessment_results[]" type="text" /></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="textarea-container">
                        <div>
                            <label for="strengths" class="section-label"><strong>2. Strengths:</strong></label>
                            <textarea name="strengths" id="strengths"></textarea>
                        </div>
                        <div>
                            <label for="improvements" class="section-label"><strong>3. Aspects that need improvement with priorities:</strong></label>
                            <textarea name="improvements" id="improvements"></textarea>
                        </div>
                    </div>

                    <div class="navigation-buttons">
                        <button class="nav-button">←</button>
                        <button name="submit" type="submit" class="nav-button">→</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>