<?php

    include 'database.php';

    if(isset($_POST['submitOwn'])){

        $own = htmlspecialchars($_POST['own']);
        $userId = htmlspecialchars($_POST['user_id']);

        try{
            $owner = $db->prepare('UPDATE rest_user SET user_owner=:value WHERE rest_user.user_id=:searched;');
            $owner->execute([
                ':value' => $own,
                ':searched' => $userId
            ]);

            if($own == 0){
                $remover = $db->prepare('DELETE FROM rest_own WHERE rest_own.own_user_id=:searched;');
                $remover->execute([
                    ':searched' => $userId
                ]);
            }

            header('Location: ../personal.php?success=owned');
            die();
        }
        catch (PDOException $e){
            error_log($e->getMessage());
        }

        header('Location: ../personal.php?error=dberror');

    }
    else{
        header('Location: ../personal.php?error=unsubmited');
    }
