<?php
session_start();

if (isset($_POST['appointment'])) {
  $appointment_id = 'APT-'.rand(1000, 9999);
  $patient_name = $_POST['patient_name'];
  $department = $_POST['department'];
  $doctor = $_POST['doctor'];
  $date = $_POST['date'];
  $time = $_POST['time'];
  $message = $_POST['message'];
  $status = 'Pending';

  $conn = mysqli_connect('localhost', 'root', '', 'hms_db');
  $query = "INSERT INTO tbl_appointment (appointment_id, patient_name, department, doctor, date, time, message, status) VALUES ('$appointment_id', '$patient_name', '$department', '$doctor', '$date', '$time', '$message', '$status')";
  mysqli_query($conn, $query);

  $success = 'Appointment request sent successfully!';
}

?>

<?php if (isset($success)) { echo $success; } ?>