<?php
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include config file
    require_once "config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM abonne WHERE ID_ABONNE = ?";

    //if($stmt = mysqli_prepare($link, $sql)){
    if ($stmt = $link->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        //mysqli_stmt_bind_param($stmt, "i", $param_id);
        $stmt->bindParam(1, $param_id, PDO::PARAM_INT);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        //if(mysqli_stmt_execute($stmt)){
        if ($stmt->execute()) {
            //$result = mysqli_stmt_get_result($stmt);
            $result = $stmt->fetchAll();

            //if(mysqli_num_rows($result) == 1){
            if (count($result) == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $row = $result[0];

                // Retrieve individual field value
                $nom_abonne = $row["NOM_ABONNE"];
                $prenom_abonne = $row['PRENOM_ABONNE'];
                $username_abonne = $row['USERNAME_ABONNE'];
                $password_abonne = $row['PASSWORD_ABONNE'];
                $adresse_abonne = $row['ADRESSE_ABONNE'];
                $telephone_abonne = $row['TELEPHONE_ABONNE'];
                $date_adhesion = $row['DATE_ADHESION'];
                $date_naissance_abonne = $row['DATE_NAISSANCE'];
                $categorie_abonne = $row['CATEGORIE_ABONNE'];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    //mysqli_stmt_close($stmt);
    $stmt->closeCursor(); //PDO close

    // Close connection
    //mysqli_close($link);
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Détail Abonné</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Abonné</h1>
                    </div>
                    <div class="form-group">
                        <label>Nom</label>
                        <p class="form-control-static"><?php echo $nom_abonne; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Prénom</label>
                        <p class="form-control-static"><?php echo $prenom_abonne; ?></p>
                    </div>

                    <div class="form-group">
                        <label>Nom d'utilisateur</label>
                        <p class="form-control-static"><?php echo $username_abonne; ?></p>
                    </div>

                    <div class="form-group">
                        <label>Mot de passe</label>
                        <p class="form-control-static"><?php echo $password_abonne; ?></p>
                    </div>

                    <div class="form-group">
                        <label>Adresse</label>
                        <p class="form-control-static"><?php echo $adresse_abonne; ?></p>
                    </div>

                    <div class="form-group">
                        <label>télèphone</label>
                        <p class="form-control-static"><?php echo $telephone_abonne; ?></p>
                    </div>

                    <div class="form-group">
                        <label>Date d'adhésion</label>
                        <p class="form-control-static"><?php echo $date_adhesion; ?></p>
                    </div>

                    <div class="form-group">
                        <label>Date de Naissance</label>
                        <p class="form-control-static"><?php echo $date_naissance_abonne; ?></p>
                    </div>

                    <div class="form-group">
                        <label>Catégorie</label>
                        <p class="form-control-static"><?php echo $categorie_abonne; ?></p>
                    </div>

                    <div class="form-group">
                        <label>Prenom</label>
                        <p class="form-control-static"><?php echo $prenom_abonne; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>