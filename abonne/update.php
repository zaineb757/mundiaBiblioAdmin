<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$nom_abonne = $prenom_abonne = $username_abonne = $password_abonne = $adresse_abonne = $telephone_abonne = $date_adhesion = $date_naissance = $categorie_abonne = "";
$nom_abonne_err = $prenom_abonne_err = $username_abonne_err = $password_abonne_err = $adresse_abonne_err = $telephone_abonne_err = $date_adhesion_err = $date_naissance_err = $categorie_abonne_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_nom_abonne = trim($_POST["nom_abonne"]);
    if (empty($input_nom_abonne)) {
        $nom_abonne_err = "Please enter a name.";
        //} elseif(!filter_var($input_nom_abonne, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nom_abonne_err = "Please enter a valid name.";
    } else {
        $nom_abonne = $input_nom_abonne;
    }

    // Validate prenom
    $input_prenom_abonne = trim($_POST["prenom_abonne"]);
    if (empty($input_prenom_abonne)) {
        $prenom_abonne_err = "Please enter an nom_abonne.";
    } else {
        $prenom_abonne = $input_prenom_abonne;
    }

    // Validate username
    $input_username_abonne = trim($_POST["username_abonne"]);
    if (empty($input_username_abonne)) {
        $username_abonne_err = "Entrer le nom d'utilisateur du nouveau l'abonné.";
    } else {
        $username_abonne = $input_username_abonne;
    }


    // Validate password
    $input_password_abonne = trim($_POST["password_abonne"]);
    if (empty($input_password_abonne)) {
        $password_abonne_err = "Entrer le mot de passe du nouveau abonné.";
    } else {
        $password_abonne = $input_password_abonne;
    }

    // Validate adresse
    $input_adresse_abonne = trim($_POST["adresse_abonne"]);
    if (empty($input_adresse_abonne)) {
        $adresse_abonne_err = "Entrer le l'adresse de l'abonné.";
    } else {
        $adresse_abonne = $input_adresse_abonne;
    }

    // Validate telephone
    $input_telephone_abonne = trim($_POST["telephone_abonne"]);
    if (empty($input_telephone_abonne)) {
        $telephone_abonne_err = "Entrer le l'telephone de l'abonné.";
    } else {
        $telephone_abonne = $input_telephone_abonne;
    }

    // Validate categorie
    $input_categorie_abonne = trim($_POST["categorie_abonne"]);
    if (empty($input_categorie_abonne)) {
        $categorie_abonne_err = "Entrer la catégorie.";
    } else {
        $categorie_abonne = $input_categorie_abonne;
    }
    // Validate date d'adhesion
    $input_date_adhesion = trim($_POST["date_adhesion"]);
    if (empty($input_date_adhesion)) {
        $date_adhesion_err = "Entrer la date d'adhésion.";
    } else {
        $date_adhesion = $input_date_adhesion;
    }

    // Validate date naissance
    $input_date_naissance = trim($_POST["date_naissance"]);
    if (empty($input_date_naissance)) {
        $date_naissance_err = "Entrer la date d'adhésion.";
    } else {
        $date_naissance = $input_date_naissance;
    }

    // Check input errors before inserting in database
    if (empty($nom_abonne_err) && empty($prenom_abonne_err) && empty($username_abonne_err) && empty($password_abonne_err) && empty($adresse_abonne_err)  && empty($telephone_abonne_err) && empty($categorie_abonne_err) && empty($date_adhesion_err) && empty($date_naissance_err)) {
        // Prepare an update statement
        $sql = "UPDATE abonne SET nom_abonne=?, prenom_abonne=?,username_abonne=?, password_abonne=?,adresse_abonne=?,telephone_abonne=?,categorie_abonne=?,date_adhesion=?,date_naissance=? WHERE ID_ABONNE=?";

        //if($stmt = mysqli_prepare($link, $sql)){
        if ($stmt = $link->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);

            $stmt->bindParam(1, $param_nom_abonne, PDO::PARAM_STR);
            $stmt->bindParam(2, $param_prenom_abonne, PDO::PARAM_STR);
            $stmt->bindParam(3, $param_username_abonne, PDO::PARAM_STR);
            $stmt->bindParam(4, $param_password_abonne, PDO::PARAM_STR);
            $stmt->bindParam(5, $param_adresse_abonne, PDO::PARAM_STR);
            $stmt->bindParam(6, $param_telephone_abonne, PDO::PARAM_STR);
            $stmt->bindParam(7, $param_categorie_abonne, PDO::PARAM_STR);
            $stmt->bindParam(8, $param_date_adhesion, PDO::PARAM_STR);
            $stmt->bindParam(9, $param_date_naissance, PDO::PARAM_STR);
            $stmt->bindParam(10, $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_nom_abonne = $nom_abonne;
            $param_prenom_abonne = $prenom_abonne;
            $param_username_abonne = $username_abonne;
            $param_password_abonne = $password_abonne;
            $param_adresse_abonne = $adresse_abonne;
            $param_telephone_abonne = $telephone_abonne;
            $param_categorie_abonne = $categorie_abonne;
            $param_date_adhesion = $date_adhesion;
            $param_date_naissance = $date_naissance;
            $param_id = $id;

            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if ($stmt->execute()) {
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        //mysqli_stmt_close($stmt);
        $stmt->closeCursor(); //PDO close
    }

    // Close connection
    //mysqli_close($link);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM abonne WHERE ID_ABONNE = ?";
        //if($stmt = mysqli_prepare($link, $sql)){
        if ($stmt = $link->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "i", $param_id);
            $stmt->bindParam(1, $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_id = $id;

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
                    $username_abonne = $row["USERNAME_ABONNE"];
                    $password_abonne = $row["PASSWORD_ABONNE"];
                    $nom_abonne = $row["NOM_ABONNE"];
                    $prenom_abonne = $row["PRENOM_ABONNE"];
                    $adresse_abonne = $row["ADRESSE_ABONNE"];
                    $telephone_abonne = $row["TELEPHONE_ABONNE"];
                    $categorie_abonne = $row["CATEGORIE_ABONNE"];
                    $date_adhesion = $row["DATE_ADHESION"];
                    $date_naissance = $row["DATE_NAISSANCE"];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Abonnés</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">Modifier un Abonné</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="badge bg-success badge-number">3</span>
                    </a><!-- End Messages Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            You have 3 new messages
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>Maria Hudson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>4 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>Anna Nelson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>6 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>David Muldon</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>8 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="dropdown-footer">
                            <a href="#">Show all messages</a>
                        </li>

                    </ul><!-- End Messages Dropdown Items -->

                </li><!-- End Messages Nav -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>Kevin Anderson</h6>
                            <span>Web Designer</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <?php
    include 'sidebar1.php';
    ?>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Abonnés</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Data</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-9">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Modifier un Abonné</h5>
                            <!-- Horizontal Form -->
                            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                                <div class="form-group <?php echo (!empty($nom_abonne_err)) ? 'has-error' : ''; ?>">
                                    <label>Nom</label>
                                    <input type="text" name="nom_abonne" class="form-control" value="<?php echo $nom_abonne; ?>">
                                    <span class="help-block"><?php echo $nom_abonne_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($prenom_abonne_err)) ? 'has-error' : ''; ?>">
                                    <label>Prenom</label>
                                    <textarea name="prenom_abonne" class="form-control"><?php echo $prenom_abonne; ?></textarea>
                                    <span class="help-block"><?php echo $prenom_abonne_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($username_abonne_err)) ? 'has-error' : ''; ?>">
                                    <label>username</label>
                                    <textarea name="username_abonne" class="form-control"><?php echo $username_abonne; ?></textarea>
                                    <span class="help-block"><?php echo $username_abonne_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($password_abonne_err)) ? 'has-error' : ''; ?>">
                                    <label>Password</label>
                                    <textarea name="password_abonne" class="form-control"><?php echo $password_abonne; ?></textarea>
                                    <span class="help-block"><?php echo $password_abonne_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($adresse_abonne_err)) ? 'has-error' : ''; ?>">
                                    <label>adresse</label>
                                    <textarea name="adresse_abonne" class="form-control"><?php echo $adresse_abonne; ?></textarea>
                                    <span class="help-block"><?php echo $adresse_abonne_err; ?></span>
                                </div>

                                <div class="form-group <?php echo (!empty($telephone_abonne_err)) ? 'has-error' : ''; ?>">
                                    <label>telephone</label>
                                    <textarea name="telephone_abonne" class="form-control"><?php echo $telephone_abonne; ?></textarea>
                                    <span class="help-block"><?php echo $telephone_abonne_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($categorie_abonne_err)) ? 'has-error' : ''; ?>">
                                    <label>Catégorie</label>
                                    <textarea name="categorie_abonne" class="form-control"><?php echo $categorie_abonne; ?></textarea>
                                    <span class="help-block"><?php echo $categorie_abonne_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($date_adhesion_err)) ? 'has-error' : ''; ?>">
                                    <label>Date D'adhesion</label>
                                    <textarea name="date_adhesion" class="form-control"><?php echo $date_adhesion; ?></textarea>
                                    <span class="help-block"><?php echo $date_adhesion_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($date_naissance_err)) ? 'has-error' : ''; ?>">
                                    <label>Date De naissance</label>
                                    <textarea name="date_naissance" class="form-control"><?php echo $date_naissance; ?></textarea>
                                    <span class="help-block"><?php echo $date_naissance_err; ?></span>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <a href="index.php" class="btn btn-default">Cancel</a>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.min.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.min.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>

</body>

</html>