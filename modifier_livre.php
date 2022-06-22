<?php
// Include config file
require_once "config_anas.php";
 
// Define variables and initialize with empty values
$titre_livre = $code_catalogue = $code_rayon = $exemplaires = $stock = $auteur = $editeur = $genre = "";
$titre_livre_err = $code_catalogue_err = $code_rayon_err = $exemplaires_err = $stock_err = $auteur_err = $editeur_err = $genre_err ="";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
	
	// Validate titre du livre
    $input_titre_livre = trim($_POST["titre_livre"]);
    if(empty($input_titre_livre)){
        $titre_livre_err = "Please enter a name.";
    } else{
        $titre_livre = $input_titre_livre;
    }
    
    // Validate code catalogue
    $input_code_catalogue = trim($_POST["code_catalogue"]);
    if(empty($input_code_catalogue)){
        $code_catalogue_err = "Please enter an nom_auteur.";     
    } else{
        $code_catalogue = $input_code_catalogue;
    }
	
	// Validate code rayon
    $input_code_rayon = trim($_POST["code_rayon"]);
    if(empty($input_code_rayon)){
        $code_rayon_err = "Please enter an nom_auteur.";     
    } else{
        $code_rayon = $input_code_rayon;
    }

    // Validate exemplaires
    $input_exemplaires = trim($_POST["exemplaires"]);
    if(empty($input_exemplaires)){
        $exemplaires_err = "Saisir le nombre d'exemplaires";     
    } else{
        $exemplaires = $input_exemplaires;
    }

    // Validate stock
    $input_stock = trim($_POST["stock"]);
    if(empty($input_stock)){
        $stock_err = "Saisir le nombre en stock !";     
    } else{
        $stock = $input_stock;
    }

    // Validate auteur
    $input_auteur = trim($_POST["auteur"]);
    if(empty($input_auteur)){
        $auteur_err = "Saisir le nom d'auteur !";     
    } else{
        $auteur = $input_auteur;
    }

    // Validate editeur
    $input_editeur = trim($_POST["editeur"]);
    if(empty($input_editeur)){
        $editeur_err = "Saisir le nom d'editeur !";     
    } else{
        $editeur = $input_editeur;
    }

    // Validate genre
    $input_genre = trim($_POST["genre"]);
    if(empty($input_genre)){
        $genre_err = "Saisir la libelle du genre !";     
    } else{
        $genre = $input_genre;
    }
    
  
    
    // Check input errors before inserting in database
    if(empty($titre_livre_err) && empty($code_catalogue_err) && empty($code_rayon_err) && empty($exemplaires_err) && empty($stock_err) && empty($auteur_err) && empty($editeur_err) && empty($genre_err)){
        // Prepare an update statement
        $sql = "UPDATE livre SET titre_livre=?, code_catalogue=?, code_rayon=?, exemplaires='$exemplaires', stock='$stock', auteur='$auteur', editeur='$editeur', genre='$genre' WHERE ID_LIVRE='$id' "; 
         
        //if($stmt = mysqli_prepare($link, $sql)){
        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);
            $stmt->bindParam(1, $param_titre_livre, PDO::PARAM_STR);
			      $stmt->bindParam(2, $param_code_catalogue, PDO::PARAM_STR);
            $stmt->bindParam(3, $param_code_rayon, PDO::PARAM_STR);
     
            $stmt->bindParam(4, $param_id, PDO::PARAM_INT);
            
            // Set parameters
            $param_titre_livre = $titre_livre;
			      $param_code_catalogue= $code_catalogue;
            $param_code_rayon = $code_rayon;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if($stmt->execute()){                               
                // Records updated successfully. Redirect to landing page
                header("location: consulter_livre.php");
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM livre WHERE ID_LIVRE = ?";
        //if($stmt = mysqli_prepare($link, $sql)){
        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "i", $param_id);
            $stmt->bindParam(1, $param_id, PDO::PARAM_INT);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if($stmt->execute()){ 
                //$result = mysqli_stmt_get_result($stmt);
                $result = $stmt->fetchAll();
    
                //if(mysqli_num_rows($result) == 1){
                if(count($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $row = $result[0];
                    
                    // Retrieve individual field value
                    $titre_livre = $row["TITRE_LIVRE"];
                    $code_catalogue = $row["CODE_CATALOGUE"];
                    $code_rayon = $row["CODE_RAYON"];
                    $exemplaires = $row["EXEMPLAIRES"];
                    $stock = $row["STOCK"];
                    $auteur = $row["AUTEUR"];
                    $editeur = $row["EDITEUR"];
                    $genre = $row["GENRE"];
                 
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        //mysqli_stmt_close($stmt);
        $stmt->closeCursor(); //PDO close
        
        // Close connection
        //mysqli_close($link);
    }  else{
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

  <title>Forms / Layouts - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

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
        <span class="d-none d-lg-block">NiceAdmin</span>
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

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="index.html">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="components-alerts.html">
              <i class="bi bi-circle"></i><span>Alerts</span>
            </a>
          </li>
          <li>
            <a href="components-accordion.html">
              <i class="bi bi-circle"></i><span>Accordion</span>
            </a>
          </li>
          <li>
            <a href="components-badges.html">
              <i class="bi bi-circle"></i><span>Badges</span>
            </a>
          </li>
          <li>
            <a href="components-breadcrumbs.html">
              <i class="bi bi-circle"></i><span>Breadcrumbs</span>
            </a>
          </li>
          <li>
            <a href="components-buttons.html">
              <i class="bi bi-circle"></i><span>Buttons</span>
            </a>
          </li>
          <li>
            <a href="components-cards.html">
              <i class="bi bi-circle"></i><span>Cards</span>
            </a>
          </li>
          <li>
            <a href="components-carousel.html">
              <i class="bi bi-circle"></i><span>Carousel</span>
            </a>
          </li>
          <li>
            <a href="components-list-group.html">
              <i class="bi bi-circle"></i><span>List group</span>
            </a>
          </li>
          <li>
            <a href="components-modal.html">
              <i class="bi bi-circle"></i><span>Modal</span>
            </a>
          </li>
          <li>
            <a href="components-tabs.html">
              <i class="bi bi-circle"></i><span>Tabs</span>
            </a>
          </li>
          <li>
            <a href="components-pagination.html">
              <i class="bi bi-circle"></i><span>Pagination</span>
            </a>
          </li>
          <li>
            <a href="components-progress.html">
              <i class="bi bi-circle"></i><span>Progress</span>
            </a>
          </li>
          <li>
            <a href="components-spinners.html">
              <i class="bi bi-circle"></i><span>Spinners</span>
            </a>
          </li>
          <li>
            <a href="components-tooltips.html">
              <i class="bi bi-circle"></i><span>Tooltips</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#" class="active">
          <i class="bi bi-journal-text"></i><span>Livres</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
          <li>
            <a href="consulter_livre.php">
              <i class="bi bi-circle"></i><span>Consulter livres</span>
            </a>
          </li>
          <li>
            <a href="ajouter_livre.php">
              <i class="bi bi-circle"></i><span>Ajouter livre</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="tables-general.html">
              <i class="bi bi-circle"></i><span>General Tables</span>
            </a>
          </li>
          <li>
            <a href="tables-general.php">
              <i class="bi bi-circle"></i><span>Data Tables</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="charts-chartjs.html">
              <i class="bi bi-circle"></i><span>Chart.js</span>
            </a>
          </li>
          <li>
            <a href="charts-apexcharts.html">
              <i class="bi bi-circle"></i><span>ApexCharts</span>
            </a>
          </li>
          <li>
            <a href="charts-echarts.html">
              <i class="bi bi-circle"></i><span>ECharts</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="icons-bootstrap.html">
              <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
            </a>
          </li>
          <li>
            <a href="icons-remix.html">
              <i class="bi bi-circle"></i><span>Remix Icons</span>
            </a>
          </li>
          <li>
            <a href="icons-boxicons.html">
              <i class="bi bi-circle"></i><span>Boxicons</span>
            </a>
          </li>
        </ul>
      </li><!-- End Icons Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-card-list"></i>
          <span>Register</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-login.html">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li><!-- End Login Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
          <i class="bi bi-dash-circle"></i>
          <span>Error 404</span>
        </a>
      </li><!-- End Error 404 Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-blank.html">
          <i class="bi bi-file-earmark"></i>
          <span>Blank</span>
        </a>
      </li><!-- End Blank Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Modifier livre</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Livres</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">

          
		<div class="col-lg-1"></div>
        <div class="col-lg-10">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Modifiez le formulaire</h5>

              <!-- Vertical Form -->
			  <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
          <div class="row"> 
            <div class="col-6 <?php echo (!empty($titre_livre_err)) ? 'has-error' : ''; ?>">
              <label class="form-label">Titre</label>
              <textarea name="titre_livre" class="form-control"><?php echo $titre_livre; ?></textarea>
              <span class="help-block"><?php echo $titre_livre_err;?></span>
            </div>
            <div class="col-6 <?php echo (!empty($code_catalogue_err)) ? 'has-error' : ''; ?>">
              <label class="form-label">Code catalogue</label>
              <textarea name="code_catalogue" class="form-control"><?php echo $code_catalogue; ?></textarea>
              <span class="help-block"><?php echo $code_catalogue_err;?></span>
            </div>
          </div> 
					<br>
          <div class="row"> 
            <div class="col-6 <?php echo (!empty($code_rayon_err)) ? 'has-error' : ''; ?>">
              <label class="form-label">Code rayon</label>
              <textarea name="code_rayon" class="form-control"><?php echo $code_rayon; ?></textarea>
              <span class="help-block"><?php echo $code_rayon_err;?></span>
            </div>
            <div class="col-3 <?php echo (!empty($exemplaires_err)) ? 'has-error' : ''; ?>">
              <label class="form-label">Exemplaires</label>
              <textarea name="exemplaires" class="form-control"><?php echo $exemplaires; ?></textarea>
              <span class="help-block"><?php echo $exemplaires_err;?></span>
            </div>
            <div class="col-3 <?php echo (!empty($stock_err)) ? 'has-error' : ''; ?>">
              <label class="form-label">Stock</label>
              <textarea name="stock" class="form-control"><?php echo $stock; ?></textarea>
              <span class="help-block"><?php echo $stock_err;?></span>
            </div>
          </div>
          <br>
          <div class="row"> 
            <div class="col-4 <?php echo (!empty($auteur_err)) ? 'has-error' : ''; ?>">
              <label class="form-label">Auteur</label>
              <select name="auteur" id="auteur" class="form-control" required>
                <option value="<?php echo $auteur; ?>"><?php echo $auteur; ?></option>
                  <?php
                    require_once "config_anas.php";
                              
                    $sql = "SELECT * FROM auteur";

                    if ($result = $link->query($sql)) {						
                      if($result){
                        foreach ($link->query($sql) as $row) {
                  ?>     
                          <option value="<?php echo $row['NOM_AUTEUR']; ?>"><?php echo $row['NOM_AUTEUR']; ?></option>
                    <?php
                    }}}
                    ?>
              </select>
            </div>
            <div class="col-4 <?php echo (!empty($editeur_err)) ? 'has-error' : ''; ?>">
              <label class="form-label">Editeur</label>
              <select name="editeur" id="editeur" class="form-control" required>
                <option value="<?php echo $editeur; ?>"><?php echo $editeur; ?></option>
                  <?php
                    require_once "config_anas.php";
                              
                    $sql = "SELECT * FROM editeur";

                    if ($result = $link->query($sql)) {						
                      if($result){
                        foreach ($link->query($sql) as $row) {
                  ?>     
                          <option value="<?php echo $row['NOM_EDITEUR']; ?>"><?php echo $row['NOM_EDITEUR']; ?></option>
                    <?php
                    }}}
                    ?>
              </select>
            </div>
            <div class="col-4 <?php echo (!empty($genre_err)) ? 'has-error' : ''; ?>">
              <label class="form-label">Genre</label>
              <select name="genre" id="genre" class="form-control" required>
                <option value="<?php echo $genre; ?>"><?php echo $genre; ?></option>
                  <?php
                    require_once "config_anas.php";
                              
                    $sql = "SELECT * FROM genre";

                    if ($result = $link->query($sql)) {						
                      if($result){
                        foreach ($link->query($sql) as $row) {
                  ?>     
                          <option value="<?php echo $row['LIBELLE_GENRE']; ?>"><?php echo $row['LIBELLE_GENRE']; ?></option>
                    <?php
                    }}}
                    ?>
              </select>
            </div>
          </div>
          <br>
					<div class="text-center">
					  <input type="hidden" name="id" value="<?php echo $id; ?>"/>
					  <a href="consulter_livre.php" class="btn btn-danger" style="margin-top:30px">Cancel</a>
					  <button type="reset" class="btn btn-secondary" style="margin-top:30px">Reset</button>
					  <button type="submit" class="btn btn-primary" style="margin-top:30px">Submit</button>
					</div>
				</form>

            </div>
          </div>
		  
        </div>
		<div class="col-lg-1"></div>
		
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
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>