<?php
$data = json_decode(file_get_contents("php://input"));

if ($data != null || $data != '') {
    // print_r($data);
    // echo $data->c_prefix;
    $c_prefix = $data->c_prefix;
    $c_firstname = $data->c_firstname;
    $c_lastname = $data->c_lastname;
    $c_idcard = $data->c_idcard;
    $c_birthdate = $data->c_birthdate;
    $c_mobile = $data->c_mobile;
    $c_detail = $data->c_detail;

    $strSQL = "INSERT INTO contact(
        c_prefix,
        c_firstname,
        c_lastname,
        c_idcard,
        c_birthdate,
        c_mobile,
        c_detail,
        c_status
    ) VALUES(
        '$c_prefix',
        '$c_firstname',
        '$c_lastname',
        '$c_idcard',
        '$c_birthdate',
        '$c_mobile',
        '$c_detail',
        2
    )";

    include_once('./function.php');
    $objCon = connectDB();

    $sqlCheck = "SELECT * FROM contact 
    WHERE c_idcard = '$c_idcard' AND c_status IN(1,2)";
    $queryCheck = mysqli_query($objCon, $sqlCheck);
    $rowCheck = mysqli_num_rows($queryCheck);

    if ($rowCheck > 0) {
        $result = array('result' => 'id card is exists!');
    } else {

        $objQuery = mysqli_query($objCon, $strSQL);
        if ($objQuery) {
            $result = array('result' => 'success');
        } else {
            $result = array('result' => 'error');
        }
    }

    echo json_encode($result);
}
