<?php

    include 'database.php';



    if(isset($_POST['periodSubmit'])&&isset($_POST['restaurantId'])&&isset($_POST['chosenLevel'])&&isset($_POST['chosenTimeTo'])&&isset($_POST['chosenTimeFrom'])&&isset($_POST['chosenDay'])){

        $restaurantId = htmlspecialchars($_POST['restaurantId']);
        $chosenTimeTo = htmlspecialchars($_POST['chosenTimeTo']);
        $chosenTimeFrom = htmlspecialchars($_POST['chosenTimeFrom']);
        $chosenDay = htmlspecialchars($_POST['chosenDay']);
        $chosenLevel = htmlspecialchars($_POST['chosenLevel']);
        $history= htmlspecialchars($_POST['history']);

        try{
            $restaurantQuery = $db->prepare('SELECT rest_restaurace.opening_mo, rest_restaurace.opening_tu, rest_restaurace.opening_we, rest_restaurace.opening_th, rest_restaurace.opening_fr, rest_restaurace.opening_sa, rest_restaurace.opening_su 
                                                        FROM rest_restaurace 
                                                        WHERE rest_restaurace.r_id=:searched LIMIT 1;');
            $restaurantQuery->execute([
                ':searched' => $restaurantId
            ]);
            $restaurant = $restaurantQuery->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e){
            error_log($e->getMessage());
            header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=dbrestcrash');
            die();
        }

        $dayOfTheWeek = date('w', strtotime($chosenDay));
        $startChosenTime = explode(":", $chosenTimeFrom);
        $endChosenTime = explode(":", $chosenTimeTo);

        switch ($dayOfTheWeek){
            case 0:
                $openingHoursSu = htmlspecialchars($restaurant['opening_su']);
                if(strpos($openingHoursSu, 'avřeno') !== false){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isclosedSu');
                    die();
                }
                $hours = explode("-", $openingHoursSu);
                $opening = explode(":", $hours[0]);
                $openingHour = $opening[0];
                $closing = explode(":", $hours[1]);
                $closingHour = $closing[0];
                if($startChosenTime[0]<$openingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isnotopenyetSu');
                    die();
                }
                if($startChosenTime[0]>=$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedSu');
                    die();
                }
                if($endChosenTime[0]>$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedSu');
                    die();
                }
                break;
            case 1:
                $openingHoursMo = htmlspecialchars($restaurant['opening_mo']);
                if(strpos($openingHoursMo, 'avřeno') !== false){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isclosedMo');
                    die();
                }
                $hours = explode("-", $openingHoursMo);
                $opening = explode(":", $hours[0]);
                $openingHour = $opening[0];
                $closing = explode(":", $hours[1]);
                $closingHour = $closing[0];
                if($startChosenTime[0]<$openingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isnotopenyetMo');
                    die();
                }
                if($startChosenTime[0]>=$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedMo');
                    die();
                }
                if($endChosenTime[0]>$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedMo');
                    die();
                }
                break;
            case 2:
                $openingHoursTu = htmlspecialchars($restaurant['opening_tu']);
                if(($openingHoursTu === 'Zavřeno')||($openingHoursTu === 'zavřeno')){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isclosedTu');
                    die();
                }
                $hours = explode("-", $openingHoursTu);
                $opening = explode(":", $hours[0]);
                $openingHour = $opening[0];
                $closing = explode(":", $hours[1]);
                $closingHour = $closing[0];
                if($startChosenTime[0]<$openingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isnotopenyetTu');
                    die();
                }
                if($startChosenTime[0]>=$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedTu');
                    die();
                }
                if($endChosenTime[0]>$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedTu');
                    die();
                }
                break;
            case 3:
                $openingHoursWe = htmlspecialchars($restaurant['opening_we']);
                if(($openingHoursWe === 'Zavřeno')||($openingHoursWe === 'zavřeno')){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isclosedWe');
                    die();
                }
                $hours = explode("-", $openingHoursWe);
                $opening = explode(":", $hours[0]);
                $openingHour = $opening[0];
                $closing = explode(":", $hours[1]);
                $closingHour = $closing[0];
                if($startChosenTime[0]<$openingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isnotopenyetWe');
                    die();
                }
                if($startChosenTime[0]>=$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedWe');
                    die();
                }
                if($endChosenTime[0]>$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedWe');
                    die();
                }
                break;
            case 4:
                $openingHoursTh = htmlspecialchars($restaurant['opening_th']);
                if(($openingHoursTh === 'Zavřeno')||($openingHoursTh === 'zavřeno')){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isclosedTh');
                    die();
                }
                $hours = explode("-", $openingHoursTh);
                $opening = explode(":", $hours[0]);
                $openingHour = $opening[0];
                $closing = explode(":", $hours[1]);
                $closingHour = $closing[0];
                if($startChosenTime[0]<$openingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isnotopenyetTh');
                    die();
                }
                if($startChosenTime[0]>=$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedTh');
                    die();
                }
                if($endChosenTime[0]>$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedTh');
                    die();
                }
                break;
            case 5:
                $openingHoursFr = htmlspecialchars($restaurant['opening_fr']);
                if(($openingHoursFr === 'Zavřeno')||($openingHoursFr === 'zavřeno')){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isclosedFr');
                    die();
                }
                $hours = explode("-", $openingHoursFr);
                $opening = explode(":", $hours[0]);
                $openingHour = $opening[0];
                $closing = explode(":", $hours[1]);
                $closingHour = $closing[0];
                if($startChosenTime[0]<$openingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isnotopenyetFr');
                    die();
                }
                if($startChosenTime[0]>=$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedFr');
                    die();
                }
                if($endChosenTime[0]>$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedFr');
                    die();
                }
                break;
            case 6:
                $openingHoursSa = htmlspecialchars($restaurant['opening_sa']);
                if(($openingHoursSa === 'Zavřeno')||($openingHoursSa === 'zavřeno')){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isclosedSa');
                    die();
                }
                $hours = explode("-", $openingHoursSa);
                $opening = explode(":", $hours[0]);
                $openingHour = $opening[0];
                $closing = explode(":", $hours[1]);
                $closingHour = $closing[0];
                if($startChosenTime[0]<$openingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isnotopenyetSa');
                    die();
                }
                if($startChosenTime[0]>=$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedSa');
                    die();
                }
                if($endChosenTime[0]>$closingHour){
                    header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=isalreadyclosedSa');
                    die();
                }
                break;
            default:
                header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=daynotfound');
                die();
        }

        try{
            $reservationsQuery = $db->prepare('SELECT rest_reservation.reservation_table_id, rest_reservation.reservation_time_from, rest_reservation.reservation_time_to, rest_reservation.reservation_date 
                                                        FROM rest_reservation 
                                                        LEFT JOIN rest_table 
                                                        ON rest_reservation.reservation_table_id=rest_table.table_id 
                                                        WHERE rest_table.table_restaurant_id=:searched;');
            $reservationsQuery->execute([
                ':searched' => $restaurantId
            ]);
            $reservations = $reservationsQuery->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e){
            error_log($e->getMessage());
            header('Location: ../restaurant.php?restaurantid='.$restaurantId.'&error=dbresecrash');
            die();
        }


        $result = "date=".$chosenDay."&timeTo=".$chosenTimeTo."&timeFrom=".$chosenTimeFrom."&level=".$chosenLevel."&".$history."&tables=";
        foreach ($reservations as $reservation) {
            if ($chosenDay == $reservation['reservation_date']) {
                $startTime = explode(":", $reservation['reservation_time_from']);
                $endTime = explode(":", $reservation['reservation_time_to']);
                if (!((($startChosenTime[0] <= $startTime[0]) && ($endChosenTime[0] <= $startTime[0])) || ($startChosenTime[0] >= $endTime[0]))) {
                    $result = $result.$reservation['reservation_table_id']."-";
                }
            }
        }

        header("Location: ../restaurant.php?" . $result);

    }
    else{
        header("Location: ../index.php?error=fatalerror&".$_POST['periodSubmit']." - ".$_POST['restaurantId']." - ".$_POST['chosenLevel']." - ".$_POST['chosenTimeTo']." - ".$_POST['chosenTimeFrom']." - ".$_POST['chosenDay']);
    }



