<?php
    require "conection.php";
    $queryProduct = mysqli_query($con,"SELECT id, name, price, picture, detail FROM product LIMIT 9")
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
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white smoke">

           <div class="col-md-8 offset-md-2">
            <form method="get" action="product.php">
                <div class= "input-group input-group-lg my-4" >
                    <input type="text" class="form-control" placeholder="Product Name" aria-label="Search"
                    aria-describedby="basic-addon2" name="keyword">    
                    <button type="submit" class="btn color2">Search</button>
                </div>
            </form>
           </div>
        </div>
    </div>

       

        <div class="container-fluid color2 py-5">
            <div class="container text-center">
                <h3>About Us</h3>
                <p class="fs-5  mt-3">
                Lionex Shop is an online web shop that provides a variety of men's clothing. You can access this web for free and you can also become an admin of the web. Customers can buy clothes by contacting whatsapp from the lionex to ask about the products listed on the web and buy them through there.
</p>
            </div>
        </div>

        <div class="container-fluid py-5">
            <div class="container text-center">
                <h1>Product</h1>
                
                <div class="row mt-5">
                       <?php while($data = mysqli_fetch_array($queryProduct)){  ?>
                         <div class="col-sm-6 col-md-4 mb-3">
                          <div class="card h-100">
                            <div class="image-box">
                            <img class="card-img-top" src="image/<?php echo $data['picture'];?>" alt="...">
                            </div>
                              <div class="card-body">
                                <h4 class="card-title"><?php echo $data['name']?></h4>
                               <p class="card-text text-truncate"><?php echo $data['detail']?></p>
                             <p class="card-text text-price">Rp <?php echo $data['price']?></p>
                             </div>
                         </div>
                       </div>
                       <?php }?>
                   </div>
                    <a class="btn btn-outline-primary mt-3 p-3 fs-4" href="product.php">See More</a>
               </div>
            </div>
<?php require "footer.php";?>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>
