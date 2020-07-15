<div class="restaurantBoard">
    <div class="userFirstBar">
        <div class="restaurantBoardTile">
            <?php
            echo '<div class="themePicture" ';
            if(!empty($restaurantArray['picture'])){
                echo 'style="background-image: url(\'graphics/'.$restaurantArray['picture'].'.jpg\')" ';
            }
            echo '></div>';
            ?>
            <h2><?php echo htmlspecialchars($restaurantArray['name']); ?></h2>
            <div class="userBoardReservation">
                <p>Rezervace v tvém podniku:</p>
                <?php
                    if(isset($_GET['success'])){
                        if($_GET['success']==='removedreservation'){
                            echo '<p class="greenLettersMargin10">Rezervace odstraněna</p>';
                        }
                    }
                    if(isset($_GET['error'])){
                        if($_GET['error']==='dberror'){
                            echo '<p class="greenLettersMargin10">Chyba databáze</p>';
                        }
                        if($_GET['error']==='unsubmited'){
                            echo '<p class="greenLettersMargin10">Požadavek nebyl korektně odeslán</p>';
                        }
                    }
                ?>
                <div class="listOfReservations">
                    <table>
                        <tr>
                            <th>Datum:</th>
                            <th>Čas:</th>
                            <th>Stůl:</th>
                            <th>Míst:</th>
                            <th>Na jméno:</th>
                            <th>Email:</th>
                            <th>Telefon:</th>
                            <th>Zrušit:</th>
                        </tr>
                        <?php

                        $searchedId = $restaurantArray['own_restaurant_id'];

                        $reservedTables = array();

                        try {
                            $reservationsQuery = $db->prepare('SELECT rest_reservation.reservation_id, rest_reservation.reservation_table_id, rest_reservation.reservation_date, rest_reservation.reservation_time_from, rest_reservation.reservation_time_to, rest_table.table_number, rest_table.table_chairs, rest_reservation.reservation_user_name, rest_reservation.reservation_user_email, rest_reservation.reservation_user_phone
                                                                            FROM rest_reservation
                                                                            LEFT JOIN rest_table
                                                                            ON rest_reservation.reservation_table_id=rest_table.table_id
                                                                            LEFT JOIN rest_user
                                                                            ON rest_reservation.reservation_user_id=rest_user.user_id
                                                                            WHERE rest_table.table_restaurant_id=:searched
                                                                            ORDER BY rest_reservation.reservation_date ASC, rest_reservation.reservation_time_from ASC, rest_reservation.reservation_time_to ASC;');
                            $reservationsQuery->execute([
                                ':searched' => $searchedId
                            ]);
                            $reservations = $reservationsQuery->fetchAll(PDO::FETCH_ASSOC);
                        }
                        catch (PDOException $e){
                            error_log($e->getMessage());
                        }

                        if (!empty($reservations)) {
                            foreach ($reservations as $reservation) {

                                if(strtotime($reservation['reservation_date'])<strtotime(date("Y-m-d"))){

                                    try{
                                        $stmt = $db->prepare('DELETE FROM rest_reservation WHERE rest_reservation.reservation_id=:searched;');
                                        $stmt->execute([
                                            ':searched' => htmlspecialchars($reservation['reservation_id'])
                                        ]);
                                    }
                                    catch (PDOException $e){
                                        error_log($e->getMessage());
                                    }

                                }
                                else{
                                    array_push($reservedTables, htmlspecialchars($reservation['reservation_table_id']));

                                    echo '<tr>';

                                    $originalDate = htmlspecialchars($reservation['reservation_date']);
                                    $inFormatDate = date("m. d. Y", strtotime($originalDate));

                                    echo    '<td>'.$inFormatDate.'</td>';

                                    $originalTimeFrom = htmlspecialchars($reservation['reservation_time_from']);
                                    $inFormatTimeFrom = date("H:i", strtotime($originalTimeFrom));

                                    $originalTimeTo = htmlspecialchars($reservation['reservation_time_to']);
                                    $inFormatTimeTo = date("H:i", strtotime($originalTimeTo));

                                    echo    '<td>'.$inFormatTimeFrom.' - '.$inFormatTimeTo.'</td>';
                                    echo    '<td>č. '.htmlspecialchars($reservation['table_number']).'</td>';
                                    echo    '<td>'.htmlspecialchars($reservation['table_chairs']).'</td>';
                                    echo    '<td>'.htmlspecialchars($reservation['reservation_user_name']).'</td>';
                                    echo    '<td>'.htmlspecialchars($reservation['reservation_user_email']).'</td>';
                                    echo    '<td>'.htmlspecialchars($reservation['reservation_user_phone']).'</td>';
                                    echo    '<td>
                                                <form id="myform" class="reservationRemover" action="includes/deleteReservation.php" method="post" onSubmit="return confirm(\'Opravdu chcete smazat rezervaci uživatele '.htmlspecialchars($reservation['reservation_user_name']).' dne '.$inFormatDate.' od '.$inFormatTimeFrom.' do '.$inFormatTimeTo.'?\');">
                                                    <input type="hidden" name="reservationId" value="'.htmlspecialchars($reservation['reservation_id']).'">
                                                    <button class="cancelButton" type="submit" name="submitDelete">Zrušit</button>
                                                </form>
                                            </td>';
                                    echo '</tr>';
                                }
                            }
                        }
                        else{
                            echo '<tr><td class="emptyTd" colspan="7">Nemáte žádné rezervace.</td></tr>';
                        }

                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="userSecondBar">
        <div class="userBoardPersonal">
            <h2>Údaje o váší restauraci <?php echo htmlspecialchars($restaurantArray['name']); ?></h2>
            <p>Pokud chcete změnit některý z&nbsp;vašich údajů, upravte pouze políčka týkající se požadované změny. Vaše úpravy se do&nbsp;systému uloží po zadání vašeho současného hesla a&nbsp;kliknutím na&nbsp;tlačítko "Provést změny."</p>
            <?php
                if ((isset($_GET['errors'])) && ($_GET['errors'] === 'none')) {
                    echo '<p class="greenLettersMargin10">Všechny změny byly provedeny úspěšně</p>';
                }
            ?>
            <form method="post" action="includes/restaurantChangeSystem.php">
                <?php

                    if (!empty($restaurantArray)){

                        echo '<h3>Údaje</h3>';
                        echo '<label class="labelSettings" for="loginInputName'.htmlspecialchars($searchedId).'">Název</label>';
                        echo '<input class="loginInput" id="loginInputName'.htmlspecialchars($searchedId).'" type="text" name="restaurantName" placeholder="Jméno restaurace" maxlength="50" minlength="2" value="'.htmlspecialchars($restaurantArray['name']).'">';
                        echo '<br>';
                        echo '<label class="labelSettings" for="loginInputTitle'.htmlspecialchars($searchedId).'">Podnázev</label>';
                        echo '<input class="loginInput" id="loginInputTitle'.htmlspecialchars($searchedId).'" type="text" name="restaurantTitle" placeholder="Titulek" maxlength="50" minlength="2" value="'.htmlspecialchars($restaurantArray['title']).'">';
                        echo '<br>';
                        echo '<label class="labelSettings" for="loginInputDescription'.htmlspecialchars($searchedId).'">Popisek</label>';
                        echo '<textarea class="loginInput descriptionInput" id="loginInputDescription'.htmlspecialchars($searchedId).'" name="restaurantDescription" placeholder="Popisek" maxlength="500">'.htmlspecialchars($restaurantArray['description']).'</textarea>';
                        echo '<br>';
                        echo '<label class="labelSettings" for="loginInputTags'.htmlspecialchars($searchedId).'">Tagy</label>';
                        echo '<textarea class="loginInput" id="loginInputTags'.htmlspecialchars($searchedId).'" name="restaurantTags" placeholder="Tagy" maxlength="500">'.htmlspecialchars($restaurantArray['tags']).'</textarea>';
                        echo '<br>';
                        echo '<p class="restSetting">Otevírací hodiny:</p>';
                        echo '<label class="labelSettings" for="loginInputOpeningMo'.htmlspecialchars($searchedId).'">Pondělí</label>';
                        echo '<input class="loginInput loginInputOpening" id="loginInputOpeningMo'.htmlspecialchars($searchedId).'" type="text" name="restaurantOpeningMo" placeholder="Otevírací hodiny pondělí" pattern="(^[0-2]?[0-9]:[0-5][0-9]\s?-\s?[0-2]?[0-9]:[0-5][0-9])|(Zavřeno)|(zavřeno)" maxlength="13" minlength="7" value="'.htmlspecialchars($restaurantArray['opening_mo']).'">';
                        echo '<br>';
                        echo '<label class="labelSettings" for="loginInputOpeningTu'.htmlspecialchars($searchedId).'">Úterý</label>';
                        echo '<input class="loginInput loginInputOpening" id="loginInputOpeningTu'.htmlspecialchars($searchedId).'" type="text" name="restaurantOpeningTu" placeholder="Otevírací hodiny úterý" pattern="(^[0-2]?[0-9]:[0-5][0-9]\s?-\s?[0-2]?[0-9]:[0-5][0-9])|(Zavřeno)|(zavřeno)" maxlength="13" minlength="7" value="'.htmlspecialchars($restaurantArray['opening_tu']).'">';
                        echo '<br>';
                        echo '<label class="labelSettings" for="loginInputOpeningWe'.htmlspecialchars($searchedId).'">Středa</label>';
                        echo '<input class="loginInput loginInputOpening" id="loginInputOpeningWe'.htmlspecialchars($searchedId).'" type="text" name="restaurantOpeningWe" placeholder="Otevírací hodiny středa" pattern="(^[0-2]?[0-9]:[0-5][0-9]\s?-\s?[0-2]?[0-9]:[0-5][0-9])|(Zavřeno)|(zavřeno)" maxlength="13" minlength="7" value="'.htmlspecialchars($restaurantArray['opening_we']).'">';
                        echo '<br>';
                        echo '<label class="labelSettings" for="loginInputOpeningTh'.htmlspecialchars($searchedId).'">Čtvrtek</label>';
                        echo '<input class="loginInput loginInputOpening" id="loginInputOpeningTh'.htmlspecialchars($searchedId).'" type="text" name="restaurantOpeningTh" placeholder="Otevírací hodiny čtvrtek" pattern="(^[0-2]?[0-9]:[0-5][0-9]\s?-\s?[0-2]?[0-9]:[0-5][0-9])|(Zavřeno)|(zavřeno)" maxlength="13" minlength="7" value="'.htmlspecialchars($restaurantArray['opening_th']).'">';
                        echo '<br>';
                        echo '<label class="labelSettings" for="loginInputOpeningFr'.htmlspecialchars($searchedId).'">Pátek</label>';
                        echo '<input class="loginInput loginInputOpening" id="loginInputOpeningFr'.htmlspecialchars($searchedId).'" type="text" name="restaurantOpeningFr" placeholder="Otevírací hodiny pátek" pattern="(^[0-2]?[0-9]:[0-5][0-9]\s?-\s?[0-2]?[0-9]:[0-5][0-9])|(Zavřeno)|(zavřeno)" maxlength="13" minlength="7" value="'.htmlspecialchars($restaurantArray['opening_fr']).'">';
                        echo '<br>';
                        echo '<label class="labelSettings" for="loginInputOpeningSa'.htmlspecialchars($searchedId).'">Sobota</label>';
                        echo '<input class="loginInput loginInputOpening" id="loginInputOpeningSa'.htmlspecialchars($searchedId).'" type="text" name="restaurantOpeningSa" placeholder="Otevírací hodiny sobota" pattern="(^[0-2]?[0-9]:[0-5][0-9]\s?-\s?[0-2]?[0-9]:[0-5][0-9])|(Zavřeno)|(zavřeno)" maxlength="13" minlength="7" value="'.htmlspecialchars($restaurantArray['opening_sa']).'">';
                        echo '<br>';
                        echo '<label class="labelSettings" for="loginInputOpeningSu'.htmlspecialchars($searchedId).'">Neděle</label>';
                        echo '<input class="loginInput loginInputOpening" id="loginInputOpeningSu'.htmlspecialchars($searchedId).'" type="text" name="restaurantOpeningSu" placeholder="Otevírací hodiny neděle" pattern="(^[0-2]?[0-9]:[0-5][0-9]\s?-\s?[0-2]?[0-9]:[0-5][0-9])|(Zavřeno)|(zavřeno)" maxlength="13" minlength="7" value="'.htmlspecialchars($restaurantArray['opening_su']).'">';
                        echo '<br>';
                        echo '<p class="restSetting">Konktakt:</p>';
                        echo '<label class="labelSettings" for="loginInputEmail'.htmlspecialchars($searchedId).'">Email</label>';
                        echo '<input class="loginInput loginInputEmail" id="loginInputEmail'.htmlspecialchars($searchedId).'" type="email" name="restaurantEmail" placeholder="Email" pattern="\w+\.?\w+@\w+\.[a-z][a-z]+" maxlength="30" minlength="5" value="'.htmlspecialchars($restaurantArray['email']).'">';
                        echo '<br>';
                        echo '<label class="labelSettings" for="loginInputPhone'.htmlspecialchars($searchedId).'">Telefoní číslo</label>';
                        echo '<input class="loginInput loginInputPhone" id="loginInputPhone'.htmlspecialchars($searchedId).'" type="tel" name="restaurantPhone" placeholder="Telefon" pattern="(^[+]420\s?)?\d{3}\s?\d{3}\s?\d{3}$" maxlength="16" minlength="9" value="'.htmlspecialchars($restaurantArray['phone']).'">';
                        echo '<br>';
                    }
                    else{
                        echo '<div>Nemáte žádnou restauraci uloženou v systému.</div>';
                    }

                    echo '<div class="confirmChanges">';
                    echo    '<h3>Potvrzení změn</h3>';
                    echo    '<input type="password" name="userPswd" placeholder="Heslo" maxlength="50" ';
                    if ((isset($_SESSION['user_facebook_id']))&&(!empty($_SESSION['user_facebook_id']))&&($_SESSION['user_facebook_id']!==$_SESSION['user_email'])){
                        echo 'readonly class="loginInput inputConfirmSettings grayBackground " ';
                    }
                    else{
                        echo 'class="loginInput inputConfirmSettings" ';
                    }
                    echo '>';
                    echo    '<input type="hidden" value="'.htmlspecialchars($searchedId).'" name="restaurantId" />';
                    echo    '<button class="loginButton" name="submitChanges" type="submit">Potvrdit změny</button>';
                    echo '</div>';
                ?>
            </form>
        </div>
        <div class="userBoardPersonal userPersonalTables" <?php echo 'id="tables'.$searchedId.'"'; ?>>
            <h2>Stoly</h2>
            <p>Není možné odebrat stůl, na&nbsp;kterém je platná rezervace. Je možné jej však zamknout, tak že si nikdo nebude moci vytvořit nouvou rezervaci a&nbsp;v&nbsp;momentě kdy se stolem nebude spjata žádná rezervace, bude možné jej odebrat.</p>
                <?php

                    try {
                        $tablesQuery = $db->prepare('SELECT rest_table.table_id, rest_table.table_number, rest_table.table_chairs, rest_table.table_level, rest_table.table_lock
                                                                FROM rest_table
                                                                WHERE rest_table.table_restaurant_id=:searched
                                                                ORDER BY rest_table.table_number ASC;');
                        $tablesQuery->execute([
                            ':searched' => $searchedId
                        ]);
                        $tables = $tablesQuery->fetchAll(PDO::FETCH_ASSOC);
                    }
                    catch (PDOException $e){
                        error_log($e->getMessage());
                    }

                    echo '<table class="tablesTable">';
                    echo    '<tr>';
                    echo        '<th>Číslo:</th>';
                    echo        '<th>Místa:</th>';
                    echo        '<th>Patro:</th>';
                    echo        '<th>Uzamčení:</th>';
                    echo        '<th colspan="2">Operace:</th>';
                    echo    '</tr>';

                    if(!empty($tables)){
                        foreach ($tables as $table){
                            echo '<tr>';
                            echo    '<td>'.htmlspecialchars($table['table_number']).'</td>';
                            echo    '<td>'.htmlspecialchars($table['table_chairs']).'</td>';
                            echo    '<td>'.htmlspecialchars($table['table_level']).'</td>';
                            if($table['table_lock']==1){

                                echo '<td>Uzamčen</td>';
                                echo '<td>
                                        <form method="post" action="includes/lock.php">
                                            <input type="hidden" value="'.htmlspecialchars($table['table_id']).'" name="table_id" />
                                            <input type="hidden" value="tables'.htmlspecialchars($searchedId).'" name="history" />
                                            <input type="hidden" value="0" name="lock" />
                                            <button class="cancelButton" name="submitLock" type="submit">Odemknout</button>
                                        </form>
                                      </td>';

                            }
                            else{

                                 echo '<td></td>';
                                 echo '<td>
                                        <form method="post" action="includes/lock.php">
                                            <input type="hidden" value="'.htmlspecialchars($table['table_id']).'" name="table_id" />
                                            <input type="hidden" value="tables'.htmlspecialchars($searchedId).'" name="history" />
                                            <input type="hidden" value="1" name="lock" />
                                            <button class="cancelButton" name="submitLock" type="submit">Zamknout</button>
                                        </form>
                                      </td>';
                            }
                            if($table['table_lock']==1) {

                                if (!in_array($table['table_id'], $reservedTables)) {

                                    echo '<td>
                                            <form method="post" action="includes/removeTable.php">
                                                <input type="hidden" value="' . htmlspecialchars($table['table_id']) . '" name="table_id" />
                                                <input type="hidden" value="tables'.htmlspecialchars($searchedId).'" name="history" />
                                                <button class="cancelButton" name="submitRemove" type="submit">Odstranit</button>
                                            </form>
                                          </td>';

                                }
                                else{

                                    echo '<td></td>';

                                }
                            }
                            else{
                                echo '<td></td>';
                            }
                            echo '</tr>';
                        }
                    }
                    else{
                        echo '<tr>';
                        echo    '<td class="emptyTd" colspan="5">Žádné stoly nebyly nalezeny.</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                ?>
            <form class="addTableForm" action="includes/addTable.php" method="post">
                <h3>Nový stůl</h3>
                <input class="addTableInput" type="text" name="tableNumber" placeholder="Číslo" pattern="\d+" minlength="1" maxlength="10" required/>
                <input class="addTableInput" type="text" name="tableChairs" placeholder="Místa" pattern="\d+" minlength="1" maxlength="3" required/>
                <input class="addTableInput" type="text" name="tableLevel" placeholder="Patro" pattern="\d+" minlength="1" maxlength="4"/>
                <input type="hidden" value="<?php echo $searchedId; ?>" name="restaurantId" />
                <input type="hidden" value="<?php echo 'tables'.htmlspecialchars($searchedId); ?>" name="history" />
                <button class="addTableButton" type="submit" name="submitAddTable">Přidat</button>
            </form>
        </div>
    </div>
</div>