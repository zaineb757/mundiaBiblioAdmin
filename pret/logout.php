<?php
session_start(); //to ensure you are using same session
session_destroy(); //destroy the session
header("location:/BiblioProject/create.php"); //to redirect back to "index.php" after logging out
exit();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Untitled Document</title>
</head>



<body>
    <h1> Beslama 3lik</h1>
</body>

</html>