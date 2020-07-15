<?php

    $pageName = "Rezervace";

    include 'includes/header.php';
    include 'includes/database.php';

    if((isset($_GET['restaurantid']))&&(!empty($_GET['restaurantid']))){

        try{
            $restaurantQuery = $db->prepare('SELECT * FROM rest_restaurace WHERE r_id=:searched LIMIT 1;');
            $restaurantQuery->execute([
                ':searched' => htmlspecialchars($_GET['restaurantid'])
            ]);
        }
        catch (PDOException $e){
            error_log($e->getMessage());
            header('Location: ../index.php?error=dbrestcrash');
            die();
        }

        $restaurant = $restaurantQuery->fetch(PDO::FETCH_ASSOC);

        $restaurantId = htmlspecialchars($restaurant['r_id']);
        $restaurantName = htmlspecialchars($restaurant['name']);
        $restaurantTitle = htmlspecialchars($restaurant['title']);
        $restaurantTags = htmlspecialchars($restaurant['tags']);
        $restaurantDescription = htmlspecialchars($restaurant['description']);
        $restaurantOpeningMo = htmlspecialchars($restaurant['opening_mo']);
        $restaurantOpeningTu = htmlspecialchars($restaurant['opening_tu']);
        $restaurantOpeningWe = htmlspecialchars($restaurant['opening_we']);
        $restaurantOpeningTh = htmlspecialchars($restaurant['opening_th']);
        $restaurantOpeningFr = htmlspecialchars($restaurant['opening_fr']);
        $restaurantOpeningSa = htmlspecialchars($restaurant['opening_sa']);
        $restaurantOpeningSu = htmlspecialchars($restaurant['opening_su']);
        $restaurantPicture = htmlspecialchars($restaurant['picture']);
        $restaurantEmail = htmlspecialchars($restaurant['email']);
        $restaurantPhone = htmlspecialchars($restaurant['phone']);
        $restaurantCity = htmlspecialchars($restaurant['city']);
        $restaurantStreet = htmlspecialchars($restaurant['street']);
        $restaurantNo = htmlspecialchars($restaurant['no']);
        $restaurantZip = htmlspecialchars($restaurant['zip']);

?>

        <div class="reservationContainer">
            <div class="choose-restaurant-description">
                <?php
                    echo '<h2>'.$restaurantName.'</h2>';
                    if(isset($restaurantTitle)&&(!empty($restaurantTitle))){
                        echo '<h3>'.$restaurantTitle.'</h3>';
                    }
                    echo '<p class="descriptionText">'.$restaurantDescription.'</p>';
                    echo '<h3>Kontakt:</h3>';
                    echo '<p class="descriptionContact">'.$restaurantPhone.'</p>';
                    echo '<p class="descriptionContact">'.$restaurantEmail.'</p>';
                    echo '<h3>Adresa:</h3>';
                    echo '<ul>';
                    echo    '<li>'.$restaurantCity.'</li>';
                    echo    '<li>'.$restaurantStreet.'</li>';
                    echo    '<li>'.$restaurantNo.'</li>';
                    echo    '<li>'.$restaurantZip.'</li>';
                    echo '</ul>';
                    echo '<h3>Otevírací doba:</h3>';
                    echo '<div class="choose-restaurant-openninghours"><ul>';
                        echo '<li>Pondělí:&nbsp;'.$restaurantOpeningMo.'</li>';
                        echo '<li>Úterý:&nbsp;  '.$restaurantOpeningTu.'</li>';
                        echo '<li>Středa:&nbsp; '.$restaurantOpeningWe.'</li>';
                        echo '<li>Čtvrtek:&nbsp;'.$restaurantOpeningTh.'</li>';
                        echo '<li>Pátek:&nbsp;  '.$restaurantOpeningFr.'</li>';
                        echo '<li>Sobota:&nbsp; '.$restaurantOpeningSa.'</li>';
                        echo '<li>Neděle:&nbsp; '.$restaurantOpeningSu.'</li>';
                    echo '</ul></div>';
                ?>
            </div>
            <div class="restaurantReservation">
                <?php

                try{
                    $tablesQuery = $db->prepare('SELECT * FROM rest_table WHERE table_restaurant_id=:searched AND table_lock=0;');
                    $tablesQuery->execute([
                        ':searched' => $restaurantId
                    ]);
                }
                catch (PDOException $e){
                    error_log($e->getMessage());
                    header('Location: ../index.php?error=dbrestcrash');
                    die();
                }

                $tables = $tablesQuery->fetchAll(PDO::FETCH_ASSOC);

                if ((isset($_GET['tableLevel']))&&($_GET['tableLevel']>0)){
                    $chosenTableLevel = $_GET['tableLevel'];
                }
                else{
                    $chosenTableLevel = 0;
                }

                #region Option

                echo '<div class="choose-restaurant-option">
                        <form id="reservationOptionForm" action="includes/getTables.php" method="post">';

                        if(isset($_GET['date'])){
                            echo '<input class="choose-input day-input" id="dateInput" type="date" name="chosenDay" min="'.date("Y-m-d").'" max="'.date('Y-m-d', strtotime('+1 month')).'" value="'.htmlspecialchars($_GET['date']).'" required>';
                        }
                        else{
                            echo '<input class="choose-input day-input" id="dateInput" type="date" name="chosenDay" min="'.date("Y-m-d").'" max="'.date('Y-m-d', strtotime('+1 month')).'" required>';
                        }


                        echo '<select class="choose-input" id="timeFromInput" name="chosenTimeFrom" required>';
                        echo '<option class="timeFromInputOption" value="">Rezervace od...</option>';
                        if(isset($_GET['timeFrom'])){
                            $receivedTimeFrom = htmlspecialchars($_GET['timeFrom']);
                            for($i = 6; $i <= 23; $i++){
                                $hour = $i.':00';
                                if($receivedTimeFrom == $hour){
                                    echo '<option class="timeFromInputOption" selected="selected" value="'.$hour.'">'.$hour.'</option>';
                                }else{
                                    echo '<option class="timeFromInputOption" value="'.$hour.'">'.$hour.'</option>';
                                }
                            }
                        }
                        else{
                            for($i = 6; $i <= 23; $i++){
                                $hour = $i.':00';
                                echo '<option class="timeFromInputOption" value="'.$hour.'">'.$hour.'</option>';
                            }
                        }
                        echo '</select>';




                        echo '<select class="choose-input" id="timeToInput" name="chosenTimeTo">';
                        echo '<option class="timeToInputOption" value="">Rezervace do...</option>';
                        if(isset($_GET['timeTo'])){
                            $receivedTimeTo = htmlspecialchars($_GET['timeTo']);
                            for($i = 6; $i < 23; $i++){
                                $hour = $i.':00';
                                if($receivedTimeTo == $hour){
                                    echo '<option class="timeToInputOption" selected="selected" value="'.$hour.'">'.$hour.'</option>';
                                }else{
                                    echo '<option class="timeToInputOption" value="'.$hour.'">'.$hour.'</option>';
                                }
                            }
                        }
                        else{
                            for($i = 7; $i < 24; $i++){
                                $hour = $i.':00';
                                echo '<option class="timeToInputOption" value="'.$hour.'">'.$hour.'</option>';
                            }
                        }
                        echo '</select>';


                       /* if(isset($_GET['level'])){
                            $receivedLevel = htmlspecialchars($_GET['level']);
                        }else{*/
                            echo '  <select class="choose-input" id="levelInput" name="chosenLevel">
                                        <option value="0">0. patro</option>
                                    </select>';
                        //}
                        echo '<input type="hidden" name="restaurantId" value="'.$restaurantId.'">';
                        echo '<input type="hidden" name="history" value="restaurantid='.$restaurantId.'">';
                        echo '<button class="reservation-submit" type="submit" name="periodSubmit">Vybrat termín</button>';

                echo    '</form>
                    </div>';

                #endregion

                if(isset($_GET['success'])){
                    if($_GET['success']==='reservationmade'){
                        echo '<p class="greenLettersMargin10">Rezervace vytvořena</p>';
                    }
                }

                if(isset($_GET['error'])){
                    switch (htmlspecialchars($_GET['error'])){
                        case 'isclosedSu':
                            echo '<p class="redLettersMargin10">V neděli je zavřeno</p>';
                            break;
                        case 'isnotopenyetSu':
                            echo '<p class="redLettersMargin10">V tuto dobu není v neděli ještě otevřeno</p>';
                            break;
                        case 'isalreadyclosedSu':
                            echo '<p class="redLettersMargin10">V tento čas v neděli je restaurace již zavřena</p>';
                            break;
                        case 'isclosedMo':
                            echo '<p class="redLettersMargin10">V pondělí je zavřeno</p>';
                            break;
                        case 'isnotopenyetMo':
                            echo '<p class="redLettersMargin10">V tuto dobu není v pondělí ještě otevřeno</p>';
                            break;
                        case 'isalreadyclosedMo':
                            echo '<p class="redLettersMargin10">V tento čas v pondělí je restaurace již zavřena</p>';
                            break;
                        case 'isclosedTu':
                            echo '<p class="redLettersMargin10">V úterý je zavřeno</p>';
                            break;
                        case 'isnotopenyetTu':
                            echo '<p class="redLettersMargin10">V tuto dobu není v úterý ještě otevřeno</p>';
                            break;
                        case 'isalreadyclosedTu':
                            echo '<p class="redLettersMargin10">V tento čas v úterý je restaurace již zavřena</p>';
                            break;
                        case 'isclosedWe':
                            echo '<p class="redLettersMargin10">Ve středu je zavřeno</p>';
                            break;
                        case 'isnotopenyetWe':
                            echo '<p class="redLettersMargin10">V tuto dobu není ve středu ještě otevřeno</p>';
                            break;
                        case 'isalreadyclosedWe':
                            echo '<p class="redLettersMargin10">V tento čas ve středu je restaurace již zavřena</p>';
                            break;
                        case 'isclosedTh':
                            echo '<p class="redLettersMargin10">Ve čtvrtek je zavřeno</p>';
                            break;
                        case 'isnotopenyetTh':
                            echo '<p class="redLettersMargin10">V tuto dobu není ve čtvrtek ještě otevřeno</p>';
                            break;
                        case 'isalreadyclosedTh':
                            echo '<p class="redLettersMargin10">V tento čas ve čtvrtek je restaurace již zavřena</p>';
                            break;
                        case 'isclosedFr':
                            echo '<p class="redLettersMargin10">V pátek je zavřeno</p>';
                            break;
                        case 'isnotopenyetFr':
                            echo '<p class="redLettersMargin10">V tuto dobu není v pátek ještě otevřeno</p>';
                            break;
                        case 'isalreadyclosedFr':
                            echo '<p class="redLettersMargin10">V tento čas v pátek je restaurace již zavřena</p>';
                            break;
                        case 'isclosedSa':
                            echo '<p class="redLettersMargin10">V sobotu je zavřeno</p>';
                            break;
                        case 'isnotopenyetSa':
                            echo '<p class="redLettersMargin10">V sobotu dobu není v neděli ještě otevřeno</p>';
                            break;
                        case 'isalreadyclosedSa':
                            echo '<p class="redLettersMargin10">V sobotu čas v neděli je restaurace již zavřena</p>';
                            break;
                    }
                }

                echo '<div class="chosen-table">
                        <table>';
                echo    '<tr>
                            <th>Číslo stolu:</th>
                            <th>Patro:</th>
                            <th>Počet míst:</th>
                            <th>Stav:</th>
                            <th class="narrow">Rezervovat:</th>
                         </tr>';


                    if((isset($_GET['tables']))&&(isset($_GET['date']))&&(isset($_GET['timeFrom']))&&(isset($_GET['timeTo']))){

                        $occupied = explode("-", $_GET['tables']);

                        $start = explode(":",htmlspecialchars($_GET['timeFrom']));
                        $end = explode(":",htmlspecialchars($_GET['timeTo']));
                        if(!($start[0]>=$end[0])) {

                            foreach ($tables as $table) {


                                if ($table['table_level'] == $chosenTableLevel) {

                                    echo '<tr>
                                        <td>'. $table['table_number'] . '</td>
                                        <td>' . $table['table_level'] . '</td>
                                        <td>' . $table['table_chairs'] . '</td>';


                                    if (in_array($table['table_id'], $occupied) === false) {
                                        if((isset($_GET['chosenTableId']))&&($_GET['chosenTableId']===$table['table_id'])){
                                            echo   '<td>Volno</td>
                                                <td class="narrow">
                                                    <form action="includes/makeit.php" method="post">
                                                        <input type="hidden" name="restaurantId" value="restaurantid=' . $restaurantId . '">
                                                        <input type="hidden" name="date" value="date=' . htmlspecialchars($_GET['date']) . '">
                                                        <input type="hidden" name="timeTo" value="timeTo=' . htmlspecialchars($_GET['timeTo']) . '">
                                                        <input type="hidden" name="timeFrom" value="timeFrom=' . htmlspecialchars($_GET['timeFrom']) . '">
                                                        <input type="hidden" name="level" value="level=' . htmlspecialchars($_GET['level']) . '">
                                                        <input type="hidden" name="tables" value="tables=' . htmlspecialchars($_GET['tables']) . '">
                                                        <input type="hidden" name="chosenTable" value="chosenTable=' . $table['table_number'] . '">
                                                        <input type="hidden" name="chosenTableId" value="chosenTableId=' . $table['table_id'] . '">
                                                        <button class="cancelButton buttonDoReservation grayBackground" type="submit" name="prepareReservation">Vybráno</button>
                                                    </form>
                                                </td>';
                                        }
                                        else{
                                            echo   '<td>Volno</td>
                                                <td class="narrow">
                                                    <form action="includes/makeit.php" method="post">
                                                        <input type="hidden" name="restaurantId" value="restaurantid=' . $restaurantId . '">
                                                        <input type="hidden" name="date" value="date=' . htmlspecialchars($_GET['date']) . '">
                                                        <input type="hidden" name="timeTo" value="timeTo=' . htmlspecialchars($_GET['timeTo']) . '">
                                                        <input type="hidden" name="timeFrom" value="timeFrom=' . htmlspecialchars($_GET['timeFrom']) . '">
                                                        <input type="hidden" name="level" value="level=' . htmlspecialchars($_GET['level']) . '">
                                                        <input type="hidden" name="tables" value="tables=' . htmlspecialchars($_GET['tables']) . '">
                                                        <input type="hidden" name="chosenTable" value="chosenTable=' . $table['table_number'] . '">
                                                        <input type="hidden" name="chosenTableId" value="chosenTableId=' . $table['table_id'] . '">
                                                        <button class="cancelButton buttonDoReservation" type="submit" name="prepareReservation">Rezervovat</button>
                                                    </form>
                                                </td>';
                                        }
                                    } else {
                                        echo '<td>Obsazeno</td>
                                                     <td class="narrow"></td>';
                                    }
                                    echo '</tr>';
                                }
                            }
                        }
                        else{
                            echo '<tr><td colspan="5">Chybný čas</td></tr>';
                        }
                    }
                    else {
                        echo '<tr><td colspan="5">Vyberte termín</td></tr>';
                    }

                    echo '</table></div>';



                ?>
            </div>

            <?php
                if(isset($_GET['chosenTable'])){
                    echo '<div class="choose-reservation-form restaurantControl greenBackground">';
                }
                else{
                    echo '<div class="choose-reservation-form restaurantControl">';
                }
            ?>
                <h2>Vaše objednávka</h2>
                <form action="includes/createReservation.php" method="post">
                    <fieldset>
                        <label for="restaurantName">Restaurace:</label>
                        <input class="reservation-input" id="restaurantName" readonly type="text" name="resturant" value="<?PHP echo $restaurantName; ?>" required>
                    </fieldset>
                    <fieldset>
                        <label for="userName">Jméno:</label>
                        <input class="reservation-input" id="userName" type="text" name="name" placeholder="#### ######" pattern="^\p{Lu}\p{Ll}+(\s\p{Lu}\p{Ll}+)+" minlength="2" maxlength="50" <?php if(isset($_SESSION['user_name'])){echo 'value="'.htmlspecialchars($_SESSION['user_name']).'"';}else{echo '';}?> required>
                    </fieldset>
                    <fieldset>
                        <label for="email">Email:</label>
                        <input class="reservation-input" id="email" type="email" name="email" placeholder="####@email.com" pattern="\w+\.?\w+@\w+\.[a-z][a-z]+" minlength="5" maxlength="50" <?php if(isset($_SESSION['user_email'])){echo 'value="'.htmlspecialchars($_SESSION['user_email']).'" readonly';}else{echo '';}?> required>
                    </fieldset>
                    <fieldset>
                        <label for="phone">Telefon:</label>
                        <input class="reservation-input" id="phone" type="tel" name="phone" placeholder="### ### ###" pattern="(^[+]420\s?)?\d{3}\s?\d{3}\s?\d{3}$" maxlength="16" <?php if(isset($_SESSION['user_phone'])){echo 'value="'.htmlspecialchars($_SESSION['user_phone']).'"';}else{echo '';}?> required>
                    </fieldset>
                    <fieldset>
                        <label for="reservationDay">Den:</label>
                        <input class="reservation-input" id="reservationDay" readonly type="text" name="day" placeholder="##.##.####" <?php if(isset($_GET['date'])){echo 'value="'.htmlspecialchars($_GET['date']).'"';}else{echo '';}?> required>
                    </fieldset>
                    <fieldset>
                        <label for="reservationFrom">Od:</label>
                        <input class="reservation-input" id="reservationFrom" readonly type="text" name="timeFrom" placeholder="##:##" <?php if(isset($_GET['timeFrom'])){echo 'value="'.htmlspecialchars($_GET['timeFrom']).'"';}else{echo '';}?> required>
                    </fieldset>
                    <fieldset>
                        <label for="reservationTo">Do:</label>
                        <input class="reservation-input" id="reservationTo" readonly type="text" name="timeTo" placeholder="##:##" <?php if(isset($_GET['timeTo'])){echo 'value="'.htmlspecialchars($_GET['timeTo']).'"';}else{echo '';}?> required>
                    </fieldset>
                    <fieldset>
                        <label for="tableNumber">Číslo stolu:</label>
                        <input class="reservation-input" id="tableNumber" readonly type="text" name="tableNumber" placeholder="##" <?php if(isset($_GET['chosenTable'])){echo 'value="'.htmlspecialchars($_GET['chosenTable']).'"';}else{echo '';}?> required>
                    </fieldset>
                    <input type="hidden" name="chosenTableId" value="<?php echo htmlspecialchars($_GET['chosenTableId']);?>">
                    <input type="hidden" name="restaurantId" value="<?php echo $restaurantId;?>">
                    <input type="hidden" name="history" value="restaurantid=<?php echo $restaurantId;?>">
                    <button class="loginButton buttonAutoWidth" type="submit" id="makeReservation" name="reservationSubmit">Rezervovat</button>
                </form>
            </div>
        </div>

<?php

    }
    else{

        if((isset($_GET['history']))&&(!empty($_GET['history']))){
            header('Location: searchPage.php?searched='.htmlspecialchars($_GET['history']));
        }
        else{
            header('Location: index.php');
        }
    }

    include 'includes/footer.php';
