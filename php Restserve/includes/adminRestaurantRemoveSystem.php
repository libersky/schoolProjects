<?php

    include 'database.php';

    if (isset($_POST['submitRemove'])) {

        $restaurantId = htmlspecialchars($_POST['restaurant_id']);

        if (!empty($restaurantId)){

            try{
                $stmt = $db->prepare('DELETE FROM rest_own WHERE rest_own.own_restaurant_id=:searched;');
                $stmt->execute([
                    ':searched' => $restaurantId
                ]);
            }
            catch (PDOException $e){
                error_log($e->getMessage());
                header('Location: ../admin.php?error=dbowncrash');
                die();
            }


            try{
                $stmt = $db->prepare('DELETE FROM rest_restaurace WHERE rest_restaurace.r_id=:searched;');
                $stmt->execute([
                    ':searched' => $restaurantId
                ]);

                header('Location: ../admin.php?success=removed');
                die();

            }
            catch (PDOException $e){
                error_log($e->getMessage());
            }

            header('Location: ../admin.php?error=dbrestaurantcrash');

        }
        else{
            header('Location: ../admin.php?error=emptyrestaurantid');
        }
    }
    else {
        header('Location: ../admin.php?error=unsubmited');
    }