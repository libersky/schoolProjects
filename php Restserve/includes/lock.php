<?php

    include 'database.php';

    if(isset($_POST['submitLock'])){

        $lock = htmlspecialchars($_POST['lock']);
        $tableId = htmlspecialchars($_POST['table_id']);

        try {
            $locker = $db->prepare('UPDATE rest_table SET table_lock=:value WHERE rest_table.table_id=:searched;');
            $locker->execute([
                ':value' => $lock,
                ':searched' => $tableId
            ]);
        }
        catch (PDOException $e){
            error_log($e->getMessage());
            header('Location: ../myRestaurant.php?error=dberror');
            die();
        }



        header('Location: ../myRestaurant.php#'.$_POST['history']);

    }
    else{
        header('Location: ../myRestaurant.php?error=unsubmited');
    }