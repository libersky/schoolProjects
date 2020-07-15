<?php

    $pageName = "Registrace";

    include 'includes/database.php';

    include 'includes/header.php';

    require_once __DIR__.'/vendor/autoload.php';//načtení class loaderu vytvořeného composerem

    require_once 'includes/facebook.php';

    if(!isset($_SESSION['user_id'])){

?>

    <div class="registrationContainer">
        <div class="registrationInformation">
            <?php
                echo '<h2>Požadavky a doporučení</h2>';
                if(isset($_GET['error'])){
                    echo '<p>Jako jméno uveďte vaše skutečné jméno. Bude automaticky doplňováno do&nbsp;vašich rezervací, tak&nbsp;aby obsluha restaurace věděla pro koho rezervaci stolu zřizuje. Vámi vybraný stůl tak bude označen vašim jménem. Pokud děláte rezervaci pro někoho jiného, je&nbsp;možné jméno před odesláním žádosti změnit, avšak telefoní číslo a&nbsp;email zůstane neměný, kvůli ověření identity.</p>';
                    if(($_GET['error']=='usedemail')||($_GET['error']=='incorrectemail')){
                        echo '<p class="redLetters">Náš systém neumožňuje ragistrovat jeden email k&nbsp;více účtům. Na&nbsp;email, který nám poskytnete budeme výhradně zasílat potvrzení vaší rezervace.</p>';
                    }
                    else{
                        echo '<p>Náš systém neumožňuje ragistrovat jeden email k&nbsp;více účtům. Na&nbsp;email, který nám poskytnete budeme výhradně zasílat potvrzení vaší rezervace.</p>';
                    }
                    if($_GET['error']=='incorrectform'){
                        echo '<p class="redLetters">Registrujte telefonní číslo, které má využít personál restaurace proto aby vás kontaktoval v&nbsp;případě změn. Telefoní číslo uvádějte bez předčíslí.</p>';
                    }
                    else{
                        echo '<p>Registrujte telefonní číslo, které má využít personál restaurace proto aby vás kontaktoval v&nbsp;případě změn. Telefoní číslo uvádějte bez předčíslí.</p>';
                    }
                    if(($_GET['error']=='incorrectpswd')||($_GET['error']=='nomatchpswd')){
                        echo '<p class="redLetters">Heslo musí obsahovat nejméně 8 znaků, číslici a&nbsp;velké písmeno. Doporučujeme využívat pro každou službu jiné heslo a&nbsp;volit hesla větším počtu znaků. Experti doporučují využít kombinaci více slov doplněných o&nbsp;číslice.</p>';
                    }
                    else{
                        echo '<p>Heslo musí obsahovat nejméně 8 znaků, číslici a&nbsp;velké písmeno. Doporučujeme využívat pro každou službu jiné heslo a&nbsp;volit hesla větším počtu znaků. Experti doporučují využít kombinaci více slov doplněných o&nbsp;číslice.</p>';
                    }
                    if($_GET['error']=='checkbox'){
                        echo '<p class="redLetters">Pro registraci je nutné potvrdit, že&nbsp;jste přečetli a&nbsp;souhlasíte s&nbsp;podmínkami využívání naší webové služby a&nbsp;zároveň udělujete souhlas ke&nbsp;zpracování osobních údajů za&nbsp;účelem vámi požadovaných služeb.</p>';
                    }
                    else{
                        echo '<p>Pro registraci je nutné potvrdit, že&nbsp;jste přečetli a&nbsp;souhlasíte s&nbsp;podmínkami využívání naší webové služby a&nbsp;zároveň udělujete souhlas ke&nbsp;zpracování osobních údajů za&nbsp;účelem vámi požadovaných služeb.</p>';
                    }
                }
                else{
                    echo   '<p>Jako jméno uveďte vaše skutečné jméno. Bude automaticky doplňováno do&nbsp;vašich rezervací, tak&nbsp;aby obsluha restaurace věděla pro koho rezervaci stolu zřizuje. Vámi vybraný stůl tak bude označen vašim jménem. Pokud děláte rezervaci pro někoho jiného, je&nbsp;možné jméno před odesláním žádosti změnit, avšak telefoní číslo a&nbsp;email zůstane neměný, kvůli ověření identity.</p>
                            <p>Náš systém neumožňuje ragistrovat jeden email k&nbsp;více účtům. Na&nbsp;email, který nám poskytnete budeme výhradně zasílat potvrzení vaší rezervace.</p>
                            <p>Registrujte telefonní číslo, které má využít personál restaurace proto aby vás kontaktoval v&nbsp;případě změn. Telefoní číslo uvádějte bez předčíslí.</p>
                            <p>Heslo musí obsahovat nejméně 8 znaků, číslici a&nbsp;velké písmeno. Doporučujeme využívat pro každou službu jiné heslo a&nbsp;volit hesla větším počtu znaků. Experti doporučují využít kombinaci více slov doplněných o&nbsp;číslice.</p>
                            <p>Pro registraci je nutné potvrdit, že&nbsp;jste přečetli a&nbsp;souhlasíte s&nbsp;podmínkami využívání naší webové služby a&nbsp;zároveň udělujete souhlas ke&nbsp;zpracování osobních údajů za&nbsp;účelem vámi požadovaných služeb.</p>';
                }
            ?>
        </div>
        <div class="registrationWindow">
            <div class="registrationForm">
                <form action="login/registrationSystem.php" method="post">
                    <?php

                        if((isset($_GET['error']))&&($_GET['error']==='usedname')){
                            echo '<p>Uživatelské jméno je obsazeno</p>';
                        }
                        echo '<input class="loginInput" type="text" name="userName" placeholder="Vaše jméno" pattern="^\p{Lu}\p{Ll}+(\s\p{Lu}\p{Ll}+)+" maxlength="50" minlength="2" ';
                        if(isset($_GET['userName'])){
                            echo 'value="'.htmlspecialchars($_GET['userName']).'" ';
                        }
                        echo 'required>';
                        echo '<br>';

                        if((isset($_GET['error']))&&($_GET['error']==='usedemail')){
                            echo '<p>Email je již v systému registrován</p>';
                        }
                        else{
                            if((isset($_GET['error']))&&($_GET['error']==='incorrectemail')){
                                echo '<p>Email neodpovídá požadavkům</p>';
                            }
                        }
                        echo '<input class="loginInput" type="email" name="userEmail" placeholder="E-mail" pattern="\w+\.?\w+@\w+\.[a-z][a-z]+" maxlength="30" minlength="5" ';
                        if(isset($_GET['userEmail'])){
                            echo 'value="'.htmlspecialchars($_GET['userEmail']).'" ';
                        }
                        echo 'required>';
                        echo '<br>';

                        if((isset($_GET['error']))&&($_GET['error']==='incorrectform')){
                            echo '<p>Nesplňuje požadovaný formát</p>';
                        }
                        echo '<input class="loginInput" type="tel" name="userPhone" placeholder="Telefon" pattern="(^[+]420\s?)?\d{3}\s?\d{3}\s?\d{3}$" maxlength="16" minlength="9" ';
                        if(isset($_GET['userPhone'])){
                            $userPhone = htmlspecialchars($_GET['userPhone']);
                            if(strpos($userPhone, '420') !== false){
                                echo 'value="+'.$userPhone.'" ';
                            }
                            else{
                                echo 'value="'.$userPhone.'" ';
                            }
                        }
                        echo 'required>';
                        echo '<br>';

                        if((isset($_GET['error']))&&($_GET['error']==='incorrectpswd')){
                            echo '<p>Heslo nesplňuje požadavky</p>';
                        }
                        if((isset($_GET['error']))&&($_GET['error']==='nomatchpswd')){
                            echo '<p>Hesla se neshodují</p>';
                        }
                        echo '<input class="loginInput" type="password" name="userPswd1" placeholder="Heslo" minlength="8" maxlength="50" required>';
                        echo '<br>';

                        echo '<input class="loginInput" type="password" name="userPswd2" placeholder="Znovu heslo" minlength="8" maxlength="50" required>';
                        echo '<br>';

                        echo '<div class="checkBox">';
                        echo    '<input type="checkbox" id="termsAndConditions" name="termsAndConditions" value="true" ';
                        if(isset($_GET['termsAndConditions'])){
                            echo 'checked ';
                        }
                        echo    'required>';
                        echo    '<label for="termsAndConditions"> Přečetl jsem si a&nbsp;souhlasím s&nbsp;<a href="./documents/RestserveConditions.pdf" target="_blank">podmínkami</a> registrace a&nbsp;užívání služby Restserve a&nbsp;uděluji souhlas zpracovávat mé osobní údaje.</label><br>';
                        echo '</div>';

                        echo '<button class="loginButton" name="submitRegistration" type="submit">Registrovat</button>';
                    ?>
                </form>
            </div>
        </div>
        <div class="registrationOthers">
            <h2>Majitelé restaurací</h2>
            <p>Pokud jste majitelem restaurace a&nbsp;chete svou reestauraci zaregistrovat do&nbsp;naší služby, obraťte se nejdříve na&nbsp;nás prostřednictvím telefoního čísla +420&nbsp;789&nbsp;456&nbsp;123 nebo emailu info@restserve.cz. Vaší restauraci do&nbsp;systému k&nbsp;vašemu uživatelskému ůčtu připojí náš administrativní pracovník po&nbsp;uzavření smlouvy.</p>
            <h2>Další možnosti přihlášení</h2>
            <div class="registrationOptions">
                <?php
                    #region přihlašování pomocí Facebooku
                    //inicializujeme helper pro vytvoření odkazu
                    $fbHelper = $fb->getRedirectLoginHelper();

                    //nastavení parametrů pro vyžádání oprávnění a odkaz na přesměrování po přihlášení
                    $permissions = ['email'];
                    $callbackUrl = htmlspecialchars('https://eso.vse.cz/~liba03/restserve/fb-callback.php');


                    //necháme helper sestavit adresu pro odeslání požadavku na přihlášení
                    $fbLoginUrl = $fbHelper->getLoginUrl($callbackUrl, $permissions);

                    //vykreslíme odkaz na přihlášení
                    echo ' <a href="'.$fbLoginUrl.'" class="registrationOtherOption">
                                <img src="graphics/fb.jpg" alt="Ikona Facebooku" width="80" height="80">
                            </a>';
                    #endregion přihlašování pomocí Facebooku
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
