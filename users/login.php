<?php
session_start();
if (!isset($_SESSION['username'])) {
    if (isset($_POST['username'])) {
        $username = htmlentities($_POST['username']);
        $password = htmlentities($_POST['password']);
        $conn = oci_connect('fatimahmich', 'fati123', 'XE')
            or die("Can't connect to database server!");

        $query = "SELECT username_abonne, password_abonne FROM abonne
WHERE username_abonne=:username AND password_abonne=:password";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ':username', $username, 8);
        oci_bind_by_name($stmt, ':password', $password, 32);
        oci_execute($stmt);
        list($username, $password) = oci_fetch_array($stmt, OCI_NUM);
        if ($username != "") {
            $_SESSION['username'] = $username;
            echo "You've successfully logged in. ";
            header("Location:index.php");
        }
    } else {
        printf("chi haja mahiyach");
    }
} else {
    printf("Welcome back, %s!", $_SESSION['username']);
}
?>
<!DOCTYPE HTML ">
<html>

<head>
    <meta http-equiv=" Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>

    <p>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        Username:<br /><input type="text" name="username" size="10" /><br />
        Password:<br /><input type="password" name="password" size="10" /><br />
        <input type="submit" value="Login" />
		<a href="logout.php" class="btn btn-default">Cancel</a>
    </form>
    </p>
</body>

</html>