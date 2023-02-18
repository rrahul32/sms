<?php
session_start();
if(!isset($_SESSION['logged']))
header("Location: index.php");
if(isset($_POST['data']))
{
  $_SESSION['print']=explode(',',$_POST['data']);
  //echo var_dump($_SESSION['print']);

}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Print</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <style>
        @page {
            size:auto;
            margin: 0mm;
        }
        
    </style>
<script>
  function titleCase(str) {
   var splitStr = str.toLowerCase().split(' ');
   for (var i = 0; i < splitStr.length; i++) {
       // You do not need to check if i is larger than splitStr length, as your for does that for you
       // Assign it back to the array
       splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
   }
   // Directly return the joined string
   return splitStr.join(' '); 
}
function printDiv(data,id) {
    console.log(data,id);
  const newDiv=document.createElement('div');
  newDiv.innerHTML=`
  <div class="px-5">
    <div class="container text-center my-2">
      <h1 class="mb-0">
        Guru Ram Das Public School
      </h1>
      <h2 class="mb-0">
        English Medium
      </h2>
      <p class="text-muted">Bham</p>
    </div>
    <div class="container justify-content-center border border-dark border-3 mt-2">
    <div class="row mb-3 justify-content-between">
      <div class="col-auto">
        Adm No.: ${id[0]}
      </div>
      <div class="col-auto">
        Date: ${data[3]}
      </div>
    </div>
    <div class="row mb-2 justify-content-between">
      <div class="col-auto">
        Name: ${titleCase(id[1])}
      </div>
      <div class="col-auto">
        Class: ${id[2]}
      </div>
      <div class="col-auto">
        Section: ${id[3]}
      </div>
    </div>
    </div>
    <div class="container my-3 text-center">
    <div class="row border border-dark border-3">
      <div class=" h4 col-8 p-3 mb-0">
Particulars
      </div>
      <div class=" h4 col-4 border-start border-dark border-3 p-3 mb-0">
Amount
      </div>
    </div>
    <div class="row border border-3 border-dark border-top-0" >
    <div class="col-8 p-3" style="height:30vh;">
  <p>Fee</p>
      </div>
      <div class="col-4 border-start border-dark border-3 p-3" style="height: 30vh;">
    ${data[2]}
      </div>
      </div>
      <div class="row border border-3 border-dark border-top-0" >
    <div class="col-8 p-3" >
  <h4>Total</h4>
      </div>
      <div class="col-4 border-start border-dark border-3 p-3">
      ${data[2]}
      </div>
      </div>
    </div>
  <div class="container">
    <p class="text-muted text-end mt-3 pt-5">Signature</p>
  </div>
  </div>
  `;
  document.body.innerHTML=newDiv.innerHTML;
  window.print();
  window.onafterprint= ()=>{
    window.location.replace("pay.php?id=<?=$_SESSION['print'][1]?>");
  }
}
</script>
</head>

<body style="min-height: 90vh; min-width:90vw; background-color:white">

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>

<?php
if(isset($_SESSION['print']))
{
    include_once "connect.php";
    //echo var_dump($_SESSION['print']);
    $sid=$_SESSION['print'][1];
    $sql="SELECT `admno`, `name`, `class`, `section` FROM `student` WHERE `id`=$sid;";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_row($result);
  echo "<script>
  printDiv(".json_encode($_SESSION['print']).",".json_encode($row).");
  </script>";
  unset($_SESSION['print']);
}
?>
