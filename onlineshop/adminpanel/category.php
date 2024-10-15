<?php
    require "session.php";
    require "../conection.php";

    $queryCategory = mysqli_query($con, "SELECT * FROM category");
    $numberofcategory = mysqli_num_rows($queryCategory);
    ?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
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
                Category
            </li>
        </ol>
    </nav>
        <div class="my-5 col-12 col-md-6">
            <h3>Add Category</h3>
            
            <form action="" method="post">
                <div>
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" placeholder="input name category"
                    class="form-control">
                </div>
                <div class="mt-2">
                    <button class="btn btn-primary" type="submit" name="save_category">Save</button>
                </div>
            </form>
            <?php
                if(isset($_POST['save_category'])){
                    $category = htmlspecialchars($_POST['category']);
                    
                    $queryExist = mysqli_query($con, "SELECT name FROM category WHERE name='$category'");
                    $totalnewdatacategory = mysqli_num_rows($queryExist);
                    
                    if($totalnewdatacategory > 0){
                        ?>
                        <div class="alert alert-warning mt-3" role="alert">
                        categories already exist                       
                        </div>
                        <?php
                    }
                    else{
                        $querySave = mysqli_query($con, "INSERT INTO category (name) VALUES ('$category')");
                        
                        if($querySave){
                            ?>
                            <div class="alert alert-primary mt-3" role="alert">
                            Category Saved Successfully
                           </div>   
                           
                           <meta http-equiv="refresh" content="1; url=category.php"/>
                            <?php
                        }
                        else{
                            echo mysqli_error($con);
                        }
                    }
                }
                ?>
        </div>
    <div class="mt-3">
        <h2>List Category</h2>
        <div class="table-responsive mt-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($numberofcategory==0){
                        ?>
                    <tr>
                        <td colspan=3 class="text-center">No Data Category</td>
                    </tr>
                    <?php
                    }
                    else{
                        $Total= 1;
                        while($data=mysqli_fetch_array($queryCategory)){
                            ?>
                            <tr>
                                <td><?php echo $Total; ?></td>
                                <td><?php echo $data['name']; ?></td>
                                <td>
                                    <a href="category-detail.php?p=<?php echo $data['id'];?>"
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
    </div>
</div>
    </div>




     <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
     <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>