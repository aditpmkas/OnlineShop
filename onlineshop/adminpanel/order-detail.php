<?php
    require "session.php";
    require "../conection.php";

    $id = $_GET['p'];

    $query = mysqli_query($con, "SELECT a.*, b.name AS name_product FROM order_items a JOIN product b ON a.product_id = b.id WHERE a.id = '$id'");
    $data = mysqli_fetch_array($query);

    $queryProduct =  mysqli_query($con, "SELECT * FROM product WHERE id!='$data[product_id]'");

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
    <title>Order Detail</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<style>
    form div{
        margin-bottom:10px;
    }
</style>
<body>
<?php require "navbar.php";?>
<div class="container mt-5">

    <h2>Order Detail</h2>
    
    <div class="col-12 col-md-6 mb-5">
        <form action="" method="post">
            <div>
                <label for="name">Name Cust</label>
                <input type="text" id="name" name="name" value="<?php echo $data['name_cust']; ?>" class="form-control" autocomplete="off" required >
            </div>
            <div>
                <label for="product">Product:</label>
                <select name="product" id="product" class="form-control" required >
                    <option value="<?php echo $data['product_id'];?>"><?php echo $data['name_product']; ?></option>
                    <?php
                    while($dataProduct=mysqli_fetch_array($queryProduct)){
                        ?>
                        <option value="<?php echo $dataProduct['id'];?>"><?php echo $dataProduct['name'];?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="address">Address:</label>
                <input type="text" class="form-control" value="<?php echo $data['address'];?>" name="address" required>
            </div>
            <div>
                <label for="date">Date:</label>
                <input type="date" class="form-control" value="<?php echo $data['date'];?>" name="date" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" name="update">Update</button>
                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
            </div>
        </form>
    </div>

    <?php
    if(isset($_POST['update'])){
        $name = htmlspecialchars($_POST['name']);
        $product = htmlspecialchars($_POST['product']);
        $address = htmlspecialchars($_POST['address']);
        $date = htmlspecialchars($_POST['date']);

        $queryUpdate = mysqli_query($con, "UPDATE order_items SET product_id='$product', address='$address', name_cust='$name', date='$date' WHERE id=$id");

        if($queryUpdate){
            ?>
            <div class="alert alert-primary mt-3" role="alert">
                Order Updated Successfully
            </div>
            <meta http-equiv="refresh" content="1; url=order.php"/>
            <?php
        } else {
            echo mysqli_error($con);
        }
    }
    if(isset($_POST['delete'])){
        $queryDelete = mysqli_query($con, "DELETE FROM order_items WHERE id='$id'");

        if($queryDelete){
            ?>
            <div class="alert alert-primary mt-3" role="alert">
                Order Deleted Successfully
            </div>
            <meta http-equiv="refresh" content="1; url=order.php"/>
            <?php
        } else {
            echo mysqli_error($con);
        }
    }
    ?>

</div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
