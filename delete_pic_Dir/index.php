<?php
$alert = '';
$connect = mysqli_connect('localhost','root','','prectice');
if(isset($_POST['submit'])){
    $file = $_FILES['file']['name'];
    $file_temp = $_FILES['file']['tmp_name'];
    $rand_no = rand(12345,54321);
    $dir = './pics';
    move_uploaded_file($file_temp,$dir.'/'.$rand_no.'-'.$file);
    $query = "INSERT INTO picture_upload(picName)values('$rand_no-$file')";
    $sql = mysqli_query($connect,$query);
    if($sql){
        $alert = '<div class="alert alert-success">Upload Complete</div>';
        header("Refresh:1; url=index.php");
    }else{
        $alert = '<div class="alert alert-danger">Upload Fail</div>';
        header("Refresh:1; url=index.php");
    }
}elseif(isset($_GET['d'])){
    $delete = $_GET['d'];
    $file_name = "./pics/".$_GET['imgName'];
    $del = "DELETE FROM picture_upload WHERE ID = '$delete'";
    $exe = mysqli_query($connect,$del);
    unlink($file_name);
    if($exe){
        $alert = '<div class="alert alert-success">File Deleted</div>';
        header("Refresh:1; url=index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

</head>
<body>

<div class="container mt-5 p-5 text-center">

    <?php echo $alert ;?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="file" name="file" class="form-control" >
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

<hr>

<h1>Pictures </h1>

<div class="row">

<?php
$get_q = "SELECT * FROM picture_upload";
$run = mysqli_query($connect,$get_q);
while($fetch = mysqli_fetch_assoc($run)){
    echo '
    <div style="width: 18rem; margin:10px;">
        <img src="./pics/'.$fetch['picName'].'" style="width:200px;height:100px;" title="'.$fetch['picName'].'" class="card-img-top">
        <div class="card-body">
            <h5 class="card-title">'.substr($fetch['picName'],0,10).'..</h5>
            <a href="index.php?d='.$fetch['ID'].'&imgName='.$fetch['picName'].'" class="btn btn-danger">Delete</a>
        </div>
    </div>

    ';
}
?>

    
</div>

</div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
</body>
</html>