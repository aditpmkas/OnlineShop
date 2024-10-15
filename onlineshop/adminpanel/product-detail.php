<?php
    require "session.php";
    require "../conection.php";

   $id = $_GET['p'];

   $query = mysqli_query($con,  "SELECT a.*, b.name AS name_category FROM product a JOIN  
   category b ON a.category_id=b.id WHERE a.id='$id'");
   $data = mysqli_fetch_array($query);

    $queryCategory =  mysqli_query($con, "SELECT * FROM category WHERE id!='$data[category_id]'");

    function generateRandomString($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<style>
    form div{
        margin-bottom:10px;
    }
</style>
<body>
<?php require "navbar.php";?>
<div class="container  mt-5">

    <h2>Product Detail</h2>
    
        <div class="col-12 col-md-6 mb-5">
             <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $data['name']; ?>" class="form-control" autocomplete=off
            required >
        </div>
        <div>
            <label for="category">Category:</label>
            <select name="category" id="category" class="form-control" required >
                <option value="<?php echo $data['category_id'];?>"><?php echo $data
                ['name_category']; ?></option>
                <?php
                while($dataCategory=mysqli_fetch_array($queryCategory)){
                    ?>
                    <option value="<?php echo $dataCategory['id'];?>"><?php echo $dataCategory['name'];?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" class="form-control" value="<?php echo $data['price'];?>" name="price" required>
        </div>
        <div>
            <label for="currentPicture">Product Picture Now:</label>
            <img src="../image/<?php echo $data['picture']?>" alt="" width="260px">
        </div>
        <div>
            <label for="picture">Picture:</label>
            <input type="file" name="picture" id="picture" class="form-control">
        </div>
        <div>
            <label for="detail">Detail:</label>
            <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
                <?php echo $data['detail'];?>
            </textarea>
        </div>
        <div>
            <label for="stock_availability">Stock Availability:</label>
            <select name="stock_availability" id="stock_availability" class="form-control">
                <option value="<?php echo $data['stock_availability']?>"><?php echo $data['stock_availability']?></option>
                <?php 
                    if($data['stock_availability']=='available'){
                        ?>
                        <option value="soldout">soldout</option>
                        <?php
                    }
                    else{
                        ?>
                        <option value="available">available</option>
                        <?php
                    }
                ?>
            </select>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary" name="update">Update</button>
            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
        </div>
    </form>

    <?php
    if(isset($_POST['update'])){
            $name = htmlspecialchars($_POST['name']);
            $category = htmlspecialchars($_POST['category']);
            $price = htmlspecialchars($_POST['price']);
            $detail = htmlspecialchars($_POST['detail']);
            $stock_availability = htmlspecialchars($_POST['stock_availability']);

            $target_dir = "../image/";
            $name_file =  basename($_FILES["picture"]["name"]);
            $target_file = $target_dir . $name_file;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $image_size = $_FILES["picture"]["size"];
            $random_name = generateRandomString(20);
            $new_name = $random_name . "." . $imageFileType;

            if (empty($name) || empty($category) || empty($price)) {    
                $error_message = "Name, Category, Price are required.";
             }else{
                $queryUpdate = mysqli_query($con, "UPDATE product SET category_id='$category' , 
                name='$name' , price='$price' , detail='$detail', stock_availability=
                '$stock_availability' WHERE id=$id");

                if($name_file!=''){
                    if($image_size>10000000){
                        ?>
                         <div class="alert alert-warning mt-3" role="alert">
                         File size exceeds the maximum limit of 10mb!
                         </div>
                        <?php
                    }
                    else{
                        if($imageFileType!= 'jpg' && $imageFileType!= 'png' && 
                        $imageFileType!= 'webp'){
                            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                            Files must be of jpg, png, webp type
                             </div>
                            <?php
                        }
                        else{
                            move_uploaded_file($_FILES["picture"]["tmp_name"], $target_dir . 
                            $new_name);

                            $queryUpdate = mysqli_query($con, "UPDATE product SET picture='$new_name'
                            WHERE id='$id'");

                            if($queryUpdate){
                                ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                 Product Update Successfully
                            </div>

                            <meta http-equiv="refresh" content="1; url=product.php"/>

                             <?php
                            }
                            else{
                                echo mysqli_error($con);
                            }
                        }
                    }
                }
                else {
                    ?>
                    <div class="alert alert-primary mt-3" role="alert">
                         Product Update Successfully
                    </div>
                    <meta http-equiv="refresh" content="1; url=product.php"/>
                    <?php
                }
            }
    }
    if(isset($_POST['delete'])){
        $queryDelete = mysqli_query ($con, "DELETE FROM product WHERE id='$id'");

        if($queryDelete){
            ?>
            <div class="alert alert-primary mt-3" role="alert">
                    Product Delete Successfully
             </div>
             <meta http-equiv="refresh" content="1; url=product.php"/>
            <?php
        }
    }
    ?>

</div>
</div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
