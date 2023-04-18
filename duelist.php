<?php
session_start();
if (!isset($_SESSION['logged']))
    header("Location: index.php");
include_once "connect.php";
$sql = "SELECT `admno`, `name`,`class`,`section`, `fname`, `balance`, `phn` FROM `accounts` JOIN `student` ON `accounts`.`sid`=`student`.`id` WHERE `balance`>0 ORDER BY CASE 
WHEN `class`='NUR' THEN 1
WHEN `class`='LKG' THEN 2
WHEN `class`='UKG' THEN 3
WHEN `class`='I' THEN 4
WHEN `class`='II' THEN 5
WHEN `class`='III' THEN 6
WHEN `class`='IV' THEN 7
WHEN `class`='V' THEN 8
WHEN `class`='VI' THEN 9
WHEN `class`='VII' THEN 10
WHEN `class`='VIII' THEN 11
WHEN `class`='IX' THEN 12
WHEN `class`='X' THEN 13
END ASC; ";
$result = mysqli_query($conn, $sql);
if ($result) {
    $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
    if(isset($_GET['sort']) && $_GET['sort']!="All")
    {
        function arFilter($row){
            return $row['class']==$_GET['sort'];
        }
        $data=array_filter($data,"arFilter");
    }
}

$classes= ["All", "NUR", "LKG", "UKG", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X"];
// echo var_dump($classes);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Due List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body style="min-height: 90vh; min-width:90vw;">
    <?php
    include_once "nav.php";
    ?>
    <div class="col-3 mx-auto text-center m-3">
        <button class="btn btn-primary" onclick="printDiv()">Print</button>
    </div>
    <div class="container justify-content-center text-center" id="dueList" style="max-height: 77vh;">
        <h1 class="col-6 text-center mx-auto pt-3 pb-2">Due List</h1>
        <div class="col-3 mx-auto mb-3">
            <form action="" method="get" id="sortForm">
                <label for="sort">Class</label> 
                <select class="form-select" name="sort" id="sort">
                    <?php foreach($classes as $class): ?>
                        <option value="<?= $class ?>" <?= isset($_GET['sort'])&&$_GET['sort']==$class?'selected':'' ?>><?= $class ?></option>
                        <?php endforeach ?>
                </select>
            </form>
        </div>
        <div class="col" id="data">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Admno</th>
                        <th scope="col">Name</th>
                        <th scope="col">Class</th>
                        <th scope="col">Section</th>
                        <th scope="col">Father's Name</th>
                        <th scope="col">Amount Due</th>
                        <th scope="col">Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data as $row) {
                        echo "<tr>";
                        foreach ($row as $value)
                            echo "<td>" . ucwords($value) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        let sort=document.getElementById('sort');
        sort.addEventListener('change', ()=>{
            document.getElementById('sortForm').submit();
        });
        function printDiv() {
            const printable = document.getElementById('dueList').innerHTML;
            const original = document.body.innerHTML;
            document.body.innerHTML = printable;
            window.print();
            document.body.innerHTML = original;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>
</html>