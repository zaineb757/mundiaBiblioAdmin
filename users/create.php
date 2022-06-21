<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nom_auteur = $prenom_auteur=  "";
$nom_auteur_err = $prenom_auteur_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_nom_auteur = trim($_POST["nom_auteur"]);
    if(empty($input_nom_auteur)){
        $nom_auteur_err = "Please enter a name.";
    } elseif(!filter_var($input_nom_auteur, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nom_auteur_err = "Please enter a valid name.";
    } else{
        $nom_auteur = $input_nom_auteur;
    }
    
    // Validate prenom
    $input_prenom_auteur = trim($_POST["prenom_auteur"]);
    if(empty($input_prenom_auteur)){
        $prenom_auteur_err = "Please enter an nom_auteur.";     
    } else{
        $prenom_auteur = $input_prenom_auteur;
    }
    
    
    // Check input errors before inserting in database
    if(empty($nom_auteur_err) && empty($prenom_auteur_err)){
        // Prepare an insert statement
	
       $sql = "INSERT INTO auteur (nom_auteur, prenom_auteur) VALUES (?, ?)";
         
        //if($stmt = mysqli_prepare($link, $sql)){
        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            $stmt->bindParam(1, $param_nom_auteur, PDO::PARAM_STR);
            $stmt->bindParam(2, $param_prenom_auteur, PDO::PARAM_STR);
         
            
            // Set parameters
            $param_nom_auteur= $nom_auteur;
            $param_prenom_auteur = $prenom_auteur;
          
            
            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        //mysqli_stmt_close($stmt);
        $stmt->closeCursor(); //PDO close
    }
    
    // Close connection
    //mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
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
                        <h2>Create</h2>
                    </div>
                    <p>Remplissez svp!</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					
                        <div class="form-group <?php echo (!empty($nom_auteur_err)) ? 'has-error' : ''; ?>">
                            <label>Nom</label>
                            <input type="text" name="nom_auteur" class="form-control" value="<?php echo $nom_auteur; ?>">
                            <span class="help-block"><?php echo $nom_auteur_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($prenom_auteur_err)) ? 'has-error' : ''; ?>">
                            <label>Prenom</label>
                            <textarea name="prenom_auteur" class="form-control"><?php echo $prenom_auteur; ?></textarea>
                            <span class="help-block"><?php echo $prenom_auteur_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>