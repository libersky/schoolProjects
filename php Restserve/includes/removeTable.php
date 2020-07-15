<?php

    include 'database.php';

    if(isset($_POST['submitRemove'])){

        try {
            $tableId = htmlspecialchars($_POST['table_id']);

            $stmt = $db->prepare('DELETE FROM rest_table WHERE rest_table.table_id=:searched AND rest_table.table_lock=1;');
            $stmt->execute([
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