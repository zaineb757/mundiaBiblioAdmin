<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$nom_user = $prenom_user = $username_user = $password_user = $adresse_user = $telephone_user  = "";
$nom_user_err = $prenom_user_err = $username_user_err = $password_user_err = $adresse_user_err = $telephone_user_err  = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_nom_user = trim($_POST["nom_user"]);
    if (empty($input_nom_user)) {
        $nom_user_err = "Please enter a name.";
        //} elseif(!filter_var($input_nom_user, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nom_user_err = "Please enter a valid name.";
    } else {
        $nom_user = $input_nom_user;
    }

    // Validate prenom
    $input_prenom_user = trim($_POST["prenom_user"]);
    if (empty($input_prenom_user)) {
        $prenom_user_err = "Please enter an nom_user.";
    } else {
        $prenom_user = $input_prenom_user;
    }

    // Validate username
    $input_username_user = trim($_POST["username_user"]);
    if (empty($input_username_user)) {
        $username_user_err = "Entrer le nom d'utilisateur du nouveau l'abonné.";
    } else {
        $username_user = $input_username_user;
    }


    // Validate password
    $input_password_user = trim($_POST["password_user"]);
    if (empty($input_password_user)) {
        $password_user_err = "Entrer le mot de passe du nouveau abonné.";
    } else {
        $password_user = $input_password_user;
    }

    // Validate adresse
    $input_adresse_user = trim($_POST["adresse_user"]);
    if (empty($input_adresse_user)) {
        $adresse_user_err = "Entrer le l'adresse de l'abonné.";
    } else {
        $adresse_user = $input_adresse_user;
    }

    // Validate telephone
    $input_telephone_user = trim($_POST["telephone_user"]);
    if (empty($input_telephone_user)) {
        $telephone_user_err = "Entrer le l'telephone de l'abonné.";
    } else {
        $telephone_user = $input_telephone_user;
    }

   

    // Check input errors before inserting in database
    if (empty($nom_user_err) && empty($prenom_user_err) && empty($username_user_err) && empty($password_user_err) && empty($adresse_user_err)  && empty($telephone_user_err) ) {
        // Prepare an update statement
        $sql = "UPDATE userS SET nom_user=?, prenom_user=?,username_user=?, password_user=?,adresse_user=?,telephone_user=? WHERE ID_user=?";

        //if($stmt = mysqli_prepare($link, $sql)){
        if ($stmt = $link->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);

            $stmt->bindParam(1, $param_nom_user, PDO::PARAM_STR);
            $stmt->bindParam(2, $param_prenom_user, PDO::PARAM_STR);
            $stmt->bindParam(3, $param_username_user, PDO::PARAM_STR);
            $stmt->bindParam(4, $param_password_user, PDO::PARAM_STR);
            $stmt->bindParam(5, $param_adresse_user, PDO::PARAM_STR);
            $stmt->bindParam(6, $param_telephone_user, PDO::PARAM_STR);
            $stmt->bindParam(10, $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_nom_user = $nom_user;
            $param_prenom_user = $prenom_user;
            $param_username_user = $username_user;
            $param_password_user = $password_user;
            $param_adresse_user = $adresse_user;
            $param_telephone_user = $telephone_user;
            $param_id = $id;

            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if ($stmt->execute()) {
                // Records updated successfully. Redirect to landing page
                header("location: index_user.php");
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
        $sql = "SELECT * FROM userS WHERE ID_user= ?";
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
                    $username_user = $row["USERNAME_USER"];
                    $password_user = $row["PASSWORD_USER"];
                    $nom_user = $row["NOM_USER"];
                    $prenom_user = $row["PRENOM_USER"];
                    $adresse_user = $row["ADRESSE_USER"];
                    $telephone_user = $row["TELEPHONE_USER"];
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

    <title>bibliothécaire</title>
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
    include '../sidebar.php';
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
                                <div class="form-group <?php echo (!empty($nom_user_err)) ? 'has-error' : ''; ?>">
                                    <label>Nom</label>
                                    <input type="text" name="nom_user" class="form-control" value="<?php echo $nom_user; ?>">
                                    <span class="help-block"><?php echo $nom_user_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($prenom_user_err)) ? 'has-error' : ''; ?>">
                                    <label>Prenom</label>
                                    <textarea name="prenom_user" class="form-control"><?php echo $prenom_user; ?></textarea>
                                    <span class="help-block"><?php echo $prenom_user_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($username_user_err)) ? 'has-error' : ''; ?>">
                                    <label>username</label>
                                    <textarea name="username_user" class="form-control"><?php echo $username_user; ?></textarea>
                                    <span class="help-block"><?php echo $username_user_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($password_user_err)) ? 'has-error' : ''; ?>">
                                    <label>Password</label>
                                    <textarea name="password_user" class="form-control"><?php echo $password_user; ?></textarea>
                                    <span class="help-block"><?php echo $password_user_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($adresse_user_err)) ? 'has-error' : ''; ?>">
                                    <label>adresse</label>
                                    <textarea name="adresse_user" class="form-control"><?php echo $adresse_user; ?></textarea>
                                    <span class="help-block"><?php echo $adresse_user_err; ?></span>
                                </div>

                                <div class="form-group <?php echo (!empty($telephone_user_err)) ? 'has-error' : ''; ?>">
                                    <label>telephone</label>
                                    <textarea name="telephone_user" class="form-control"><?php echo $telephone_user; ?></textarea>
                                    <span class="help-block"><?php echo $telephone_user_err; ?></span>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <a href="index_user.php" class="btn btn-default">Cancel</a>
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