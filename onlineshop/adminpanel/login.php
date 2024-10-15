<?php
    session_start();
    require "../conection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; 
        }
        .main {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            width: 400px;
            padding: 30px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3); 
        }
        .login-box h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #333;
        }
        .login-box form label {
            font-weight: bold;
        }
        .login-box form input[type="text"],
        .login-box form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-box form button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #102C57; 
            color: #fff; 
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease; 
        }
        .login-box form button:hover {
            background-color: #8DECB4; 
        }
        .alert {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="login-box">
            <h2>Login</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit" name="loginbtn">Login</button>
                </div>
            </form>
            <?php
              if(isset($_POST['loginbtn'])){
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
                $countdata = mysqli_num_rows($query);
                $data = mysqli_fetch_array($query);
                
                if($countdata>0){
                    if (password_verify($password,$data['password']))  {
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['login'] = true;
                        header('location: ../adminpanel');
                    }  
                    else{
                        ?>
                        <div class="alert alert-warning" role="alert">
                            Wrong password
                        </div>
                        <?php
                    }                
                }
                else{
                    ?>
                    <div class="alert alert-warning" role="alert">
                        Account not available
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
