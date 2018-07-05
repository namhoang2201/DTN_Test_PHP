<?php
// Khai báo biến mảng toàn cục, lưu tất cả các checkbox trong table, cả được tích và không được tích
$complete_all = array();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta http-equiv = "X-UA-Compatible" content = "IE=edge">
        <title>Monthly Budget</title>
        <script language = "javascript" src = "jquery-3.2.1.js"></script>
        <script language="javascript">

            // Hàm kiểm tra việc nhập dữ liệu vào form
            function validateForm() {
                var ho = $('#bill_id').val();
                if (ho == "") {
                    alert("Bill ID must not empty !");
                    return false;
                }

                var name = $('#bill_name').val();
                if (name == "") {
                    alert("Bill Name must not empty !");
                    return false;
                }

                var amount = $('#amount').val();
                if (amount == "") {
                    alert("Amount must not empty !");
                    return false;
                }

                var category = $('#category').val();
                if (category == "") {
                    alert("Please select a category !");
                    return false;
                }

                // Gửi dữ liệu bằng ajax
                $.ajax({
                    url: "addNewBill.php",
                    type: "post",
                    dataType: "text",
                    data: {
                        billId: $('#bill_id').val(),
                        billName: $('#bill_name').val(),
                        amount: $('#amount').val(),
                        catId: $('#category').val(),
                        isPaid: isChecked(),
                        sum: $('#sum').val(),
                    }
                    ,
                    success: function (result) {
                        $('#tr1').remove();
                        $('#tr2').remove();
                        $('#mybody').append(result);
                    }
                }
                );
                return true;
            }

            // Hàm lấy giá trị trả về 0 nếu checkbox không được tích, trả về 1 nếu checkbox được tích
            function isChecked() {
                var bit = $('#is_paid')[0].checked;
                if (bit == true) {
                    bit = 1;
                } else {
                    bit = 0;
                }
                return bit;
            }

            // Hàm reset lại form nhập liệu về như trạng thái mặc định
            function reset() {
                document.getElementById("form1").reset();
            }

        </script>

        <link rel="stylesheet" type="text/css" href="1.css">
    </head>
    <body>
        <div id="father">
            <div id="one">
                &#160; Add New Bill
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
                    <form action="#" method="post" name="form1" id="form1">
                        <p>
                            &#160 <input type="text" id="account" value="132000" style="width: 30%" readonly /> $
                        </p>
                        <p>
                            &#160 <input type="text" id="bill_id" value="" style="width: 15%" />
                        </p>
                        <p>
                            &#160 <input type="text" id="bill_name" value="" style="width: 50%" />
                        </p>
                        <p>
                            &#160 <input type="number" id="amount" value="" style="width: 50%"  onkeyup="value = isNaN(parseFloat(value)) ? '' : value" /> $
                        </p>
                        <p>
                            &#160
                            <?php
                            $conn = mysqli_connect('localhost', 'root', '', 'budgetdb') or die('Can not connect to mysql');
                            $query = mysqli_query($conn, "SELECT * FROM tblbillcategories");
                            ?>
                            <select name="bill_on" id="category" style="width: 30%">
                                <option value="">-- Select a category --</option>
                                <?php
                                while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)):
                                    echo "<option>" . $row['cat_name'] . " </option>";
                                endwhile;
                                ?>
                            </select>
                        </p>
                        <p>
                            &#160 <input type="checkbox" name="is_paid" id="is_paid" onsubmit="return isChecked()" />
                            Is Paid ?
                        </p>
                        <p>
                            <!--<button id="add" value="">Add New Bill</button>-->
                            <input type="button" id="add" onclick="validateForm()" value="Add New Bill" />
                            <button id="reset" value="" onclick="reset()">Reset</button>
                        </p>
                    </form>
                </div>
            </div>
            <div id="three">
                &#160 Bill List
            </div>
            <div id="four">
                <form action="<?php echo($_SERVER['PHP_SELF']); ?>" name="form2" method="post">
                    <table border="1" align="center" width="100%" id="mytable">
                        <thead>
                            <tr style="background-color: #FFFF99; text-align: right; table-layout: fixed; width: 100%; ">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Category</th>
                                <th>Complete</th>
                            </tr>
                        </thead>
                        <tbody id="mybody">
                            <?php
                            $total = 0;
                            $conn = mysqli_connect('localhost', 'root', '', 'budgetdb') or die('Can not connect to mysql');
                            $query = mysqli_query($conn, "SELECT * FROM tblbills");
                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                                    $total += (int) $row['amount'];
                                    $id = $row['id'];
                                    $complete = $row['is_paid'];
                                    $category = $row['cat_id'];
                                    switch ($category) {
                                        case 1:
                                            $category = "Personal";
                                            break;
                                        case 2:
                                            $category = "Family";
                                            break;
                                        case 3:
                                            $category = "Important";
                                            break;
                                    }
                                    echo '<tr id= "firstLoad" align="right">';
                                    echo "<td>" . $row['id'] . "</td>";
                                    if ($complete == 0) {
                                        echo "<td>" . $row['name'] . "</td>";
                                    } else {
                                        echo "<td style='text-decoration: line-through;'>" . $row['name'] . "</td>";
                                    }
                                    echo "<td> $ " . (int) $row['amount'] . "</td>";
                                    echo "<td>" . $category . "</td>";
                                    if ($complete == 0) {
                                        echo "<td><input type='checkbox' name='complete[" . $id . "] value = '0'></td>";
                                        // Thêm lần lượt từng checkbox vào mảng toàn thể
                                        $complete_all[$id] = 0;
                                    } else {
                                        echo "<td><input type='checkbox' name='complete[" . $id . "] value = '1' checked></td>";
                                        // Thêm lần lượt từng checkbox vào mảng toàn thể
                                        $complete_all[$id] = 1;
                                    }
                                    echo '</tr>';
                                }
                            }
                            ?>
                            <tr align="right" id="tr1">
                                <td colspan="2">Total</td>
                                <td><?php echo "$ " . $total ?></td>
                                <td colspan="2"></td>
                            </tr>
                            <tr align="right" id="tr2">
                                <td colspan="2">Remain</td>
                                <td> <?php echo "$ " . (132000 - $total); ?></td>
                                <td colspan="2"></td>
                            </tr>
                        </tbody>
                    </table>
                    <p>
                        <input type="hidden" id="sum" value="<?php echo $total ?>"/>
                    </p>
                    <p>
                        &#160 <button type="submit" id="update" name="update">Update</button>
                        <?php
                        if (isset($_POST['update'])) {
                            if (!empty($_POST['complete'])) {
                                // Mảng complete lưu tất cả các checkbox được tích, bao gồm cả sau khi update
                                // Mảng complete là mảng con của complete_all
                                $complete = $_POST['complete'];

                                // Cập nhật, đặt tất cả các checkbox được tích giấ trị bằng 1, lưu vào cơ sở dữ liệu
                                foreach ($complete as $key => $value) {
                                    $con = new mysqli("localhost", "root", "", "budgetdb");
                                    if (mysqli_connect_errno()) {
                                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                    } else {
                                        $update = mysqli_query($con, "UPDATE tblbills SET is_paid = 1 WHERE id = '" . $key . "'");
                                    }
                                }

                                // Đặt tất cả các checkbox không được tích giá trị bằng 0, lưu vào cơ sở dữ liệu
                                // Duyệt toàn bộ mảng complete_all, 
                                foreach ($complete_all as $key => $value) {
                                    // Tìm xem key nào không có trong mảng complete thì đặt value bằng 0
                                    if (!array_key_exists($key, $complete)) {
                                        $con = new mysqli("localhost", "root", "", "budgetdb");
                                        if (mysqli_connect_errno()) {
                                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                        } else {
                                            $update = mysqli_query($con, "UPDATE tblbills SET is_paid = 0 WHERE id = '" . $key . "'");
                                        }
                                    }
                                }
                                // Refresh page

                                echo "<script language='javascript'>alert('Update successfully !')</script>";
                            } else {
                                // Nếu bỏ tích tất cả thì cập nhật tất cả value của mảng complete_all về 0 và cả trong cơ sở dữ liệu

                                $con = new mysqli("localhost", "root", "", "budgetdb");
                                if (mysqli_connect_errno()) {
                                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                } else {
                                    $update = mysqli_query($con, "UPDATE tblbills SET is_paid = 0");
                                }
                                // Refresh page
                                echo "<script language='javascript'>alert('You have already unchecked all successfully !')</script>";
                            }
                        }
                        ?>

                    </p>
                </form>
            </div>
        </div>

    </body>
</html>
