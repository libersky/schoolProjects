<?php
    date_default_timezone_set("Europe/Prague");
    $priceLimit = 300;

    session_start();
?>
<!DOCTYPE html>
<html lang="cs">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="graphics/fav.png">
        <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,500;1,300&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styles/header.css">
        <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        
        <meta name="author" content="Aleš Liberský">
        <meta name="description" content="Stránka pro rezervaci míst v restauracích.">
        <?php
            if(isset($pageName)){
                echo '<title>Restserve - '.$pageName.'</title>';
            }
            else{
                $pageName = '';
                echo '<title>Restserve</title>';
            }
        ?>
    </head>
    <body>
    <header>
        <div class="header headerLeft">
            <a class="logoLink" href="./">
                Restserve
            </a>
        </div>
        <nav class="header headerRight">
            <div class="headerItem headerStable">
                <ul class="headerMenu">
                    <?php
                        if(isset($pageName)){
                            echo '<li><a href="index.php#search">Hledat</a></li>';
                            echo '<li><a href="index.php#offer">Návrhy</a></li>';
                        }
                        else{
                            echo '<li><a href="#search">Hledat</a></li>';
                            echo '<li><a href="#offer">Návrhy</a></li>';
                        }
                    ?>
                </ul>
            </div>
            <div class="headerItem headerChangeable">
                <ul class="headerMenu">
                    <?php
                    //$_SESSION['userId'] = 23;
                    if(isset($_SESSION['user_id'])){
                        if ($pageName === 'Nástěnka'){
                            echo '<li><a class="underline" href="board.php">Nástěnka</a></li>';
                        }
                        else{
                            echo '<li><a href="board.php">Nástěnka</a></li>';
                        }
                        if($_SESSION['user_owner']==1){
                            if($pageName === 'Mé restaurace'){
                                echo '<li><a class="underline" href="myRestaurant.php">Mé&nbsp;restaurace</a></li>';
                            }
                            else{
                                echo '<li><a href="myRestaurant.php">Mé&nbsp;restaurace</a></li>';
                            }
                        }
                        if($_SESSION['user_admin']==1){
                            if($pageName === 'Správa uživatelů'){
                                echo '<li><a class="underline" href="personal.php">Správa&nbsp;uživatelů</a></li>';
                            }
                            else{
                                echo '<li><a href="personal.php">Správa&nbsp;uživatelů</a></li>';
                            }
                            if($pageName === 'Správa restaurací'){
                                echo '<li><a class="underline" href="admin.php">Správa&nbsp;restaurací</a></li>';
                            }
                            else{
                                echo '<li><a href="admin.php">Správa&nbsp;restaurací</a></li>';
                            }
                        }
                        echo '<li><a href="login/logout.php">Odhlásit</a></li>';
                    }
                    else{
                        if($pageName === 'Login'){
                            echo '<li><a class="underline" href="login.php">Přihlásit</a></li>';
                        }
                        else{
                            echo '<li><a href="login.php">Přihlásit</a></li>';
                        }
                        if($pageName === 'Registrace'){
                            echo '<li><a class="underline" href="registration.php">Registrovat</a></li>';
                        }
                        else{
                            echo '<li><a href="registration.php">Registrovat</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>
    <main>