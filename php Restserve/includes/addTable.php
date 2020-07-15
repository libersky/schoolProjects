<?php

    include 'database.php';

    if(isset($_POST['submitAddTable'])){

        $restaurantId = htmlspecialchars($_POST['restaurantId']);
        $tableNumber = htmlspecialchars($_POST['tableNumber']);
        $tableChairs = htmlspecialchars($_POST['tableChairs']);
        if(!empty($_POST['tableLevel'])){
            $tableLevel = htmlspecialchars($_POST['tableLevel']);
        }
        else{
            $tableLevel = 0;
        }
        $tableLock = 0;

        try{
            $stmt = $db->prepare('INSERT INTO rest_table (table_restaurant_id, table_number, table_chairs, table_level, table_lock) VALUES (:restaurantId, :number, :chairs, :level, :lock);');
            $stmt->execute([
                ':restaurantId' => $restaurantId,
                ':number' => $tableNumber,
                ':chairs' => $tableChairs,
                ':level' => $tableLevel,
                ':lock' => $tableLock
            ]);
        }
        catch (PDOException $e){
            error_log($e->getMessage());
            header('Location: ../myRestaurant.php?error=dberror');
        }

        header('Location: ../myRestaurant.php#'.$_POST['history']);

    }
    else{
        header('Location: ../myRestaurant.php?error=unsubmited');
    }
