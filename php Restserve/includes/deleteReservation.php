<?php

    include 'database.php';

    if(isset($_POST['submitDelete'])){

        try {
            $reservationId = htmlspecialchars($_POST['reservationId']);

            $stmt = $db->prepare('DELETE FROM rest_reservation WHERE rest_reservation.reservation_id=:searched;');
            $stmt->execute([
                ':searched' => $reservationId
            ]);
        }
        catch (PDOException $e){
            error_log($e->getMessage());
            header('Location: ../myRestaurant.php?error=dberror');
            die();
        }

        header('Location: ../myRestaurant.php?success=removedreservation');

    }
    else{
        header('Location: ../myRestaurant.php?error=unsubmited');
    }