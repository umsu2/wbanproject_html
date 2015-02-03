<?php
/**
 * Created by PhpStorm.
 * User: Yang
 * Date: 01/02/2015
 * Time: 8:50 PM
 */


//load and connect to MySQL database stuff
$docRoot = getenv("DOCUMENT_ROOT");
require($docRoot."/includes/config.inc.php");


if (!empty($_POST)) {
    //gets user's info based off of a username.
    $query = "
            SELECT
                id,
                username,
                password
            FROM users
            WHERE
                username = :username
        ";

    $query_params = array(
        ':username' => $_POST['username']
    );

    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        // For testing, you could use a die and message.
        //die("Failed to run query: " . $ex->getMessage());

        //or just use this use this one to product JSON data:
        $response["success"] = 0;
        $response["message"] = "Database Error1. Please Try Again!";
        die(json_encode($response));

    }

    //This will be the variable to determine whether or not the user's information is correct.
    //we initialize it as false.
    $validated_info = false;

    //fetching all the rows from the query
    $row = $stmt->fetch();
    if ($row) {
        //if we encrypted the password, we would unencrypt it here, but in our case we just
        //compare the two passwords
        if ($_POST['password'] === $row['password']) {
            $login_ok = true;
            $_SESSION["user_login_name"] = $row['username'];
        }
    }

    // If the user logged in successfully, then we send them to the private members-only page
    // Otherwise, we display a login failed message and show the login form again
    if ($login_ok) {


//        $response["success"] = 1;
//        $response["message"] = "Login successful!";
//        $response["username"] = $row['username'];

        header('Location: /webservice/userpage.php');


        //die(json_encode($response));
    } else {
        $response["success"] = 0;
        $response["message"] = "Invalid Credentials!";
        die(json_encode($response));
    }
} else {
    ?>
    <h1>Login</h1>
    <form action= "/webservice/login.php" method="post">
        Username:<br />
        <input type="text" name="username" placeholder="username" />
        <br /><br />
        Password:<br />
        <input type="password" name="password" placeholder="password" value="" />
        <br /><br />
        <input type="submit" value="Login" />
    </form>
    <a href="/webservice/register.php">Register</a>
<?php
}

?>