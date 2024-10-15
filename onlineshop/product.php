<?php
    require "conection.php";

    $queryCategory = mysqli_query($con,"SELECT * FROM category");

    if(isset($_GET['keyword'])){
        $queryProduct = mysqli_query($con, "SELECT * FROM product WHERE name LIKE '%$_GET[keyword]%'");
    }

    else if(isset($_GET['category'])){
        $queryGetCategoryId = mysqli_query($con, "SELECT id FROM category WHERE name='$_GET[category]'");
        $categoryId = mysqli_fetch_array($queryGetCategoryId);
        
        $queryProduct = mysqli_query($con, "SELECT * FROM product WHERE category_id='$categoryId[id]'");
    }
    else{
        $queryProduct = mysqli_query($con, "SELECT * FROM product");
    }

    $countData = mysqli_num_rows($queryProduct);

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

    <div class="container-fluid banner-product d-flex align-items-center">
        <div class="container">
            <h1 class="text-white smoke text-center">Product</h1>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <h3>Category</h3>
            <ul class="list-group">
                
        <?php while($category = mysqli_fetch_array($queryCategory)) {?>
            <a class="no_decoration" href="product.php?category=<?php echo $category['name']?>">
                <li class="list-group-item"><?php echo $category['name'];?></li>
            </a>
            <?php } ?>

            </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Product</h3>
                <div class="row">
                    <?php 
                        if($countData<1){
                            ?>
                            <h5 class="text-center my-5">No Found</h5>
                            <?php
                        }
                    ?>
                    <?php  while($product = mysqli_fetch_array($queryProduct)) { ?>
                    <div class="col-md-4 mb-3">
                          <div class="card h-100">
                            <div class="image-box">
                            <img class="card-img-top" src="image/<?php echo $product['picture']?>" alt="...">
                            </div>
                              <div class="card-body">
                                <h4 class="card-title"><?php echo $product['name'];?></h4>
                               <p class="card-text text-truncate"><?php echo $product['detail'];?></p>
                             <p class="card-text text-price">Rp <?php echo $product['price'];?></p>
                           <a href="product-detail.php?name=<?php echo $product['name'];?>" 
                           class="btn color1 text-white smoke">See Details</a>
                             </div>
                         </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php require "footer.php";?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>