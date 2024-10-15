<?php
    require "conection.php";

    $name = htmlspecialchars($_GET['name']);
    $queryProduct = mysqli_query($con, "SELECT * FROM product WHERE name='$name'");
    $product = mysqli_fetch_array($queryProduct);

    $queryProductRelated = mysqli_query($con, "SELECT * FROM product WHERE category_id='$product[category_id]' 
    AND id!='$product[id]' LIMIT 3");

  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online shop</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
<?php require "navbar.php"?>

<div class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 mb-4">
                <img src="image/<?php echo $product['picture'];?>" class="w-100" alt="">
            </div>
            <div class="col-lg-6 offset-lg-1">
                <h1><?php echo $product['name'];?></h1>
                <p class="fs-5">
                    <?php echo $product['detail'];?>
                </p>
                <p class="text-price">
                Rp <?php echo $product['price'];?> 
                </p>
                <p class="fs-5">
                Availability Status: <strong><?php echo $product['stock_availability'];?></strong>
                </p>
            </div>
        </div>
    </div>
</div>

    <div class="container-fluid py-5 color1">
        <div class="container">
            <h2 class="text-center text-white mb-5">Related Products</h2>

            <div class="row">
                <?php while($data=mysqli_fetch_array($queryProductRelated)){ ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <a href="product-detail.php?name=<?php echo $data['name'];?>">
                    <img src="image/<?php echo $data['picture'];?>" class="img-fluid img-thumbnail 
                    related-product-image" alt="">
                </a>
                </div>
                    <?php }?>
            </div>
        </div>
    </div>
    <?php require "footer.php";?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>