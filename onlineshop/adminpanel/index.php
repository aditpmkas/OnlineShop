<?php
    require "session.php";
    require "../conection.php";

    $queryCategory = mysqli_query($con, "SELECT * FROM category");
    $numberofcategories = mysqli_num_rows($queryCategory);

    $queryProduct = mysqli_query($con, "SELECT * FROM Product");
    $numberofproduct = mysqli_num_rows($queryProduct);

    $queryOrder = mysqli_query($con, "SELECT * FROM order_items");
    $numberoforder = mysqli_num_rows($queryOrder);
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .box{
        border: solid;
    }
    .summary-category{
      background-color: #110;
      color:#fff;  
      border-radius:12px;
    }
    .no-decoration{
        text-decoration: none;
    }
    .no-decoration:hover{
        color: #160;
    }
    .summary-product{
        background-color: #CEBEA5;
        color: #fff;
        border-radius: 12px;
    }
    .summary-order{
        background-color: blue;
        color: #fff;
        border-radius: 12px;
    }
</style>
<body>
    <?php require "navbar.php";?>
     <div class="container mt-5">
     <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
             <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-home"> </i>Home
            </li>
        </ol>
    </nav>
     <h2>hallo <?php echo $_SESSION['username']?></h2>
     <div class="contaier mt-4">
          <div class="row">
              <div class="col-lg-4 col-md-6 col-12 mb-3">
                  <div class="summary-category p-3">
                      <div class="row">
                          <div class="col-6">
                            <i class="fas fa-solid fa-list fa-7x"></i>
                          </div>
                          <div class="col-6">
                            <h3 class="fs-2">Category</h3>
                            <p class="fs-6"><?php echo $numberofcategories; ?> category</p>
                            <p><a href="category.php" class="text-white no-decoration">See details</a></p>
                        </div>
                    </div>
                </div>
            </div>

              <div class="col-lg-4 col-md-6 col-12 mb-3">
                  <div class="summary-product p-3">
                      <div class="row">
                          <div class="col-6">
                            <i class="fa-solid fa-shirt fa-7x"></i>
                          </div>
                         <div class="col-6">
                            <h3 class="fs-2">Product</h3>
                            <p class="fs-6"><?php echo $numberofproduct; ?> Product</p>
                            <p><a href="product.php" class="text-white no-decoration">See details</a></p>
                        </div>
                    </div>
                </div>
            </div>

              <div class="col-lg-4 col-md-6 col-12 mb-3">
                  <div class="summary-order p-3">
                      <div class="row">
                          <div class="col-6">
                            <i class="fa-solid fa-box fa-7x"></i>
                          </div>
                         <div class="col-6">
                            <h3 class="fs-2">Order</h3>
                            <p class="fs-6"><?php echo $numberoforder; ?> Order</p>
                            <p><a href="order.php" class="text-white no-decoration">See details</a></p>
                        </div>
                    </div>
                </div>
            </div>
        
        
        </div>
     </div>
     </div>
     <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
     <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>