<?php
session_start();
$docRoot = getenv("DOCUMENT_ROOT");
require($docRoot."/includes/config.inc.php");
$conn = mysql_connect("localhost", "wbanocrl_admin","ece4600$$");
/**
 * Created by PhpStorm.
 * User: Yang
 * Date: 02/02/2015
 * Time: 8:57 PM
 */


$variable = $_SESSION["user_login_name"];
//$response["success"] = 1;
//$response["message"] = "Login successful!";
//$response["username"] = $variable;

mysql_select_db("wbanocrl_webservice") or die ("No Database found.");

$SQL = "SELECT * FROM users";
$result = mysql_query($SQL);
$num=mysql_numrows($result);



echo "<table border='1'>"; // start a table tag in the HTML
echo "<td>user</td>";
echo "<td>address</td>";

while ( $db_field = mysql_fetch_assoc($result) ) {


    echo "<tr><td>" . $db_field['username'] . "</td><td>" . $db_field['address'] . "</td></tr>";


//    $field_username = $db_field['username'];
//    print $field_username;
//    $field_address = $db_field['address'];

}

echo "</table>"; //Close the table in HTML
echo $variable;
echo " is viewing";

$query = "
            SELECT
                id,
                username,
                password,
                address
            FROM users
            WHERE
                username = '$variable'
        ";

$result2 = mysql_query($query);
$db_field2 = mysql_fetch_assoc($result2);
echo $db_field2['password'];

echo " the end";
//$query_params = array($variable);
//
//try {
//    $stmt   = $db->prepare($query);
//    $result_user = $stmt->execute($query_params);
//}
//
//catch (PDOException $ex) {
//    // For testing, you could use a die and message.
//    //die("Failed to run query: " . $ex->getMessage());
//
//    //or just use this use this one to product JSON data:
//    $response["success"] = 0;
//    $response["message"] = "Database Error1. Please Try Again!";
//    die(json_encode($response));
//
//}
//$row = $stmt->fetch();
//if ($row) {
//    echo $row['address'];
//}
mysql_close($conn);



//$i=0;while ($i < $num) {
//    $field_username=mysql_result($result,$i,"username");
//    $field_address=mysql_result($result,$i,"address");
//
//    $i++;}
//
//
//print $field_username;

//die(json_encode($response));