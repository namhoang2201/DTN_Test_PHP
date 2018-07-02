<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Monthly Budget</title>
        <script language="javascript" src="jquery-3.2.1.js"></script>
        <script language="javascript">

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
                    }
                    ,
                    success: function (result) {
                        $('#result').html(result);
                    }
                }
                );

                return true;
            }

            function isChecked() {
                var bit = $('#is_paid')[0].checked;
                if (bit == true) {
                    bit = 1;
                } else {
                    bit = 0;
                }
                return bit;
            }

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
                <form action="" name="form2" method="post">
                    <table border="1" align="center" width="100%">
                        <tr style="background-color: #FFFF99; text-align: right; table-layout: fixed; width: 100%; ">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Complete</th>
                        </tr>
                        <?php
                        $conn = mysqli_connect('localhost', 'root', '', 'budgetdb') or die('Can not connect to mysql');
                        $query = mysqli_query($conn, "SELECT * FROM tblbills");
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
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
                                echo '<tr>';
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['amount'] . "</td>";
                                echo "<td>" . $category . "</td>";
                                if ($complete == 0) {
                                    echo "<td><input type='checkbox'></td>";
                                } else {
                                    echo "<td><input type='checkbox' checked></td>";
                                }
                                echo '</tr>';
                            }
                        }
                        ?>
                    </table>
                    <div id="result"></div>
                    <p>
                        &#160 <button id="update">Update</button>
                    </p>
                </form>
            </div>
        </div>

    </body>
</html>
