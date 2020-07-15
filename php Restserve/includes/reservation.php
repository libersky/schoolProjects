<table>
    <tr>
        <th>Datum:</th>
        <th>Čas:</th>
        <th>Restaurace:</th>
        <th>Stůl:</th>
        <th>Na jméno:</th>
        <th>Zrušit:</th>
    </tr>
    <?php

    try{
        $reservationsQuery = $db->prepare('SELECT rest_reservation.reservation_id, rest_reservation.reservation_date, rest_reservation.reservation_time_from, rest_reservation.reservation_time_to, rest_restaurace.name, rest_table.table_number, rest_reservation.reservation_user_name
                                                                        FROM rest_reservation
                                                                        INNER JOIN rest_table
                                                                        ON rest_reservation.reservation_table_id=rest_table.table_id
                                                                        INNER JOIN rest_restaurace
                                                                        ON rest_table.table_restaurant_id=rest_restaurace.r_id
                                                                        WHERE rest_reservation.reservation_user_id=:searched
                                                                        ORDER BY rest_reservation.reservation_date ASC, rest_reservation.reservation_time_from ASC, rest_reservation.reservation_time_to ASC;');
        $reservationsQuery->execute([
            ':searched' => $_SESSION['user_id']
        ]);
        $reservations = $reservationsQuery->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e){
        error_log($e->getMessage());
    }

    if (!empty($reservations)) {
        foreach ($reservations as $reservation) {
            echo '<tr>';

            $originalDate = htmlspecialchars($reservation['reservation_date']);
            $inFormatDate = date("m. d. Y", strtotime($originalDate));

            echo    '<td>'.$inFormatDate.'</td>';

            $originalTimeFrom = htmlspecialchars($reservation['reservation_time_from']);
            $inFormatTimeFrom = date("H:i", strtotime($originalTimeFrom));

            $originalTimeTo = htmlspecialchars($reservation['reservation_time_to']);
            $inFormatTimeTo = date("H:i", strtotime($originalTimeTo));

            echo    '<td>'.$inFormatTimeFrom.' - '.$inFormatTimeTo.'</td>';
            echo    '<td>'.htmlspecialchars($reservation['name']).'</td>';
            echo    '<td>č. '.htmlspecialchars($reservation['table_number']).'</td>';
            echo    '<td>'.htmlspecialchars($reservation['reservation_user_name']).'</td>';
            echo    '<td>';
            echo    '<form method="post" action="includes/reservationCancelSystem.php">';
            echo        '<input type="hidden" value="'.htmlspecialchars($reservation['reservation_id']).'" name="reservation_id" />';
            if(isset($_GET['searched'])){
                echo    '<input type="hidden" value="searched='.htmlspecialchars($_GET['searched']).'" name="history" />';
            }
            echo        '<button class="cancelButton" name="submitCancel" type="submit">X</button>';
            echo    '</form>';
            echo    '</td>';
            echo '</tr>';
        }
    }
    else{
        echo '<tr><td class="emptyTd" colspan="7">Nemáte žádné rezervace.</td></tr>';
    }

    ?>
</table>