<?php

header('Content-Type: text/html; charset=utf-8');
// Lấy BIll ID từ form người dùng nhập vào
$billId = isset($_POST['billId']) ? $_POST['billId'] : FALSE;
$billName = isset($_POST['billName']) ? $_POST['billName'] : FALSE;
$amount = isset($_POST['amount']) ? $_POST['amount'] : FALSE;
$catId = isset($_POST['catId']) ? $_POST['catId'] : FALSE;
$isPaid = isset($_POST['isPaid']) ? $_POST['isPaid'] : FALSE;

// Biến sum là tổng tất cả các amount trước đó mà file MonthlyBudget.php gửi sang
$sum = (int) $_POST['sum'];

if (($billId != FALSE) && ($billName != FALSE) && ($amount != FALSE) && ($catId != FALSE)) {
    // Tổng mới sau mỗi lần thêm hóa đơn mới
    $new_total = $sum + $amount;

    // Cập nhật lại tổng hiện tại
    $sum = $new_total;

    // Kết nối tới cơ sở dữ liệu
    $con = new mysqli("localhost", "root", "namhoang", "budgetdb");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
        $search = mysqli_query($con, "select * from tblbills where id = '" . $billId . "'");
        if (!$search || mysqli_num_rows($search) == 0) {
            //Nếu không tồn tại Bill ID, ta có thể thêm mới bình thường
            // Xử lý dữ liệu biến catId, quy đổi giá trị (1_Personal, 2_Family, 3_Important)
            switch ($catId) {
                case "Personal":
                    $catIdd = 1;
                    break;
                case "Family":
                    $catIdd = 2;
                    break;
                case "Important":
                    $catIdd = 3;
                    break;
            }

            // Xác định biến cục bộ $isPaid
            switch ($isPaid) {
                case 0:
                    $str = "insert into tblbills values ('$billId','$billName','$amount',0,'$catIdd')";
                    break;

                case 1:
                    $str = "insert into tblbills values ('$billId','$billName','$amount',1,'$catIdd')";
                    break;
            }

            // Thực hiện thêm bản ghi vào danh sách 
            $insert = mysqli_query($con, $str);

            // Hiển thị hàng mới nhất được thêm vào cơ sở dữ liệu
            echo '<tr align="right">';
            echo "<td>" . $billId . "<input class='checkbox' type='checkbox' id='" . $billId . "' name='list[" . $billId . "]'/></td>";
            if ($isPaid == 0) {
                echo "<td>" . $billName . "</td>";
            } else {
                echo "<td style='text-decoration: line-through;'>" . $billName . "</td>";
            }
            echo "<td> $ " . $amount . "</td>";
            echo "<td>" . $catId . "</td>";

            if ($isPaid == 0) {
                echo "<td><input type='checkbox'></td>";
            } else {
                echo "<td><input type='checkbox' checked></td>";
            }
            echo "<td>"
            . "<a href='edit.php?id=" . $billId . "' >Edit</a> &nbsp"
            . "<a onclick='confirm(\"Are you sure ?\")' href='MonthlyBudget.php?idd=" . $billId . "' >Delete</a>"
            . "</td>";
            echo '</tr>';

            echo '<tr align="right" id="tr1">';
            echo '<td colspan="2">Total</td>';
            echo '<td>$ ' . $new_total . '</td>';
            echo '<td colspan="3"></td>';
            echo '</tr>';
            echo '<tr align="right" id="tr2">';
            echo '<td colspan="2">Remain</td>';
            echo '<td> $ ' . (132000 - $new_total) . '</td>';
            echo '<td colspan="3"></td>';
            echo '</tr>';
        } else {
            // Nếu đã tồi tại Bill ID, ta thông báo cho người dùng
            echo "<script language='javascript'> alert('Note: Bill ID has already existed !!!');</script>";
        }
    }
}
?>