<?php
    require "session.php";
    require "../conection.php";

    $query = mysqli_query($con, "SELECT a.*, b.name AS name_category FROM product a JOIN  category b ON a.
    category_id=b.id");
    $Totalproduct = mysqli_num_rows($query);

    $queryCategory = mysqli_query($con, "SELECT * FROM category");

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
    <title>Product</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .no-decoration{
        text-decoration: none;
    }
    th{
        border-bottom: 2px solid #000;
    }
    form div{
        margin-bottom:10px;
    }
</style>
<body>
   <?php require "navbar.php";?>
    <div class="container mt-5"> 
    <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
             <li class="breadcrumb-item active" aria-current="page">
                <a href="../adminpanel" class="no-decoration text-muted">
                    <i class="fas fa-home"> </i>Home</a>
            </li>
             <li class="breadcrumb-item active" aria-current="page">
                Product
            </li>
        </ol>
    </nav>
    <div class="my-5 col-12 col-md-6">
    <h3>Add Product</h3>

    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" autocomplete=off
            required >
        </div>
        <div>
            <label for="category">Category</label>
            <select name="category" id="category" class="form-control" required >
                <option value="">Select Category:</option>
                <?php
                while($data=mysqli_fetch_array($queryCategory)){
                    ?>
                    <option value="<?php echo $data['id'];?>"><?php echo $data['name'];?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" class="form-control" name="price" required>
        </div>
        <div>
            <label for="picture">Picture:</label>
            <input type="file" name="picture" id="picture" class="form-control">
        </div>
        <div>
            <label for="detail">Detail:</label>
            <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
        </div>
        <div>
            <label for="stock_availability">Stock Availability:</label>
            <select name="stock_availability" id="stock_availability" class="form-control">
                <option value="available">Available</option>
                <option value="soldout">Soldout</option>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary" name="save">Save</button>
        </div>
    </form>

    <?php
        if(isset($_POST['save'])){
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
             }
            else{
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
                        }
                    }
                }

                $queryAdd = mysqli_query($con,"INSERT INTO product (category_id, name, price, picture, detail, stock_availability) VALUES ('$category','$name','$price',
                 '$new_name','$detail','$stock_availability')");

                 if($queryAdd){
                    ?>
                    <div class="alert alert-primary mt-3" role="alert">
                    Product Saved Successfully
                   </div>   
                   <meta http-equiv="refresh" content="3; url=product.php"/>
                   <?php
                 }
                 else{
                    echo mysqli_error($con);
                 }
            }
        }
    ?>
    </div>
    <div class="mt-3 mb-5">
    <h3>List Product</h3>

    <div class="table-responsive mt-5"></div>
    <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock Available</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($Totalproduct==0){
                            ?>
                             <tr>
                                 <td colspan=6 class="text-center">No Data Product</td>
                            </tr>
                            <?php
                        }
                        else{
                            $Total = 1;
                            while($data=mysqli_fetch_array($query)){
                                ?>
                                <tr>
                                    <td><?php echo $Total;?></td>
                                    <td><?php echo $data['name'];?></td>
                                    <td><?php echo $data['name_category'];?></td>
                                    <td><?php echo $data['price'];?></td>
                                    <td><?php echo $data['stock_availability'];?></td>
                                    <td>
                                    <a href="product-detail.php?p=<?php echo $data['id'];?>"
                                    class="btn btn-info"><i class="fas fa-edit"></i></a>
                                </td>
                                </tr>
                                <?php
                                $Total++;
                            }
                        }
                    ?>
                </tbody>
          </table>
    </div>



     <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
     <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>