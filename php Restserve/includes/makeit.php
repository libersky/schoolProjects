<?php

    if(isset($_POST['prepareReservation'])){
        header("Location: ../restaurant.php?".htmlspecialchars($_POST['restaurantId'])."&".htmlspecialchars($_POST['date'])."&".htmlspecialchars($_POST['timeTo'])."&".htmlspecialchars($_POST['timeFrom'])."&".htmlspecialchars($_POST['level'])."&".htmlspecialchars($_POST['tables'])."&".htmlspecialchars($_POST['chosenTable'])."&".htmlspecialchars($_POST['chosenTableId']));
    }
    else{
        header("Location: ../index.php?error=somewhere&".htmlspecialchars($_POST['restaurantId'])."&".htmlspecialchars($_POST['date'])."&".htmlspecialchars($_POST['timeTo'])."&".htmlspecialchars($_POST['timeFrom'])."&".htmlspecialchars($_POST['level'])."&".htmlspecialchars($_POST['tables'])."&".htmlspecialchars($_POST['chosenTable'])."&".htmlspecialchars($_POST['chosenTableId']));
    }
