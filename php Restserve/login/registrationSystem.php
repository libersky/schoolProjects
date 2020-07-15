<?php

    include '../includes/database.php';

    session_start();

    if(!isset($_POST['submitRegistration'])) {

        header('Location: ../registration.php?error=emptyinput');

    }
    else{

        $userName = $_POST['userName'];
        $userEmail = $_POST['userEmail'];
        $userPhone = $_POST['userPhone'];
        if(strpos($userPhone, '+') !== false){
            $pieces = explode("+", htmlspecialchars($userPhone));
            $userPhoneCountry = $pieces[1];
        }
        else{
            $userPhoneCountry = htmlspecialchars($userPhone);
        }
        $userPswd1 = $_POST['userPswd1'];
        $userPswd2 = $_POST['userPswd2'];
        $termsAndConditions = $_POST['termsAndConditions'];

        try {
            $stmt = $db->prepare("SELECT * FROM rest_user WHERE user_email=:userEmail LIMIT 1");
            $stmt->execute([
                ':userEmail' => $userEmail
            ]);
        }
        catch (PDOException $e){
            error_log($e->getMessage());
            header('Location: ../registration.php?error=dberrorEmailCheck');
            die();
        }

        if ($existingUser=$stmt->fetch(PDO::FETCH_ASSOC)){
            header('Location: ../registration.php?error=usedemail&userName='.htmlspecialchars($userName).'&userPhone='.$userPhoneCountry.'&termsAndConditions='.htmlspecialchars($termsAndConditions));
            die();
        }
        else{

            $pattern = '/\w+\.?\w+@\w+\.[a-z][a-z]+/';
            if(!preg_match_all( $pattern, $userEmail)){
                header('Location: ../registration.php?error=incorrectemail&userName='.htmlspecialchars($userName).'&userPhone='.$userPhoneCountry.'&termsAndConditions='.htmlspecialchars($termsAndConditions));
                die();
            }
            else{

                $uppercase = preg_match('@[A-Z]@', $userPswd1);
                $lowercase = preg_match('@[a-z]@', $userPswd1);
                $number    = preg_match('@[0-9]@', $userPswd1);

                if(!$uppercase || !$lowercase || !$number || strlen($userPswd1) < 8) {
                    header('Location: ../registration.php?error=incorrectpswd&userName='.htmlspecialchars($userName).'&userEmail='.htmlspecialchars($userEmail).'&userPhone='.$userPhoneCountry.'&termsAndConditions='.htmlspecialchars($termsAndConditions));
                    die();
                }
                else{

                    if ($userPswd1!=$userPswd2){
                        header('Location: ../registration.php?error=nomatchpswd&userName='.htmlspecialchars($userName).'&userEmail='.htmlspecialchars($userEmail).'&userPhone='.$userPhoneCountry.'&termsAndConditions='.htmlspecialchars($termsAndConditions));
                        die();
                    }
                    else{

                        if($termsAndConditions == false){
                            header('Location: ../registration.php?error=checkbox&userName='.htmlspecialchars($userName).'&userEmail='.htmlspecialchars($userEmail).'&userPhone='.$userPhoneCountry.'&termsAndConditions='.htmlspecialchars($termsAndConditions));
                            die();
                        }
                        else{
                            $adminTemp = '0';
                            $ownerTemp = '0';

                            $passwordHash = password_hash($userPswd1, PASSWORD_DEFAULT);
                            try {
                                $query = $db->prepare('INSERT INTO rest_user (user_name, user_email, user_facebook_id, user_phone, user_password, user_admin, user_owner) VALUES (:userName, :userEmail, :userFacebook, :userPhone, :userPswd, :admin, :owner)');
                                $query->execute([
                                    ':userName' => $userName,
                                    ':userEmail' => $userEmail,
                                    ':userFacebook' => $userEmail,
                                    ':userPhone' => $userPhone,
                                    ':userPswd' => $passwordHash,
                                    ':admin'=>$adminTemp,
                                    ':owner'=>$ownerTemp
                                ]);
                            }
                            catch (PDOException $e){
                                error_log($e->getMessage());
                                header('Location: ../registration.php?error=dberrorCreatingNew');
                                die();
                            }

                            #region login after registration

                            $userName = $userEmail;
                            $userPswd = $userPswd1;

                            try {
                                $stmt = $db->prepare("SELECT * FROM rest_user WHERE user_email=:userName LIMIT 1"); //limit 1 je tu jen jako vykonnostní optimalizace, 2 stejné maily v DB nebudou
                                $stmt->execute([
                                    ':userName' => $userName
                                ]);
                            }
                            catch (PDOException $e){
                                error_log($e->getMessage());
                                header('Location: ../registration.php?error=dberrorGettingByEmail');
                                die();
                            }

                            $existingUser = '';
                            if ($existingUser=$stmt->fetch(PDO::FETCH_ASSOC)){
                                if(password_verify($userPswd, $existingUser['user_password'])){
                                    //povedlo se nám najít daného uživatele v DB a zároveň bylo zadáno platné heslo => uložíme si ID uživatele do SESSION a přesměrujeme ho na homepage
                                    $_SESSION['user_id'] = $existingUser['user_id'];
                                    $_SESSION['user_name'] = $existingUser['user_name'];
                                    $_SESSION['user_email'] = $existingUser['user_email'];
                                    $_SESSION['user_facebook_id'] = $existingUser['user_facebook_id'];
                                    $_SESSION['user_phone'] = $existingUser['user_phone'];
                                    $_SESSION['user_owner'] = $existingUser['user_owner'];
                                    $_SESSION['user_admin'] = $existingUser['user_admin'];

                                    if($existingUser['user_owner']==1){
                                        try {
                                            $restaurantsQuery = $db->prepare('SELECT rest_own.own_restaurant_id, rest_restaurace.name, rest_restaurace.title, rest_restaurace.tags, rest_restaurace.description, rest_restaurace.email, rest_restaurace.picture, rest_restaurace.opening_mo, rest_restaurace.opening_tu, rest_restaurace.opening_we, rest_restaurace.opening_we, rest_restaurace.opening_th, rest_restaurace.opening_fr, rest_restaurace.opening_sa, rest_restaurace.opening_su, rest_restaurace.phone
                                                                FROM rest_own 
                                                                INNER JOIN rest_restaurace
                                                                ON rest_own.own_restaurant_id=rest_restaurace.r_id
                                                                WHERE rest_own.own_user_id=:searched;');
                                            $restaurantsQuery->execute([
                                                ':searched' => $existingUser['user_id']
                                            ]);
                                            $restaurants = $restaurantsQuery->fetchAll(PDO::FETCH_ASSOC);
                                        }
                                        catch (PDOException $e){
                                            error_log($e->getMessage());
                                            header('Location: ../registration.php?error=dberrorLogin');
                                            die();
                                        }

                                        if (!empty($restaurants)) {
                                            $_SESSION['user_restaurants'] = $restaurants;
                                        }
                                    }


                                    header('Location: ../board.php?success');
                                }
                                else{
                                    header('Location: ../login.php?error=wronginput');
                                }
                            }
                            else{
                                //u přihlášení uživatele nezobrazujeme konkrétní chybu (je to jediná výjimka, kdy není vhodné mít u formuláře úplně konkrétní chybu)
                                header('Location: ../login.php?error=wronginput');
                            }

                            #endregion
                        }
                    }
                }
            }
        }
    }
