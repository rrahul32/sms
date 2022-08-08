<?php
session_start();
if(isset($_SESSION['logged'])&&$_SESSION['logged']==true)
header("Location: dash.php");
if(isset($_POST['submit']))
{
    include_once "connect.php";
    $uname=$_POST['username'];
    $password=$_POST['password'];
    $sql="SELECT * FROM `login` WHERE `userid`='$uname' AND `password`='$password';";
    $result= mysqli_query($conn,$sql);
    $row=mysqli_fetch_row($result);
    echo var_dump($row); 
    if($row!=null)
    {
        $_SESSION['id']=$row[0];
        $_SESSION['logged']=true;
        header("Location: dash.php");
    }
    else
        $login=false;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
  <body class="d-flex justify-content-center bg-dark align-items-center" style="min-height: 90vh; min-width:90vw">

    <!-- login form -->
    <div class="p-5 m-5 border justify-content-center bg-light">
        <h2 class="text-center text-dark mb-3">Login</h2>
        <div class="row">
            <?php
            if(isset($login)&&$login==false)
            echo '<div class="alert alert-danger" role="alert">
                Incorrect login details! Please try again.
              </div>
              ';
              ?>
        </div>
    <form action="" method="post" >
               <div class="form-floating mb-3">
                <input type="username" class="form-control" id="username" name="username" placeholder="name">
                <label for="username">Username</label>
              </div>
              <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label for="password">Password</label>
              </div>
              <div class="row mx-auto mt-3">
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
              </div>
           
    </form>
</div>
      <!-- login form end -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>    
  </body>
</html>
