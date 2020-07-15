<?php

    include 'database.php';

    if(isset($_POST['submitCancel'])){

        try{
            $reservationId = htmlspecialchars($_POST['reservation_id']);

            $stmt = $db->prepare('DELETE FROM rest_reservation WHERE rest_reservation.reservation_id=:searched;');
            $stmt->execute([
                ':searched' => $reservationId
            ]);
        }
        catch (PDOException $e){
            error_log($e->getMessage());
            header('Location: ../board.php?error=dberror');
            die();
        }



        if(isset($_POST['history'])){
            header('Location: ../searchPage.php?'.htmlspecialchars($_POST['history']).'&success=reservationcanceled');
        }
        else{
            header('Location: ../board.php?success=reservationcanceled');
        }

    }
    else{

        if(isset($_POST['history'])){
            header('Location: ../searchPage.php?'.htmlspecialchars($_POST['history']).'&errors=reservationnotfound');
        }
        else{
            header('Location: ../board.php?errors=reservationnotfound');
        }
    }