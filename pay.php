<?php
session_start();
$getsuccess=false;
if(isset($_POST['pay']))
{
    include_once "connect.php";
    $amt=$_POST['amount'];
    $admno=$_POST['admno'];
    $sql="INSERT INTO `payment`(`sid`,`amt`) VALUES((SELECT `id` FROM `student` WHERE `admno`=$admno),$amt);";
    $result=mysqli_query($conn, $sql);
    $sql2 = " UPDATE `accounts` SET `paid`=`paid`+$amt, `balance`=`balance`-$amt WHERE `sid`=(SELECT `id` FROM `student` WHERE `admno`=$admno);";
    $result2=mysqli_query($conn,$sql2);
    if($result && $result2)
    {
        $sql="SELECT * FROM `payment` ORDER BY `id` DESC LIMIT 1";
        $result=mysqli_query($conn,$sql);
        $row_data=mysqli_fetch_row($result);
        $_SESSION['print']=$row_data;
header("Location: print.php");
    }

}

else if(isset($_GET['id']))
{
    include_once "connect.php";
    $id=$_GET['id'];
    $sql="SELECT `admno`, `name`, `class`, `section`, `balance`, `paid` FROM `student` JOIN `accounts` ON `student`.`id`=`accounts`.`sid` WHERE `student`.`id`=$id";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $sql="SELECT * FROM `payment` WHERE `sid`=$id";
    $result=mysqli_query($conn,$sql);
    if($result)
    {
        $rows=mysqli_fetch_all($result);
        $getsuccess=true;
    }
}
$include="payment.php";
include_once "search.php";
if($getsuccess)
    {
        echo "<script>getDetails(".json_encode($row).",".json_encode($rows).")</script>";
    }
       
$_SESSION['page']='payment';
//unset($_SESSION['payment']);
?>

