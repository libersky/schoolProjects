<?php

    session_start();
    unset($_SESSION["user_id"]);
    unset($_SESSION["user_name"]);
    unset($_SESSION["user_email"]);
    unset($_SESSION['user_facebook_id']);
    unset($_SESSION["user_phone"]);
    unset($_SESSION["user_owner"]);
    unset($_SESSION["user_admin"]);
    unset($_SESSION["user_restaurants"]);
    header('Location: ../index.php?logout');

