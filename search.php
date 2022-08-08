<?php
if(!isset($_SESSION))
session_start();
if (!isset($_SESSION['logged']))
    header("Location: index.php");
$_SESSION['page'] = 'search';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
    <script>

         //capitalise each word
  function capitalise(sentence){
    const words = sentence.split(" ");

for (let i = 0; i < words.length; i++) {
    words[i] = words[i][0].toUpperCase() + words[i].substr(1);
}
return words.join(" ");
  }
  //Live Search
        function showResult(str) {
            if (str.length == 0) {
                document.getElementById("livesearch").innerHTML = "";
                document.getElementById("livesearch").style.border = "0px";
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("livesearch").innerHTML = this.responseText;
                    document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "livesearch.php?query=" + str, true);
            xmlhttp.send();
        }
    </script>
</head>

<body style="min-height: 90vh; min-width:90vw; background-color:darkgrey">
    <?php
    include_once "nav.php";
    ?>
    <div class="container mt-5 mx-auto p-5 border justify-content-center bg-light" style="max-width:50vw">
        <h3 class="text-center">Search Student</h3>
        <div class="row g-3 align-items-center justify-content-center">
            <div class="col-auto">
                <input required type="text" id="keyword" class="form-control" name="keyword" placeholder="Type name or admission no." onkeyup="showResult(this.value)">
                <div id="livesearch"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    <?php
    if (isset($include))
        include_once $include;
    ?>
</body>

</html>