<?php
    require "session.php";
    require "../conection.php";

    $query = mysqli_query($con, "SELECT a.*, b.name AS name_product FROM order_items a JOIN product b ON a.product_id = b.id");
    $totalOrder = mysqli_num_rows($query);

    $queryProduct = mysqli_query($con, "SELECT * FROM product");

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
    <title>Order</title>
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
                Order
            </li>
        </ol>
    </nav>
    <div class="my-5 col-12 col-md-6">
    <h3>Add Order</h3>

    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="name">Name Cust</label>
            <input type="text" id="name_cust" name="name_cust" class="form-control" autocomplete="off" required >
        </div>
        <div>
            <label for="product">Product</label>
            <select name="product" id="product" class="form-control" required >
                <option value="">Select Product:</option>
                <?php
                while($data=mysqli_fetch_array($queryProduct)){
                    ?>
                    <option value="<?php echo $data['id'];?>"><?php echo $data['name'];?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" required>
        </div>
        <div>
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control">
        </div>
        <div>
            <button type="submit" class="btn btn-primary" name="save">Save</button>
        </div>
    </form>

    <?php
        if(isset($_POST['save'])){
            $name_cust = htmlspecialchars($_POST['name_cust']);
            $product = htmlspecialchars($_POST['product']);
            $address = htmlspecialchars($_POST['address']);
            $date = htmlspecialchars($_POST['date']);

            $queryAdd = mysqli_query($con, "INSERT INTO order_items (product_id, address, name_cust, date) VALUES ('$product','$address','$name_cust','$date')");
            if($queryAdd){
                ?>
                <div class="alert alert-primary mt-3" role="alert">
                    Order Saved Successfully
                </div>   
                <meta http-equiv="refresh" content="3; url=order.php"/>
                <?php
            } else {
                echo mysqli_error($con);
            }
        }
    ?>
    </div>
    <div class="mt-3 mb-5">
        <h3>List Order</h3>

        <div class="table-responsive mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product</th>
                        <th>Name Cust</th>
                        <th>Address</th>
                        <th>Date</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($totalOrder == 0){
                            ?>
                             <tr>
                                 <td colspan=6 class="text-center">No Data Order</td>
                            </tr>
                            <?php
                        } else {
                            $total = 1;
                            while($data=mysqli_fetch_array($query)){
                                ?>
                                <tr>
                                    <td><?php echo $total;?></td>
                                    <td><?php echo $data['name_product'];?></td>
                                    <td><?php echo $data['name_cust'];?></td>
                                    <td><?php echo $data['address'];?></td>
                                    <td><?php echo $data['date'];?></td>
                                    <td>
                                        <a href="order-detail.php?p=<?php echo $data['id'];?>" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                                <?php
                                $total++;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
