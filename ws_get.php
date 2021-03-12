<?php
header("Content-type: application/json; charset=utf-8");
include_once('./function.php');
$objCon = connectDB();
$perpage = 2;
if (isset($_GET['page']) && (int) $_GET['page'] > 0) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start = ($page - 1) * $perpage;
$condition = "";
$search = "";
if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = mysqli_real_escape_string($objCon, $_GET['search']);
    $condition = " AND c_firstname LIKE '%$search%' OR c_lastname LIKE '%$search%' OR c_idcard = '$search'";
}
$sql = "SELECT * FROM contact WHERE c_status = 1$condition ORDER BY c_id DESC LIMIT $start, $perpage";
$objQuery = mysqli_query($objCon, $sql);

$data = array();
while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
    $data[] = $objResult;
}

$strSQL = "SELECT * FROM contact WHERE c_status = 1$condition ORDER BY c_id DESC";
$objQuery = mysqli_query($objCon, $strSQL);
$total_record = mysqli_num_rows($objQuery);
// echo 'all = ',$total_record;
$total_page = ceil($total_record / $perpage);

// $last_page = true;
// if($page != $total_page)
//     $last_page = false;

$data_return = array(
    'perpage' => $perpage,
    'current_page' => (int) $page,
    'total_page' => $total_page,
    'is_lastpage' => $page == $total_page,
    'total_record' => $total_record,
    'data' => $data
);

echo json_encode($data_return);
?>