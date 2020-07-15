<?php

    $pageName = "Nástěnka";

    include 'includes/database.php';

    include 'includes/header.php';

    if(isset($_SESSION['user_id'])) {

        ?>
        <div class="userBoard">
            <div class="userFirstBar">
                <div class="userBoardSearch">
                    <?php
                    //Vyhledavac
                    include 'includes/search.php';
                    ?>
                </div>
                <div class="userBoardReservation">
                    <p>Tvé rezervace:</p>
                    <div class="listOfReservations">
                        <?php
                        include 'includes/reservation.php';
                        ?>
                    </div>
                </div>
            </div>
            <div class="userSecondBar">
                <div class="userBoardPersonal">
                    <h2>Tvé údaje:</h2>
                    <p>Pokud chcete změnit některý z&nbsp;vašich údajů, upravte pouze políčka týkající se požadované
                        změny. Vaše úpravy se do&nbsp;systému uloží po zadání vašeho současného hesla a&nbsp;kliknutím
                        na&nbsp;tlačítko "Provést změny." V&nbsp;případě změny hesla je nutné dbát na&nbsp;pravidla pro
                        tvorbu hesel, to&nbsp;znamená, že&nbsp;heslo musí být delší než 8 znaků, obsahovat velké písmeno
                        a&nbsp;číslici.</p>
                    <?php
                    if ((isset($_GET['errors'])) && (preg_match('/incorrectpasswordform/', $_GET['errors']))) {
                        echo '<p class="redLettersMargin10">Nové heslo nesplňuje požadavky</p>';
                    }
                    if ((isset($_GET['errors'])) && (preg_match('/nomatchpassword/', $_GET['errors']))) {
                        echo '<p class="redLettersMargin10">Zadaná nová hesla se neshodují</p>';
                    }
                    if ((isset($_GET['errors'])) && (preg_match('/incorrectnameform/', $_GET['errors']))) {
                        echo '<p class="redLettersMargin10">Jméno nesplňuje požadovaný formát</p>';
                    }
                    if ((isset($_GET['errors'])) && (preg_match('/incorrectphoneform/', $_GET['errors']))) {
                        echo '<p class="redLettersMargin10">Telefoní číslo nesplňuje požadovaný formát</p>';
                    }
                    if ((isset($_GET['errors'])) && ($_GET['errors'] === 'none')) {
                        echo '<p class="greenLettersMargin10">Všechny změny byly provedeny úspěšně</p>';
                    }
                    ?>
                    <form method="post" action="login/userChangeSystem.php">
                        <div class="upperSettings">
                            <div class="personalInformation">
                                <h3>Osobní údaje</h3>
                                <?php
                                echo '<label for="loginInputName">Jméno a příjmení</label>';
                                echo '<input class="loginInput" id="loginInputName" type="text" name="userName" placeholder="Vaše jméno" pattern="^\p{Lu}\p{Ll}+(\s\p{Lu}\p{Ll}+)+" maxlength="50" minlength="2" ';
                                if (isset($_SESSION['user_name'])) {
                                    echo 'value="' . htmlspecialchars($_SESSION['user_name']) . '" ';
                                }
                                echo '>';
                                echo '<br>';

                                echo '<label for="loginInputPhone">Telefoní číslo</label>';
                                echo '<input class="loginInput" id="loginInputPhone" type="tel" name="userPhone" placeholder="Telefon" pattern="(^[+]420\s?)?\d{3}\s?\d{3}\s?\d{3}$" maxlength="16" minlength="9" ';
                                if (isset($_SESSION['user_phone'])) {
                                    echo 'value="' . htmlspecialchars($_SESSION['user_phone']) . '" ';
                                }
                                echo '>';
                                echo '<br>';
                                ?>
                            </div>
                            <div class="passwordSettings">
                                <h3>Nastavení nového hesla</h3>
                                <?php
                                echo '<label for="loginInputNewPswd1">Nové heslo</label>';
                                echo '<input class="loginInput" id="loginInputNewPswd1" type="password" name="userPswdNew1" placeholder="Nové heslo" minlength="8" maxlength="50">';
                                echo '<br>';

                                echo '<label for="loginInputNewPswd2">Nové heslo ještě jednou</label>';
                                echo '<input class="loginInput" id="loginInputNewPswd2" type="password" name="userPswdNew2" placeholder="Znovu nové heslo" minlength="8" maxlength="50">';
                                echo '<br>';
                                ?>
                            </div>
                        </div>
                        <div class="confirmChanges">
                            <h3>Potvrzení změn</h3>
                            <?php
                            echo    '<input type="password" name="userPswdOld" placeholder="Současné heslo" maxlength="50" ';
                            if ((isset($_SESSION['user_facebook_id']))&&(!empty($_SESSION['user_facebook_id']))&&($_SESSION['user_facebook_id']!==$_SESSION['user_email'])){
                                echo 'readonly class="loginInput grayBackground" ';
                            }
                            else{
                                echo 'class="loginInput" ';
                            }
                            echo '>';
                            echo '<button class="loginButton" name="submitChanges" type="submit">Potvrdit změny</button>';
                            ?>
                        </div>
                    </form>
                </div>
                <div class="userBoardOffers">
                    <?php
                    if (count($reservations) > 10) {
                        echo '<p>Naše návrhy:</p>';
                        echo '<div class="recommendation">';
                        include "includes/offer.php";
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

<?php

    }
    else{
        header('Location: index.php');
        die();
    }

    include 'includes/footer.php';
