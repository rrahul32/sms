<?php
session_start();
if (!isset($_SESSION['logged']))
    header("Location: index.php");
// form post
$admfeevalid = true;
$admvalid = true;
$phvalid = true;
$monfeevalid = true;
$vehfeevalid = true;
$added = false;
$duplicate=false;
if (isset($_POST['submit'])) {
    $admno = $_POST['admno'];
    $phno = $_POST['phn'];
    $admfee = $_POST['admfee'];
    $monfee = $_POST['monfee'];
    $vehfee = $_POST['vehfee'];
    if (!preg_match("/^[0-9]*$/", $admno))
        $admvalid = false;
    if (!preg_match("/^[0-9]*$/", $phno) || strlen($phno) < 10)
        $phvalid = false;
    if (!preg_match("/^[0-9]*$/", $admfee))
        $admfeevalid = false;
    if (!preg_match("/^[0-9]*$/", $monfee))
        $monfeevalid = false;
    if (!preg_match("/^[0-9]*$/", $vehfee))
        $vehfeevalid = false;
    if ($admfeevalid && $admvalid && $phvalid && $monfeevalid && $vehfeevalid) {
        include_once "connect.php";
        $sql="SELECT * FROM `student` WHERE `admno`=$admno;";
        $result=mysqli_query($conn,$sql);
        $numofrows=mysqli_num_rows($result);
        if($numofrows==0)
        {
        $name = strtolower($_POST['name']);
        $class = $_POST['class'];
        $section = $_POST['section'];
        $fname = strtolower($_POST['fname']);
        $sql = "INSERT INTO `student`(`admno`,`name`,`class`,`section`,`fname`,`phn`,`admfee`,`monfee`,`vehfee`) VALUES($admno,'$name','$class','$section','$fname',$phno,$admfee,$monfee,$vehfee);";
        $result = mysqli_query($conn, $sql);
        if ($result)
            $balance=$admfee+$vehfee+$monfee;
            $sql="INSERT INTO `accounts`(`sid`,`paid`,`balance`) VALUES((SELECT `id` FROM `student` WHERE `admno`=$admno),0,$balance);";
            $result=mysqli_query($conn,$sql);
            if($result)
            {
                $added = true;
            }

        }
        else
        $duplicate=true;
        
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Student</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body style="min-height: 90vh; min-width:90vw; background-color:darkgrey">
    <?php
    include_once "nav.php";
    ?>

    <!-- add student -->
    <div class="container my-5 mx-auto p-5 border justify-content-center bg-light">
        <?php
        if($added)
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Student details added successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        if($duplicate)
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Admission number already exists.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        ?>
        <h3 class="text-center mb-5">Add Student</h3>
        <form action="" method="post">
            <div class="row g-3 align-items-center justify-content-center">
                <div class="col-auto mb-3">
                    <label for="name" class="col-form-label">Name</label>
                    <input required type="text" id="name" class="form-control" name="name">
                </div>
                <div class="col-auto mb-3">
                    <label for="admno" class="col-form-label">Admission No.</label>
                    <input required type="text" id="admno" class="form-control <?php if (!$admvalid) echo 'is-invalid' ?>" name="admno" aria-describedby="admInvalid">
                    <div id="admInvalid" class="invalid-feedback">
                        Please provide a valid number.
                    </div>
                </div>
                <div class="col-auto mb-3">
                    <label for="class" class="col-form-label">Class</label>
                    <select id="class" class="form-select" name="class">
                        <option value="NUR">NUR</option>
                        <option value="LKG">LKG</option>
                        <option value="UKG">UKG</option>
                        <option value="I">I</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                        <option value="VI">VI</option>
                        <option value="VII">VII</option>
                        <option value="VIII">VIII</option>
                        <option value="IX">IX</option>
                        <option value="X">X</option>
                    </select>
                </div>
                <div class="col-auto mb-3">
                    <label for="section" class="col-form-label">Section</label>
                    <select id="section" class="form-select" name="section">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
                <div class="col-auto mb-3">
                    <label for="fname" class="col-form-label">Father's Name</label>
                    <input required type="text" id="fname" class="form-control" name="fname">
                </div>
                <div class="col-auto mb-3">
                    <label for="phn" class="col-form-label">Phone No.</label>
                    <input required type="tel" id="phn" class="form-control <?php if (!$phvalid) echo 'is-invalid' ?>" name="phn" maxlength="10" aria-describedby="phnInvalid">
                    <div id="phnInvalid" class="invalid-feedback">
                        Please provide a valid phone number.
                    </div>
                </div>

                <div class="col-auto mb-3">
                    <label for="admfee" class="col-form-label">Admission Fee</label>
                    <input required type="text" id="admfee" class="form-control <?php if (!$admfeevalid) echo 'is-invalid' ?>" name="admfee" aria-describedby="admfeeInvalid">
                    <div id="admfeeInvalid" class="invalid-feedback">
                        Please provide a valid number.
                    </div>
                </div>
                <div class="col-auto mb-3">
                    <label for="monfee" class="col-form-label">Monthly Fee</label>
                    <input required type="text" id="monfee" class="form-control <?php if (!$monfeevalid) echo 'is-invalid' ?>" name="monfee" aria-describedby="monInvalid">
                    <div id="monInvalid" class="invalid-feedback">
                        Please provide a valid number.
                    </div>
                </div>
                <div class="col-auto mb-3">
                    <label for="vehfee" class="col-form-label">Vehicle Charges</label>
                    <input required type="text" id="vehfee" class="form-control <?php if (!$vehfeevalid) echo 'is-invalid' ?>" name="vehfee" aria-describedby="vehinvalid" value="0">
                    <div id="vehInvalid" class="invalid-feedback">
                        Please provide a valid number.
                    </div>
                </div>
            </div>
            <div class="justify-content-center text-center">
                <button type="submit" class="btn btn-primary" name="submit">Add Student</button>
            </div>
        </form>
    </div>
    <!-- add student close -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>