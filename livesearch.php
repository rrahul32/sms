<?php
session_start();
if(isset($_GET['query']))
{
    include_once "connect.php";
    $query=strtolower($_GET['query']);
    $sql="SELECT `id`,`name`,`class`,`section` FROM `student` WHERE `admno` LIKE '%$query%' OR `name` LIKE '%$query%';";
    $result=mysqli_query($conn,$sql);
    $rows=mysqli_fetch_all($result,MYSQLI_ASSOC);
    if($rows!=null)
    {
        //echo var_dump($rows);
        echo "<ul class='list-group'>";
        foreach($rows as $row)
        {
            echo "<li class='list-group-item'><a href='";
            if(isset($_SESSION['page']) && $_SESSION['page']=='payment')
            echo "pay";
            else
            echo "view";
            echo ".php?id=".$row['id']."'>".ucfirst($row['name'])." Class: ".$row['class']." ".$row['section']."</a></li>";
        }
        echo "</ul>";
    }
    else
    echo "<p>No records found</p>";
}
?>