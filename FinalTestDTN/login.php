<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="./CSS/login.css">
  <script type="text/javascript" src = "/DTN_Test_PHP/FinalTestDTN/JS/jquery-3.2.1.js"></script>
</head>
<body>
  <div class="login-page">
    <div class="form">
      <form class="login-form" method="post">
        <input type="text" placeholder="username" id="username" name="username" required />
        <script language="javascript">
          $('#username').keyup(function(){
            var username = $('#username').val();
            if (username !== '') {
              $.post(
                'checkuser.php',
                {username:username},
                function(result){
                  if (result=="empty") {
                    $('#status1').hide();
                  }else{
                    $('#status1').html(result);
                  }
                });
            }else{
              $('#status1').hide();
            }
          });

        </script>
        <div id="status1" style="color: red;"></div>
        <input type="password" placeholder="password" id="password" name="password" required= />
        <button name="signin">login</button>
        <p class="message">Not registered? <a href="register.php">Create an account</a></p>
        <div id="status2" style="color: red;"></div>
      </form>
    </div>
  </div>
</body>
</html>
<?php
session_start();
if ($_SESSION['username'] == true) {
  header('Location: MonthlyBudget.php');
}
if (isset($_POST['signin'])) {
  $username = isset($_POST['username']) ? $_POST['username'] : FALSE;
  $password = isset($_POST['password']) ? $_POST['password'] : FALSE;
  $username = stripcslashes($username);
  $password = stripcslashes($password);
  $con = new mysqli("localhost", "root", "namhoang", "budgetdb");
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  } else {
    $search = mysqli_query($con, "SELECT * FROM users WHERE user_name = '$username' and password = '$password'");
    if (!$search || mysqli_num_rows($search) == 0) {

      echo "<script language='javascript'>$('#status2').html('Username or password are incorrect !')</script>";
    }else{
      $_SESSION['username'] = $username;
      header('Location: MonthlyBudget.php');
    }
  }
  
}
?>