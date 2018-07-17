<?php
ob_start();
session_start();
if ($_SESSION['username'] == true) {

}else{
    header('location: login.php');
}
// Khai báo biến mảng toàn cục, lưu tất cả các checkbox trong table, cả được tích và không được tích
$complete_all = array();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset = "utf-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge">
    <title>Monthly Budget</title>
    <link rel="stylesheet" type="text/css" href="./CSS/mystyle.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script language = "javascript" src = "./JS/jquery-3.2.1.js"></script>
    <script language="javascript">

            // Hàm kiểm tra việc nhập dữ liệu vào form
            function validateForm() {
                var ho = $('#bill_id').val();
                var name = $('#bill_name').val();
                var amount = $('#amount').val();
                var category = $('#category').val();

                // if (category == '') {
                //     $('#checkcategory').html("Please select a category !");
                //     return false;
                // }


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
                        if (result == "existed") {
                            // $('#checkinsert').hmtl("Bill ID has already existed !");
                            alert("BIll ID has already existed !");
                            window.location.href = 'MonthlyBudget.php';
                        }
                        if (result != "existed") {
                            $('#tr1').remove();
                            $('#tr2').remove();
                            $('#mybody').append(result);
                        }
                    }
                }
                );
                return true;
            }

            // function checkcate(){
            //     var category = $('#category').val();
            //     if (category != '') {
            //         $('#checkcategory').hide();
            //     }
            // }

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

            // Hàm để chọn hoặc bỏ chọn tất cả checkbox ở cột đầu tiên bên trái 
            function change() {
                var select_all = document.getElementById("select_all"); //select all checkbox
                var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items

                //select all checkboxes
                select_all.addEventListener("change", function (e) {
                    for (i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].checked = select_all.checked;
                    }
                });


                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].addEventListener('change', function (e) { //".checkbox" change 
                        //uncheck "select all", if one of the listed checkbox item is unchecked
                        if (this.checked == false) {
                            select_all.checked = false;
                        }
                        //check "select all" if all checkbox items are checked
                        if (document.querySelectorAll('.checkbox:checked').length == checkboxes.length) {
                            select_all.checked = true;
                        }
                    });
                }
            }

        </script>
    </head>
    <body>
        <div id="logout" style="margin-left: 90%; margin-top: 1%;">
            <a href="logout.php"> Logout</a>
        </div>
        <div id="father">
            <div id="one">
                &#160; Add New Bill
            </div>
            <div id="two">
                <div id="two1"> 
                    Account <br> <br>
                    Bill ID <br> <br>
                    Bill Name 
                    <p><br>Amount</p>
                    <p>Bill on</p>
                </div>
                <div id="two2">
                    <form action="#" method="post" name="form1" id="form1">
                        <p>
                            &#160; <input type="text" id="account" placeholder="132000" style="width: 20%" readonly /> $
                        </p>
                        <p>
                            &#160; <input type="text" id="bill_id" value="" style="width: 15%" required /> &nbsp; &nbsp;
                            <span id="checkbill" style="color: red;"></span>
                            <script language="javascript">
                                $('#bill_id').keyup(function(){
                                    var bill_id = $('#bill_id').val();
                                    if (bill_id !== '') {
                                      $.post(
                                        'checkbillid.php',
                                        {bill_id:bill_id},
                                        function(result){
                                          if (result=="empty") {
                                            $('#checkbill').hide();
                                        }else{
                                            $('#checkbill').show();
                                            $('#checkbill').html(result);
                                        }
                                    });
                                  }else{
                                      $('#checkbill').hide();
                                  }
                              });
                          </script>
                      </p>
                      <p>
                        &#160; <input type="text" id="bill_name" value="" style="width: 30%" required />
                    </p>
                    <p>
                        &#160; <input type="number" id="amount" value="" style="width: 30%"  onkeyup="value = isNaN(parseFloat(value)) ? '' : value" required/> $
                    </p>
                    <p>
                        &#160;
                        <?php
                        $conn = mysqli_connect('localhost', 'root', 'namhoang', 'budgetdb') or die('Can not connect to mysql');
                        $query = mysqli_query($conn, "SELECT * FROM tblbillcategories");
                        ?>
                        <select required name="bill_on" id="category" style="width: 20%" onchange="checkcate()">
                            <option value="">-- Select a category --</option>
                            <?php
                            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)):
                                echo "<option>" . $row['cat_name'] . " </option>";
                            endwhile;
                            ?>
                        </select>
                        <span id="checkcategory" style="color: red;"></span>
                    </p>
                    <p>
                        &#160; <input type="checkbox" name="is_paid" id="is_paid" onsubmit="return isChecked()" />
                        Is Paid ?
                    </p>
                    <p>
                        <input type="submit" id="add" onclick="validateForm()" value="Add New Bill" />
                        <input type="reset" id="reset" value="Reset" onclick="reset()" />
                        <!-- <span id="checkinsert" style="color: red;"></span> -->
                    </p>
                </form>
            </div>
        </div>
        <div id="three">
            &#160; Bill List
        </div>
        <div id="four">
            <form action="<?php echo($_SERVER['PHP_SELF']); ?>" name="form2" method="post">
                <table border="1" align="right" width="100%" id="mytable">
                    <thead style="background-color: #FFFF99; align: right; table-layout: fixed; width: 100%; ">
                        <tr>
                            <th align="center" width="5%"><input type="checkbox" id="select_all" onclick="change()" /></th>
                            <th width="10%">
                                ID
                            </th>
                            <th align="right" width="20%">Name</th>
                            <th width="15%">Amount</th>
                            <th width="15%">Category</th>
                            <th width="15%">Complete</th>
                            <th width="20%" align="center">Action</th>
                        </tr>

                    </thead>
                    <tbody id="mybody">
                        <?php
                        $total = 0;
                        $conn = mysqli_connect('localhost', 'root', 'namhoang', 'budgetdb') or die('Can not connect to mysql');
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
                                echo '<tr id=' . $id . ' align="right">';
                                echo "<td align='center' width='5%'><input class='checkbox' type='checkbox' id='" . $id . "' name='list[" . $id . "]'/></td>";
                                echo "<td width='10%'>".$row['id']."</td>";
                                if ($complete == 0) {
                                    echo "<td width='20%'>" . $row['name'] . "</td>";
                                } else {
                                    echo "<td width='20%' style='text-decoration: line-through;'>" . $row['name'] . "</td>";
                                }
                                echo "<td width='15%'> $ " . (int) $row['amount'] . "</td>";
                                echo "<td>" . $category . "</td>";
                                if ($complete == 0) {
                                    echo "<td width='15%'><input type='checkbox' name='complete[" . $id . "]' value = 0></td>";
                                    // Thêm lần lượt từng checkbox vào mảng toàn thể
                                    $complete_all[$id] = 0;
                                } else {
                                    echo "<td width='15%'><input type='checkbox' name='complete[" . $id . "]' value = 1 checked></td>";
                                    // Thêm lần lượt từng checkbox vào mảng toàn thể
                                    $complete_all[$id] = 1;
                                }
                                echo "<td align='center' width='20%'>"
                                . "<a href='edit.php?id=" . $id . "' >Edit</a> &nbsp"
                                . "<a onclick='return confirm(\"Are you sure ?\")' href='MonthlyBudget.php?idd=" . $id . "' >Delete</a>"
                                . "</td>";
                                echo '</tr>';
                            }
                        }

                        // Xóa từng phần tử khi bấm vào các nút delete ở bên phải của bảng
                        if (isset($_GET["idd"])) {
                            $idd = $_GET["idd"];
                            $conn = mysqli_connect('localhost', 'root', 'namhoang', 'budgetdb') or die('Can not connect to mysql');
                            $result = mysqli_query($conn, "DELETE FROM tblbills WHERE id = '" . $idd . "'");
                            if ($result) {
                                ?>
                                <script>
                                    alert('Success to delete data !');
                                    window.location.href = 'MonthlyBudget.php';
                                </script>;
                                <?php
                            } else {
                                ?>
                                <script>
                                    alert('Fail to delete data !');
                                    window.location.href = 'MonthlyBudget.php';
                                </script>;
                                <?php
                            }
                        }
                        ?>
                        <tr align="right" id="tr1">
                            <td colspan="3">Total</td>
                            <td><?php echo "$ " . $total ?></td>
                            <td colspan="4"></td>
                        </tr>
                        <tr align="right" id="tr2">
                            <td colspan="3">Remain</td>
                            <td> <?php echo "$ " . (132000 - $total); ?></td>
                            <td colspan="4"></td>
                        </tr>
                    </tbody>
                </table>
                <p>
                    <input type="hidden" id="sum" value="<?php echo $total ?>"/>
                </p>
                <p>
                    &#160; <button type="submit" id="update" name="update">Update</button>
                    &#160; <button type="submit" id="delete_many" name="delete_many" onclick="return confirm('Are you sure ?')">Delete</button>
                    <?php
                    // Code cập nhật dữ liệu
                    if (isset($_POST['update'])) {
                        if (isset($_POST['complete'])) {
                            // Mảng complete lưu tất cả các checkbox được tích, bao gồm cả sau khi update
                            // Mảng complete là mảng con của complete_all
                            $complete = $_POST['complete'];

                            // Cập nhật, đặt tất cả các checkbox được tích giấ trị bằng 1, lưu vào cơ sở dữ liệu
                            foreach ($complete as $key => $value) {
                                $con = new mysqli("localhost", "root", "namhoang", "budgetdb");
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
                                    $con = new mysqli("localhost", "root", "namhoang", "budgetdb");
                                    if (mysqli_connect_errno()) {
                                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                    } else {
                                        $update = mysqli_query($con, "UPDATE tblbills SET is_paid = 0 WHERE id = '" . $key . "'");
                                    }
                                }
                            }

                            // Refresh page
                            ?>
                            <script>
                                alert('Update successfully !');
                                window.location.href = 'MonthlyBudget.php';
                            </script>;
                            <?php
                        } else {
                            // Nếu bỏ tích tất cả thì cập nhật tất cả value của mảng complete_all về 0 và cả trong cơ sở dữ liệu
                            $con = new mysqli("localhost", "root", "namhoang", "budgetdb");
                            if (mysqli_connect_errno()) {
                                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                            } else {
                                $update = mysqli_query($con, "UPDATE tblbills SET is_paid = 0");
                            }

                            // Refresh page
                            ?>
                            <script>
                                alert('Update successfully !');
                                window.location.href = 'MonthlyBudget.php';
                            </script>
                            <?php
                        }
                    }

                    // Xóa một hoặc nhiều bản ghi bằng cách tích vào nhiều checkbox ở cột đầu tiên bên trái
                    if (isset($_POST['delete_many'])) {
                        if (isset($_POST['list'])) {
                            // many_choices là mảng lưu tất cả các checkbox được tích ở cột bên trái
                            $many_choices = $_POST['list'];
                            // Xóa tất cả các bản ghi trong cơ sở dữ liệu có checkbox được tích ở cột bên trái trên page
                            $flag = TRUE;
                            foreach ($many_choices as $key => $value) {
                                $con = new mysqli("localhost", "root", "namhoang", "budgetdb");
                                if (mysqli_connect_errno()) {
                                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                } else {
                                    $flag = mysqli_query($con, "DELETE FROM tblbills WHERE id = '" . $key . "'");
                                }
                            }
                            if ($flag == FALSE) {
                                ?>
                                <script>
                                    alert('Fail to delete data !');
                                    window.location.href = 'MonthlyBudget.php';
                                </script>;
                                <?php
                            } else {
                                ?>
                                <script>
                                    alert('Delete data successfully !');
                                    window.location.href = 'MonthlyBudget.php';
                                </script>;
                                <?php
                            }
                        } else {
                            ?>
                            <script>
                                alert('You have not chosen anything !');
                                window.location.href = 'MonthlyBudget.php';
                            </script>;
                            <?php
                        }
                    }

                    ob_end_flush();
                    ?>

                </p>
            </form>
        </div>
    </div>

</body>
</html>
