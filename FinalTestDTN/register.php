<!DOCTYPE html>
<html>
<head>
  <title>Create An Account</title>
  <link rel="stylesheet" type="text/css" href="./CSS/login.css">
  <script type="text/javascript" src = "/DTN_Test_PHP/FinalTestDTN/JS/jquery-3.2.1.js"></script>
</head>
<body>
  <div class="login-page">
    <div class="form">
      <form class="register-form" method="post" action="#">
        <input type="text" placeholder="username" name="username" id="username" required/>
        <div id="status3" style="color: red;"></div>
        <script language="javascript">
          $('#username').keyup(function(){
            var username = $('#username').val();
            if (username !== '') {
              $.post(
                'checknewuser.php',
                {username:username},
                function(result){
                  if (result=="empty") {
                    $('#status3').hide();
                  }else{
                    $('#status3').show();
                    $('#status3').html(result);
                  }
                });
            }else{
              $('#status3').hide();
            }
          });
        </script>

        <input type="password" placeholder="password" name="password" id="password" required />
        <div id="status4" style="color: red;"></div>
        <script language="javascript">
          $('#password').keyup(function(){
            var password = $('#password').val();
            if (password !== '') {
              $.post(
                'checknewpassword.php',
                {password:password},
                function(result){
                  if (result=="empty") {
                    $('#status4').hide();
                  }else{
                    $('#status4').show();
                    $('#status4').html(result);
                  }
                });
            }else{
              $('#status4').hide();
            }
          });
        </script>

        <input type="text" placeholder="email address" id="email" name="email" required />
        <div id="status5" style="color: red;"></div>
        <script language="javascript">
          $('#email').keyup(function(){
            var email = $('#email').val();
            if (email !== '') {
              $.post(
                'checknewemail.php',
                {email:email},
                function(result){
                  if (result=="empty") {
                    $('#status5').hide();
                  }else{
                    $('#status5').show();
                    $('#status5').html(result);
                  }
                });
            }else{
              $('#status5').hide();
            }
          });
        </script>
        <button type="submit" name="submit">create</button>
        <p class="message">Already registered? <a href="login.php">Sign In</a></p>
      </form>
      <div id="status6" style="color: red;"></div>
      <div id="status7" style="color: green;"></div>
    </div>
  </div>
  <p id="#">
    <?php
    if (isset($_POST['submit'])) {
      if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $con = new mysqli("localhost", "root", "namhoang", "budgetdb");
        if (mysqli_connect_errno()) {
          echo "<script language='javascript'>$('#status6').html('Failed to connect to MySQL');</script>";
        } else {
          // Khởi tạo flag = true là được phép thêm người dùng mới
          $flag = true;
          $searchuser = mysqli_query($con, "SELECT * FROM users WHERE user_name = '$username'");
          if (!$searchuser && mysqli_num_rows($searchuser) == 0) {

          }else if(mysqli_num_rows($searchuser) == 1){
            echo "<script language='javascript'>$('#status6').html('Username has already existed !');</script>";
            $flag = false;
          }

          if (strlen($password) < 8) {
            echo "<script language='javascript'>$('#status6').html('Password must at least 8 characters !');</script>";
            $flag = false;
          }

          $searchemail = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
          if (!$searchemail && mysqli_num_rows($searchemail) == 0) {

          }else if(mysqli_num_rows($searchemail) == 1){
            echo "<script language='javascript'>$('#status6').html('Email has already existed !');</script>";
            $flag = false;
          }

          // Qua 2 bước kiểm tra, nếu flag vẫn bằng true thì tiến hành thêm user mới.
          if ($flag == true) {
            $insert = mysqli_query($con, "INSERT INTO users VALUES ('".$username."','".$password."','".$email."') ");
            if ($insert == true) {
              echo "<script language='javascript'>$('#status7').html('Create new account successfully !');</script>";
            }else{
              echo "<script language='javascript'>$('#status6').html('Fail to create new account !');</script>";
            }
          }
        }
      }
    }
    ?>
  </p>
</body>
</html>