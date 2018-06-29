<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "budgetdb";
$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
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
                            <select name="bill_on" id="category" style="width: 30%">
                                <option value="">-- Select a category --</option>
                                
                            </select>
                        </p>
                        <p>
                            &#160 <input type="checkbox" id="is_paid" >
                            Is Paid ?
                        </p>
                        <p>
                            <button id="add" value="" onclick="validateForm()">Add New Bill</button>
                            <button id="add" value="" onclick="reset()">Reset</button>
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
                    </table>
                    <p>
                        &#160 <button id="update">Update</button>
                    </p>
                </form>
            </div>
        </div>
        <script src="1.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>