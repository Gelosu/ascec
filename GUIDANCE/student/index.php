<?php
// Establish database connection
$conn = mysqli_connect('localhost', 'root', '', 'hms_db');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare SQL queries
$stmt_dept = mysqli_prepare($conn, "SELECT department_name FROM tbl_department");
$stmt_doctor = mysqli_prepare($conn, "SELECT concat(first_name, ' ', last_name) as name FROM tbl_employee WHERE role = 2");

// Execute SQL queries
mysqli_stmt_execute($stmt_dept);

// Fetch and store results
$result_dept = mysqli_stmt_get_result($stmt_dept);
$departments = array();
while ($row = mysqli_fetch_assoc($result_dept)) {
    $departments[] = $row;
}

// Close the first statement
mysqli_stmt_close($stmt_dept);

// Execute the second query
mysqli_stmt_execute($stmt_doctor);

// Fetch and store results
$result_doctor = mysqli_stmt_get_result($stmt_doctor);
$doctors = array();
while ($row = mysqli_fetch_assoc($result_doctor)) {
    $doctors[] = $row;
}

// Close the second statement
mysqli_stmt_close($stmt_doctor);

// Start session
session_start();

// Check if user is logged in
if (isset($_SESSION['student_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }

    .container {
        width: 500px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .header {
        color: #000000;
        padding: 10px;
        border-bottom: 10px solid #ddd;
        border-radius: 10px 10px 0 0;
    }

    .header h2 {
        margin: 1;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }

    .form-group input[type="text"], .form-group select, .form-group textarea {
        width: 100%;
        height: 40px;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-group textarea {
        height: 100px;
        resize: none;
    }

    .btn-primary {
        background-color: #4CAF50;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #3e8e41;
    }

    .footer {
        background-color: #4CAF50;
        color: #fff;
        padding: 10px;
        border-top: 1px solid #ddd;
        border-radius: 0 0 10px 10px;
        text-align: center;
    }
</style>

<div class="container">
    <div class="header">
        <h2>Appointment Request</h2>
    </div>
    <br>
    <form action="appointment.php" method="post">
        <div class="form-group">
            <label for="patient_name">Patient Name:</label>
            <input type="text" id="patient_name" name="patient_name" required>
        </div>
        <div class="form-group">
            <label for="department">Department:</label>
            <select id="department" name="department" required>
                <option value="">Select Department</option>
                <?php foreach ($departments as $department) { ?>
                    <option value="<?php echo $department['department_name']; ?>"><?php echo $department['department_name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="doctor">Doctor:</label>
            <select id="doctor" name="doctor" required>
                <option value="">Select Doctor</option>
                <?php foreach ($doctors as $doctor) { ?>
                    <option value="<?php echo $doctor['name']; ?>"><?php echo $doctor['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
 <input type="date" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit" name="appointment" class="btn btn-primary">Request Appointment</button>
    </form>

</div>

<!-- Close database connection -->
<?php mysqli_close($conn); ?>