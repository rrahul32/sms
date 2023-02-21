<?php 

session_start();
if (!isset($_SESSION['logged']))
    header("Location: index.php");

// MySQL database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'sms';

// Backup folder path
$backupFolder = 'C:\Users\imara\OneDrive\Documents\Onedrive_backup\OneDrive\sms_backup\\';

// Backup file name
$backupFileName = 'sms_backup_' . date('Y-m-d_H-i-s') . '.sql';

// Command to create a backup using mysqldump
$command = "mysqldump -u $dbUsername $dbName > {$backupFolder}{$backupFileName}";
// Execute the command
exec($command);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Backup Database</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body style="min-height: 90vh; min-width:90vw; background-color:darkgrey">
    <?php
    include_once "nav.php";
    echo "<p>Database backup created successfully: {$backupFolder}{$backupFileName}</p>";
    ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>

