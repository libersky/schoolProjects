<?php

    $pageName = "Mé restaurace";

    include 'includes/database.php';

    include 'includes/header.php';

    if((!empty($_SESSION['user_restaurants']))&&($_SESSION['user_owner']==1)){

        $restaurantsArray = $_SESSION['user_restaurants'];

        foreach ($restaurantsArray as $restaurantArray){

            include 'includes/restaurantList.php';

        }

    }
    else{

        header('Location: index.php');
        die();

    }

    include 'includes/footer.php';