<?php

    include '../includes/database.php';

    session_start();

    if(isset($_POST['submitLogin'])){
        $userName = $_POST['userName'];
        $userPswd = $_POST['userPswd'];

        $stmt = $db->prepare("SELECT * FROM rest_user WHERE user_email=:userName LIMIT 1");
        $stmt->execute([
            ':userName' => $userName
        ]);

        $existingUser = '';
        if ($existingUser=$stmt->fetch(PDO::FETCH_ASSOC)){
            if(password_verify($userPswd, $existingUser['user_password'])){

                $_SESSION['user_id'] = $existingUser['user_id'];
                $_SESSION['user_name'] = $existingUser['user_name'];
                $_SESSION['user_email'] = $existingUser['user_email'];
                $_SESSION['user_facebook_id'] = $existingUser['user_facebook_id'];
                $_SESSION['user_phone'] = $existingUser['user_phone'];
                $_SESSION['user_owner'] = $existingUser['user_owner'];
                $_SESSION['user_admin'] = $existingUser['user_admin'];

                if($existingUser['user_owner']==1){
                    try {
                        $restaurantsQuery = $db->prepare('SELECT rest_own.own_restaurant_id, rest_restaurace.name, rest_restaurace.title, rest_restaurace.tags, rest_restaurace.description, rest_restaurace.email, rest_restaurace.picture, rest_restaurace.opening_mo, rest_restaurace.opening_tu, rest_restaurace.opening_we, rest_restaurace.opening_we, rest_restaurace.opening_th, rest_restaurace.opening_fr, rest_restaurace.opening_sa, rest_restaurace.opening_su, rest_restaurace.phone
                                                                FROM rest_own 
                                                                INNER JOIN rest_restaurace
                                                                ON rest_own.own_restaurant_id=rest_restaurace.r_id
                                                                WHERE rest_own.own_user_id=:searched;');
                        $restaurantsQuery->execute([
                            ':searched' => $existingUser['user_id']
                        ]);
                        $restaurants = $restaurantsQuery->fetchAll(PDO::FETCH_ASSOC);
                    }
                    catch (PDOException $e){
                        error_log($e->getMessage());
                        header('Location: ../login.php?error=dberror');
                        die();
                    }

                    if (!empty($restaurants)) {
                        $_SESSION['user_restaurants'] = $restaurants;
                    }
                }

                header('Location: ../board.php?success');
            }
            else{
                header('Location: ../login.php?error=wronginput');
            }
        }
        else{

            header('Location: ../login.php?error=wronginput');
        }
    }

