<?php

session_start();
    require_once 'config.php'; // ajout connexion bdd 
   // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['user'])){
        header('Location:index.php');
        die();
    }

if(isset($_FILES['file'])){
    $tmpName = $_FILES['file']['tmp_name'];
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];
    $id = $_FILES['file']['id'];
}

?>

<!DOCTYPE html>
<html>
    <head>
       
        
        <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
          <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <style>
        .container {
            max-width: 1000px
        }
        .custom-select {
            max-width: 140px
        }
        .images{
    display: inline-grid;
    grid-template-columns: 1fr 1fr 1fr ;
    
    border: solid;
}
img {
    border: 1px solid black;
  border-radius: 4px;
  padding: 10px;
  width: 320px;
  height: 250px;
  margin:5px;

}
.wrapper {
    grid-column: 2 / -2;
  }

  .left-edge {
    grid-column: 1 / -2;
  }

  .right-wrapper {
    grid-column: 4 / -2;
  }
  
  .navbar-nav{
    justify-content: center;

  }
  img:hover{
-ms-transform: scale(1.3); /* IE 9 */
-webkit-transform: scale(1.3); /* Safari 3-8 */
transform: scale(1.3);
}

    </style>

    </head>
<body>
  
<nav class="navbar navbar-expand-sm bg-dark justify-content-center">
   <!-- Links -->
   <ul class="navbar-nav">
      <li class="nav-item">
         <a class="nav-link" href="Admin.php">Home</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="LireRecursDir.php">Lecture Recursive</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="deconnexion.php">Deconnexion</a>
      </li>
   </ul>
</nav>

    <?php 
        $req = $db->query('SELECT name FROM file'); // selectionner les images de la bdd
      
         
  $limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 6;
  $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
  $paginationStart = ($page - 1) * $limit;
  // executer la recette pour recuperer les enregistrment de la bdd
  $files = $db->query("SELECT * FROM file LIMIT $paginationStart, $limit")->fetchAll();

  // recuperer le nombre d'enregistrement
  $sql = $db->query("SELECT count(id) AS id FROM file")->fetchAll();
  $allRecrods = $sql[0]['id'];
  
  // nombre total de page
  $totoalPages = ceil($allRecrods / $limit);
  // affichage suivant et précedent
  $prev = $page - 1;
  $next = $page + 1;
?>

<!---------------------------------------- PARTIE HTML-----------------------------------------------------------------> 
<div class="container">
    <br>
    <div class="images">
    
        <!-- affichage dans le navigateur de la bdd -->
        
                
                <?php foreach($files as $file):
            
            echo "<div> <img src='".$file['name']."' width='300px' title='".$file['name']."'> ";
            
                  echo " <br> <a href=\"delete.php?id=$file[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">
                  <i class='fa fa-trash'  style='color:red' ></i> </a></div>";		

                endforeach; ?>
               
               </div>
                
        <!-- Pagination -->
       
        <nav aria-label="Page navigation example mt-5">
        <br>
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                    <a class="page-link"
                        href="<?php if($page <= 1){ echo '#'; } else { echo "?page=" . $prev; } ?>">Précédent</a>
                </li>
                <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
                <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                    <a class="page-link" href="Admin.php?page=<?= $i; ?>"> <?= $i; ?> </a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
                    <a class="page-link"
                        href="<?php if($page >= $totoalPages){ echo '#'; } else {echo "?page=". $next; } ?>">suivant</a>
                </li>
            </ul>
        </nav>
        
</div>
</body>
</html>        