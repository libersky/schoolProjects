<?php

    $pageName = "Správa restaurací";

    include 'includes/header.php';

    include 'includes/database.php';

    if($_SESSION['user_admin']==1) {

        ?>

        <div class="adminContainer">
            <div class="addRestaurantContainer">
                <?php
                if (isset($_GET['error'])) {
                    switch (htmlspecialchars($_GET['error'])) {
                        case 'dbcrash':
                            echo '<p class="redLettersMargin10">Neočekávaná chyba databáze</p>';
                            break;
                        case 'contributionincorrectform':
                            echo '<p class="redLettersMargin10">Chybný vstup příspěvku</p>';
                            break;
                        case 'zipincorrectform':
                            echo '<p class="redLettersMargin10">Chybný vstup PSČ</p>';
                            break;
                        case 'noincorrectform':
                            echo '<p class="redLettersMargin10">Chybný vstup ČP</p>';
                            break;
                        case 'streetincorrectform':
                            echo '<p class="redLettersMargin10">Chybný vstup ulice</p>';
                            break;
                        case 'cityincorrectform':
                            echo '<p class="redLettersMargin10">Chybný vstup město</p>';
                            break;
                        case 'nameincorrectform':
                            echo '<p class="redLettersMargin10">Chybný vstup jméno</p>';
                            break;
                        default:
                            echo '<p class="redLettersMargin10">Chyba</p>';
                    }
                }
                if (isset($_GET['success'])) {
                    switch (htmlspecialchars($_GET['success'])) {
                        case 'restaurantadded':
                            echo '<p class="greenLettersMargin10">Restaurace přidána</p>';
                            break;
                        default:
                            echo '<p class="greenLettersMargin10">Operace se zdařila</p>';
                    }
                }
                ?>
                <h2>Vytvořit novou restauraci</h2>
                <form class="restaurantInputForm" action="includes/adminRestaurantAddSystem.php" method="post">
                    <input class="restaurantInput" type="text" name="restaurant_name" placeholder="Název" minlength="2"
                           maxlength="50" required>
                    <input class="restaurantInput" type="text" name="restaurant_city" placeholder="Město"
                           pattern="^\p{L}+\.?((\s|-)\p{L}+\.?)*" minlength="2" maxlength="50" required>
                    <input class="restaurantInput" type="text" name="restaurant_street" placeholder="Ulice"
                           pattern="^\p{L}+\.?((\s|-)\p{L}+\.?)*" maxlength="50">
                    <input class="restaurantInputShort" type="text" name="restaurant_no" placeholder="ČP"
                           pattern="^\d+(\/?\d+)?" minlength="1" maxlength="9" required>
                    <input class="restaurantInputShort" type="text" name="restaurant_zip" placeholder="PSČ"
                           pattern="^\d\d\d\s?\d\d$" minlength="5" maxlength="6" required>
                    <input class="restaurantInputShort" type="number" step="100" min="0" max="1000000" name="restaurant_contribution"
                           placeholder="Příspěvek">
                    <button class="restaurantInputButton" name="submitAdd" type="submit">Vytvořit</button>
                </form>
            </div>
            <div class="addRestaurantContainer">
                <?php

                echo '<h2>Upravit restauraci</h2>';
                if (isset($_POST['submitChange'])) {
                    echo '<form class="restaurantChangeForm" action="includes/adminRestaurantChangeSystem.php" method="post">';
                    echo '<div class="restaurantInfo">
                                <div class="longDiv">
                                    <label for="restaurant_name">Název</label>
                                    <br>
                                    <input class="restaurantInput" id="restaurant_name" type="text" name="restaurant_name" placeholder="Název" minlength="2" maxlength="50" value="' . htmlspecialchars($_POST['restaurant_name']) . '" required>
                                </div>
                                <div class="longDiv">
                                    <label for="restaurant_city">Město</label>
                                    <br>
                                    <input class="restaurantInput" id="restaurant_city" type="text" name="restaurant_city" placeholder="Město" pattern="^\p{L}+\.?((\s|-)\p{L}+\.?)*" minlength="2" maxlength="50" value="' . htmlspecialchars($_POST['restaurant_city']) . '" required>
                                </div>
                                <div class="longDiv">
                                    <label for="restaurant_street">Ulice</label>
                                    <br>
                                    <input class="restaurantInput" id="restaurant_street" type="text" name="restaurant_street" placeholder="Ulice" pattern="^\p{L}+\.?((\s|-)\p{L}+\.?)*" maxlength="50" value="' . htmlspecialchars($_POST['restaurant_street']) . '">
                                </div>  
                                <div class="shortDiv">
                                    <label for="restaurant_no">ČP</label>
                                    <br>
                                    <input class="restaurantInputShort" id="restaurant_no" type="text" name="restaurant_no" placeholder="ČP" pattern="^\d+(\/?\d+)?" minlength="1" maxlength="9"  value="' . htmlspecialchars($_POST['restaurant_no']) . '" required>
                                </div>
                                <div class="shortDiv">
                                    <label for="restaurant_zip">PSČ</label>
                                    <br>
                                    <input class="restaurantInputShort" id="restaurant_zip" type="text" name="restaurant_zip" placeholder="PSČ" pattern="^\d\d\d\s?\d\d$" minlength="5" maxlength="6" value="' . htmlspecialchars($_POST['restaurant_zip']) . '" required>
                                </div>
                                <div class="shortDiv">
                                    <label for="restaurant_contribution">Příspěvek</label>
                                    <br>
                                    <input class="restaurantInputShort" id="restaurant_contribution" type="number" step="100" min="0" max="1000000" name="restaurant_contribution" placeholder="Příspěvek"  value="' . htmlspecialchars($_POST['restaurant_contribution']) . '">
                                </div>
                            </div>
                            <div class="restaurantUsers">
                                <div class="longDiv">
                                    <label for="removeOwn">Odebrat správce</label>
                                    <br>
                                    <select class="restaurantInput" id="removeOwn" name="restaurant_remove_owner">
                                        <option value="">Vyber správce a odebrání</option>';

                    $owners = explode(", ", $_POST['restaurant_owners']);
                    foreach ($owners as $owner) {
                        if ((!empty($owners))&&(strlen(htmlspecialchars($owner))>2)){
                            echo '<option value="' . htmlspecialchars($owner) . '">' . htmlspecialchars($owner) . '</option>';
                        }
                    }

                    echo '</select>
                                </div>
                                <div class="longDiv">
                                    <label for="addOwn">Přidat správce</label>
                                    <br>
                                    <select class="restaurantInput" id="addOwn" name="restaurant_add_owner">
                                        <option value="">Vyber správce a odebrání</option>';

                    try {
                        $stmt = $db->prepare('SELECT DISTINCT rest_user.user_email FROM rest_user LEFT JOIN rest_own ON rest_user.user_id=rest_own.own_user_id WHERE rest_user.user_owner=1;');
                        $stmt->execute();
                        $ownersUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($ownersUsers as $ownersUser) {
                            if (!in_array($ownersUser['user_email'], $owners)) {
                                echo '<option value="' . htmlspecialchars($ownersUser['user_email']) . '">' . htmlspecialchars($ownersUser['user_email']) . '</option>';
                            }
                        }
                    } catch (PDOException $e) {
                        error_log($e->getMessage());
                    }

                    echo '</select>
                                </div>
                            </div>
                            <input type="hidden" value="' . htmlspecialchars($_POST['restaurant_id']) . '" name="restaurant_id" />
                            <button class="cancelButton restaurantChangeButton" name="submitChanges" type="submit">Uložit</button>
                        </form>';

                } else {
                    echo '<div class="emptySlot">Pro úpravu restaurace je nutné vybrat restauraci ze seznamu a kliknout na tlačítko upravit</div>';
                }
                ?>
            </div>
            <div class="restaurantTableContainer">
                <h2>Přehled restaurací</h2>
                <table>
                    <tr>
                        <th>Jméno:</th>
                        <th>Město:</th>
                        <th>Ulice:</th>
                        <th>ČP:</th>
                        <th>PSČ:</th>
                        <th>Příspěvek:</th>
                        <th>Správci:</th>
                        <th colspan="2">Operace:</th>
                    </tr>
                    <?php

                    try {
                        $restaurantsQuery = $db->prepare('SELECT rest_restaurace.r_id, rest_restaurace.name, rest_restaurace.city, rest_restaurace.street, rest_restaurace.no, rest_restaurace.zip, rest_restaurace.contribution, GROUP_CONCAT(rest_user.user_email SEPARATOR \', \') AS owners 
                                                            FROM rest_restaurace
                                                            LEFT JOIN rest_own
                                                            ON rest_restaurace.r_id=rest_own.own_restaurant_id
                                                            LEFT JOIN rest_user
                                                            ON rest_own.own_user_id=rest_user.user_id
                                                            GROUP BY rest_restaurace.r_id;');
                        $restaurantsQuery->execute();
                        $restaurants = $restaurantsQuery->fetchAll(PDO::FETCH_ASSOC);
                    }
                    catch (PDOException $e){
                        error_log($e->getMessage());
                    }

                    try{
                        $usersQuery = $db->prepare('SELECT rest_user.user_id, rest_user.user_name, rest_user.user_email, rest_user.user_owner, rest_user.user_admin 
                                                            FROM rest_user;');
                        $usersQuery->execute();
                        $users = $usersQuery->fetchAll(PDO::FETCH_ASSOC);
                    }
                    catch (PDOException $e){
                        error_log($e->getMessage());
                    }

                    if (!empty($restaurants)) {
                        foreach ($restaurants as $restaurant) {
                            echo '<tr>
                                <td>' . htmlspecialchars($restaurant['name']) . '</td>
                                <td>' . htmlspecialchars($restaurant['city']) . '</td>
                                <td>' . htmlspecialchars($restaurant['street']) . '</td>
                                <td>' . htmlspecialchars($restaurant['no']) . '</td>
                                <td>' . htmlspecialchars($restaurant['zip']) . '</td>
                                <td>' . htmlspecialchars($restaurant['contribution']) . '</td>
                                <td>' . htmlspecialchars($restaurant['owners']) . '</td>
                                <td>
                                    <form method="post" action="admin.php">
                                         <input type="hidden" value="' . htmlspecialchars($restaurant['r_id']) . '" name="restaurant_id" />
                                         <input type="hidden" value="' . htmlspecialchars($restaurant['name']) . '" name="restaurant_name" />
                                         <input type="hidden" value="' . htmlspecialchars($restaurant['city']) . '" name="restaurant_city" />
                                         <input type="hidden" value="' . htmlspecialchars($restaurant['street']) . '" name="restaurant_street" />
                                         <input type="hidden" value="' . htmlspecialchars($restaurant['no']) . '" name="restaurant_no" />
                                         <input type="hidden" value="' . htmlspecialchars($restaurant['zip']) . '" name="restaurant_zip" />
                                         <input type="hidden" value="' . htmlspecialchars($restaurant['contribution']) . '" name="restaurant_contribution" />
                                         <input type="hidden" value="' . htmlspecialchars($restaurant['owners']) . '" name="restaurant_owners" />
                                         <button class="cancelButton cancelButtonLighter" name="submitChange" type="submit">Upravit</button>
                                </form>
                                </td>
                                <td>
                                    <form method="post" action="includes/adminRestaurantRemoveSystem.php">
                                        <input type="hidden" value="' . htmlspecialchars($restaurant['r_id']) . '" name="restaurant_id" />
                                        <button class="cancelButton" name="submitRemove" type="submit">Odstranit</button>
                                    </form>
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td class="emptyTd" colspan="7">Nemáte žádné rezervace.</td></tr>';
                    }

                    ?>
                </table>
            </div>
        </div>

<?php

    }
    else{
        header('Location: index.php');
        die();
    }

    include 'includes/footer.php';
