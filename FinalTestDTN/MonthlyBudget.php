<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Monthly Budget</title>
        <link rel="stylesheet" type="text/css" href="1.css">
    </head>
    <body>
        <div id="father">
            <div id="one">
                &#160 Add New Bill
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
                            &#160 <input type="text" name="account" value="132000" style="width: 30%" readonly> $
                        </p>
                        <p>
                            &#160 <input type="text" name="bill_id" value="" style="width: 15%">
                        </p>
                        <p>
                            &#160 <input type="text" name="bill_name" value="" style="width: 50%">
                        </p>
                        <p>
                            &#160 <input type="text" name="amount" value="" style="width: 50%"> $
                        </p>
                        <p>
                            &#160
                            <?php
                            require_once 'ConnectDatabase.php';
                            $con = new Connection();
                            $conn = $con->connect();
                            $query = "SELECT * FROM tblbillcategories";
                            $result = $conn->query($query);
                            ?>
                            <select name="bill_on" id="category" style="width: 30%">
                                <option value="">-- Select a category --</option>
                                <?php
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)):
                                    echo "<option>" . $row['cat_name'] . " </option>";
                                endwhile;
                                ?>
                            </select>
                        </p>
                        <p>
                            &#160 <input type="checkbox" id="is_paid" >
                            Is Paid ?
                        </p>
                        <p>
                            <button id="add" value="" onclick="validateForm()">Add New Bill</button>
                            <script lang="javascript">
                                
                            </script>
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
                    <table border="1" align="center" width="100%" >
                        <tr style="background-color: #FFFF99; text-align: right; table-layout: fixed; width: 100%; ">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Complete</th>
                        </tr>
                        <?php
                        require_once 'ConnectDatabase.php';
                        $con = new Connection();
                        $conn = $con->connect();
                        $query_data = "SELECT * FROM `tblbills`";
                        $list_data = $conn->query($query_data);
                        if ($list_data->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($list_data)) {
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
                    <p>
                        &#160 <button id="update">Update</button>
                    </p>
                </form>
            </div>
        </div>
        <script src="1.js" src="jquery-3.3.1.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
