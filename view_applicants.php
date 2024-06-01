<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applicants</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-3">
        <h2>Applicant Details</h2>
        <!-- Filter form -->
        <form method="get" action="">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="entryType">Filter by Entry Type:</label>
                    <select class="form-control" name="entryType">
                        <option value="">All</option>
                        <option value="direct">Direct Entry</option>
                        <option value="indirect">Indirect Entry</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="level">Filter by Level:</label>
                    <select class="form-control" name="level">
                        <option value="">All</option>
                        <option value="certificate">Certificate</option>
                        <option value="diploma">Diploma</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="course">Filter by Course:</label>
                    <select class="form-control" name="course">
                        <option value="">All</option>
                        <!-- Populate courses dynamically -->
                        <?php
                        // Your PHP code to populate courses goes here
                        $courses = array(
                            "Certificate in Medical Laboratory Techniques",
                            "Certificate in Pharmacy",
                            "Certificate in Nursing",
                            "Certificate in Midwifery",
                            "Certificate In Baking",
                            "Certificate In Cookery",
                            "Certificate In Juice Processing",
                            "Certificate in Records and Information Management",
                            "National Certificate in Finance and Accounting",
                            "National Certificate in Public Administration and Management",
                            "National Certificate in Hotel and Institutional Catering",
                            "Diploma In Clinical Medicine and Community Health",
                            "Diploma in Nursing (Extension)",
                            "Diploma in Midwifery (Extension)",
                            "Diploma in Pharmacy",
                            "Diploma in Medical Laboratory Techniques",
                            "Diploma in Hotel and Institutional Catering",
                            "Diploma in Records and Information Management"
                        );
                        foreach ($courses as $course) {
                            echo "<option value=\"$course\">$course</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="academicSession">Filter by Academic Session:</label>
                    <select class="form-control" name="academicSession">
                        <option value="">All</option>
                        <option value="2024/2025">2024/2025</option>
                        <option value="2025/2026">2025/2026</option>
                        <option value="2026/2027">2026/2027</option>
                        <option value="2027/2028">2027/2028</option>
                        <option value="2029/2030">2029/2030</option>
                        <option value="2031/2032">2031/2032</option>
                        <option value="2033/2034">2033/2034</option>
                        <option value="2035/2036">2035/2036</option>
                        <option value="2037/2038">2037/2038</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="search">Search by Applicant Code:</label>
                    <input type="text" class="form-control" name="search" placeholder="Enter Applicant Code">
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary">Filter & Search</button>
                </div>
            </div>
        </form>

        <!-- Applicant details table -->
        <table class="table table-bordered mt-3">
            <thead class="thead-light">
                <tr>
                    <th>SN</th>
                    <th>Surname</th>
                    <th>Given Name</th>
                    <th>Sex</th>
                    <th>DOB</th>
                    <th>Age</th>
                    <th>Entry Type</th>
                    <th>Level</th>
                    <th>Course</th>
                    <th>Telephone</th>
                    <th>District</th>
                    <th>Village</th>
                    <th>Next of Kin</th>
                    <th>Next of Kin Telephone</th>
                    <th>Relationship</th>
                    <th>Application Date</th>
                    <th>Applicant Code</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include your database connection file here
                $conn = mysqli_connect("localhost", "username", "password", "database");

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Initialize variables for filtering and searching
                $entryType = isset($_GET['entryType']) ? $_GET['entryType'] : '';
                $level = isset($_GET['level']) ? $_GET['level'] : '';
                $course = isset($_GET['course']) ? $_GET['course'] : '';
                $academicSession = isset($_GET['academicSession']) ? $_GET['academicSession'] : '';
                $search = isset($_GET['search']) ? $_GET['search'] : '';

                // Construct the SQL query
                $sql = "SELECT * FROM biodata WHERE 1";
                if ($entryType != '') {
                    $sql .= " AND entryType = '$entryType'";
                }
                if ($level != '') {
                    $sql .= " AND level = '$level'";
                }
                if ($course != '') {
                    $sql .= " AND course = '$course'";
                }
                if ($academicSession != '') {
                    $sql .= " AND academicSession = '$academicSession'";
                }
                if ($search != '') {
                    $sql .= " AND applicantCode = '$search'";
                }

                // Fetch applicants data from the database based on filters and search
                $result = mysqli_query($conn, $sql);

                // Check if there are any applicants
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['SN'] . '</td>';
                        echo '<td>' . $row['surname'] . '</td>';
                        echo '<td>' . $row['givenName'] . '</td>';
                        echo '<td>' . $row['sex'] . '</td>';
                        echo '<td>' . $row['dob'] . '</td>';
                        echo '<td>' . $row['age'] . '</td>';
                        echo '<td>' . $row['entryType'] . '</td>';
                        echo '<td>' . $row['level'] . '</td>';
                        echo '<td>' . $row['course'] . '</td>';
                        echo '<td>' . $row['telephone'] . '</td>';
                        echo '<td>' . $row['district'] . '</td>';
                        echo '<td>' . $row['village'] . '</td>';
                        echo '<td>' . $row['kinName'] . '</td>';
                        echo '<td>' . $row['kinTelephone'] . '</td>';
                        echo '<td>' . $row['kinRelation'] . '</td>';
                        echo '<td>' . $row['applicationDate'] . '</td>';
                        echo '<td>' . $row['applicantCode'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="17">No applicant data available.</td></tr>';
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>