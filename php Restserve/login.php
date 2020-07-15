<?php

    $pageName = "Login";

    include 'includes/database.php';

    include 'includes/header.php';

    require_once __DIR__.'/vendor/autoload.php';//načtení class loaderu vytvořeného composerem

    require_once 'includes/facebook.php';


    if(!isset($_SESSION['user_id'])){

?>
    <div class="loginContainer">
        <div class="loginInformation">
            <?php
                if(isset($_GET['error'])){
                    $inputWord = $_GET['error'];
                    if((strpos($inputWord, '>') !== FALSE)||(strpos($inputWord, '<') !== FALSE)||(strpos($inputWord, ';') !== FALSE)){
                        $string = date("d-m-Y").' '.date("h:i:s").' Uživatel zadal do url adresi v loginu: '.$inputWord."\n";
                        file_put_contents('repository/errorLog.txt', $string, FILE_APPEND);
                    }else{
                        if(htmlspecialchars($_GET['error'])==='wronginput'){
                            echo '<img src="./graphics/warning.jpg" alt="Varovná ikona s oranžovým vykřičníkem" width="250" height="200">';
                            echo '<p>Uživatelské jméno nebo heslo bylo zadáno chybně</p>';
                        }
                    }
                }
            ?>
        </div>
        <div class="loginWindow">
            <div class="loginImage">
                <img src="./graphics/avatar.jpg" alt="Defaultní avatar" height="180" width="120">
            </div>
            <div class="loginForm">
                <form action="login/loginSystem.php" method="post">
                    <input class="loginInput" type="text" name="userName" placeholder="E-mail" required>
                    <br>
                    <input class="loginInput" type="password" name="userPswd" placeholder="Heslo" required>
                    <br>
                    <p>Pokud ještě nemáte založený účet můžete tak učinit v sekci <a href="registration.php">registrace</a></p>
                    <button class="loginButton" type="submit" name="submitLogin">Přihlásit</button>
                </form>
            </div>
        </div>
        <div class="loginOthers">
            <p>Další možnosti přihlášení:</p>
            <div class="loginOptions">
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
                echo ' <a href="'.$fbLoginUrl.'" class="loginOtherOption">
                            <img src="graphics/fb.jpg" width="150" height="150">
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
