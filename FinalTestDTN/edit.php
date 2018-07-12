<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./CSS/edit.css">
        <title>Edit Data Page</title>
        <script type="text/javascript">
            function return_home() {
                window.location.href = 'MonthlyBudget.php';
            }
        </script>
    </head>
    <body>
        <fieldset>
            <div id="one">
                &#160; Data Editing Page
            </div>
            <div id="two">
                <div id="two1"> <br>
                    Account <br> <br>
                    Bill ID <br> <br>
                    Bill Name
                    <p>Amount</p>
                    <p>Bill on</p>
                </div>
                <div id="two2">
                    <form method="post">
                        <?php
                        $cat = 0;
                        $paid = 0;
                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];
                            $conn = mysqli_connect('localhost', 'root', 'namhoang', 'budgetdb') or die('Can not connect to mysql');
                            $query = mysqli_query($conn, "SELECT * FROM tblbills WHERE id = '" . $id . "'");
                            if (!isset($query) || $query->num_rows == 0) {
                                echo '<script>alert("Connect database error !");</script>';
                            } else {
                                if ($query->num_rows > 0) {
                                    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                                    $cat = $row['cat_id'];
                                    $paid = $row['is_paid'];
                                    ?>
                                    <p>
                                        &#160; <input type="text" name="account" placeholder="132000" style="width: 20%" readonly /> $
                                    </p>
                                    <p>
                                        &#160; <input type="text" name="bill_id" value="<?php echo $row['id']; ?>" style="width: 15%" readonly />
                                    </p>
                                    <p>
                                        &#160; <input type="text" name="bill_name" value="<?php echo $row['name']; ?>" style="width: 30%" />
                                    </p>
                                    <p>
                                        &#160; <input type="number" name="amount" value="<?php echo $row['amount']; ?>" style="width: 30%"  onkeyup="value = isNaN(parseFloat(value)) ? '' : value" /> $
                                    </p>
                                    <?php
                                }
                            }
                        }
                        ?>

                        <p>
                            &#160;
                            <?php
                            $conn = mysqli_connect('localhost', 'root', 'namhoang', 'budgetdb') or die('Can not connect to mysql');
                            $query = mysqli_query($conn, "SELECT * FROM tblbillcategories");
                            ?>
                            <select name="bill_on" id="category" style="width: 20%">
                                <option value="">-- Select a category --</option>
                                <?php
                                while ($row1 = mysqli_fetch_array($query, MYSQLI_ASSOC)):
                                    ?>
                                    <option <?php
                                    if ($cat == $row1['id']) {
                                        echo 'selected';
                                    }
                                    ?>> <?php echo $row1['cat_name']; ?>  </option>;
                                        <?php
                                    endwhile;
                                    ?>
                            </select>
                        </p>
                        <p>
                            &#160; <input type="checkbox" name="is_paid" id="is_paid" 
                            <?php
                            if ($paid == 1) {
                                echo 'checked';
                            }
                            ?>
                                          />
                            Is Paid ?
                        </p>
                        <p>
                            <input type="submit" name="save" value="Save" class="btn btn-success"/>
                            <input type="button" name="cancel" value="Cancel" class="btn btn-danger" onclick="return_home()"/>
                            <?php
                            if (isset($_POST['save'])) {
                                $billId = isset($_POST['bill_id']) ? $_POST['bill_id'] : FALSE;
                                $billName = isset($_POST['bill_name']) ? $_POST['bill_name'] : FALSE;
                                $amount = isset($_POST['amount']) ? $_POST['amount'] : FALSE;
                                $catId = isset($_POST['bill_on']) ? $_POST['bill_on'] : FALSE;
                                $isPaid = isset($_POST['is_paid']) ? $_POST['is_paid'] : FALSE;
                                if ($isPaid == "on") {
                                    $isPaid = 1;
                                } else {
                                    $isPaid = 0;
                                }
                                switch ($catId) {
                                    case "Personal":
                                        $catId = 1;
                                        break;
                                    case "Family":
                                        $catId = 2;
                                        break;
                                    case "Important":
                                        $catId = 3;
                                        break;
                                }

                                // Kết nối tới cơ sở dữ liệu
                                $con = new mysqli("localhost", "root", "namhoang", "budgetdb");
                                if (mysqli_connect_errno()) {
                                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                } else {
                                    $update = mysqli_query($con, "UPDATE tblbills SET name = '" . $billName . "' ,amount = " . $amount . " ,is_paid = " . $isPaid . " ,cat_id = " . $catId . "  WHERE id = '" . $id . "'");
                                    if (!$update || $update == FALSE) {
                                        ?>
                                        <script>
                                            alert('Fail to update data !');
                                            window.location.href = 'MonthlyBudget.php';
                                        </script>;
                                        <?php
                                    } else {
                                        ?>
                                        }
                                        <script >
                                            alert('Update data successfully !');
                                            window.location.href = 'MonthlyBudget.php';
                                        </script>;
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </p>
                    </form>
                </div>
            </div>
        </fieldset>
    </body>
</html>

