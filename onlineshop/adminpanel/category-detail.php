<?php
    require "session.php";
    require "../conection.php";

   $id = $_GET['p'];

   $query = mysqli_query($con, "SELECT * FROM category WHERE id='$id'");
   $data = mysqli_fetch_array($query);
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Detail</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
    <?php require "navbar.php";?>
    <div class="container  mt-5">
        <h2>Category Detail</h2>
        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="category">category</label>
                    <input type="text" name="category" id="category" class="form-control" value="<?php
                echo $data ['name'];?>">
                </div>
                <div class="mt-5 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="updateBtn">Update</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>
            <?php
            if(isset($_POST['updateBtn'])){
                $category = htmlspecialchars($_POST['category']);

                if ($data['name']==$category){
                    ?>
                      <meta http-equiv="refresh" content="0; url=category.php"/>
                    <?php
                }
                else{
                    $query = mysqli_query($con, "SELECT * FROM category WHERE name='$category'");
                    $Totaldata = mysqli_num_rows($query);
                    
                    if($Totaldata > 0){
                     ?>
                        <div class="alert alert-warning mt-3" role="alert">
                        categories already exist                       
                        </div>
                     <?php
                    }
                    else{
                        $querySave = mysqli_query($con, "UPDATE category SET name='$category' WHERE
                        id='$id'");
                        if($querySave){
                            ?>
                            <div class="alert alert-primary mt-3" role="alert">
                            Category Update Successfully
                           </div>   
                           
                           <meta http-equiv="refresh" content="1; url=category.php"/>
                            <?php
                        }
                        else{
                            echo mysqli_error($con);
                        }
                    }
                }
            }

            if(isset($_POST['deleteBtn'])){
                $queryCheck  = mysqli_query($con, "SELECT * FROM product WHERE category_id= '$id'");
                $dataCount = mysqli_num_rows($queryCheck);

                if($dataCount>0){
                    ?>
                    <div class="alert alert-warning mt-3" role="alert">
                    Category cannot be deleted because it has a product
                           </div>   
                    <?php
                    die();
                }
                
                $queryDelete = mysqli_query($con, "DELETE FROM category WHERE id='$id'");
                
                if($queryDelete){
                    ?>
                    <div class="alert alert-primary mt-3" role="alert">
                            Category Delete Successfully
                     </div>
                     <meta http-equiv="refresh" content="1; url=category.php"/>
                    <?php
                }
                else{
                    echo mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>
    
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>