<?php

    include 'includes/database.php';

    require_once __DIR__.'/vendor/autoload.php';

    session_start();

    require_once 'includes/facebook.php';

    $fbHelper = $fb->getRedirectLoginHelper();

    try {
        $accessToken = $fbHelper->getAccessToken();
    } catch(Exception $e) {
        echo 'Přihlášení pomocí Facebooku selhalo. Chyba: ' . $e->getMessage();
        exit();
    }

    if (!$accessToken){
        //Nebyl vrácen access token - např. uživatel odmítl oprávnění pro aplikaci atp.
        //Chyby bychom ale rozhodně mohli vypisovat v hezčí formě :)
        exit('Přihlášení pomocí Facebooku se nezdařilo. Zkuste to znovu.');
    }

    //OAuth 2.0 client pro správu access tokenů
    $oAuth2Client = $fb->getOAuth2Client();

    //získáme údaje k tokenu, který jsme získali z přihlášení
    $accessTokenMetadata = $oAuth2Client->debugToken($accessToken);

    //získáme ID uživatele z Facebooku
    $fbUserId = $accessTokenMetadata->getUserId();

    //získáme jméno a e-mail uživatele
    $response=$fb->get('/me?fields=name,email', $accessToken);
    $graphUser=$response->getGraphUser();

    $fbUserEmail=$graphUser->getEmail();
    $fbUserName=$graphUser->getName();

    //nejprve se pokusíme daného uživatele načíst podle FB User ID
    $query=$db->prepare('SELECT * FROM rest_user WHERE user_facebook_id=:facebookId LIMIT 1;');
    $query->execute([
        ':facebookId'=>$fbUserId
    ]);

    if ($query->rowCount()>0){
        //uživatele jsme našli v DB podle jeho Facebook User ID
        $user = $query->fetch(PDO::FETCH_ASSOC);
    }
    else{
        //uživatel nebyl nalezen v DB - pokusíme se jej najít pomocí e-mailu
        $query = $db->prepare('SELECT * FROM rest_user WHERE user_email=:email LIMIT 1;');
        $query->execute([
            ':email'=>$fbUserEmail
        ]);

        if ($query->rowCount()>0){
            //uživatele jsme našli podle e-mailu, připíšeme k němu do DB jeho Facebook User ID
            $user = $query->fetch(PDO::FETCH_ASSOC);

            $updateQuery = $db->prepare('UPDATE rest_user SET user_facebook_id=:facebookId WHERE user_id=:id LIMIT 1;');
            $updateQuery->execute([
                ':id'=>$user['user_id'],
                ':facebookId'=>$fbUserId
            ]);

        }else{
            $phoneTemp = '000 000 000';
            $adminTemp = '0';
            $ownerTemp = '0';

            //uživatele jsme vůbec nenašli, zapíšeme ho do DB jako nového
            $insertQuery = $db->prepare('INSERT INTO rest_user (user_name, user_email, user_facebook_id, user_phone, user_admin, user_owner) VALUES (:name, :email, :facebookId, :phone, :admin, :owner);');
            $insertQuery->execute([
                ':name'=>$fbUserName,
                ':email'=>$fbUserEmail,
                ':facebookId'=>$fbUserId,
                ':phone'=>$phoneTemp,
                ':admin'=>$adminTemp,
                ':owner'=>$ownerTemp
            ]);

            //uživatele následně zpětně načteme z DB pro získání jeho user_id
            $query=$db->prepare('SELECT * FROM rest_user WHERE user_facebook_id=:facebookId LIMIT 1;');
            $query->execute([
                ':facebookId'=>$fbUserId
            ]);
            $user=$query->fetch(PDO::FETCH_ASSOC);

        }
    }



    if (!empty($user)){
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['user_email'] = $user['user_email'];
        $_SESSION['user_facebook_id'] = $user['user_facebook_id'];
        $_SESSION['user_phone'] = $user['user_phone'];
        $_SESSION['user_owner'] = $user['user_owner'];
        $_SESSION['user_admin'] = $user['user_admin'];

        if($user['user_owner']==1){
            try {
                $restaurantsQuery = $db->prepare('SELECT rest_own.own_restaurant_id, rest_restaurace.name, rest_restaurace.title, rest_restaurace.tags, rest_restaurace.description, rest_restaurace.email, rest_restaurace.picture, rest_restaurace.opening_mo, rest_restaurace.opening_tu, rest_restaurace.opening_we, rest_restaurace.opening_we, rest_restaurace.opening_th, rest_restaurace.opening_fr, rest_restaurace.opening_sa, rest_restaurace.opening_su, rest_restaurace.phone
                                                            FROM rest_own 
                                                            INNER JOIN rest_restaurace
                                                            ON rest_own.own_restaurant_id=rest_restaurace.r_id
                                                            WHERE rest_own.own_user_id=:searched;');
                $restaurantsQuery->execute([
                    ':searched' => $user['user_id']
                ]);
                $restaurants = $restaurantsQuery->fetchAll(PDO::FETCH_ASSOC);
            }
            catch (PDOException $e){
                error_log($e->getMessage());
                header('Location: ../login.php?error=dberror');
                die();
            }

            if (!empty($restaurants)) {
                $_SESSION['user_restaurants'] = $restaurants;
            }
        }

        header('Location: board.php?success');
        die();
    }

    header('Location: index.php');