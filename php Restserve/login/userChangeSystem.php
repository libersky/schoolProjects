<?php

    include '../includes/database.php';

    session_start();

    if(isset($_POST['submitChanges'])){

        $userPswd = $_POST['userPswdOld'];

        try {
            $stmt = $db->prepare('SELECT user_password FROM rest_user WHERE user_id=:searched LIMIT 1;');
            $stmt->execute([
                ':searched' => htmlspecialchars($_SESSION['user_id'])
            ]);
        }
        catch (PDOException $e){
            error_log($e->getMessage());
            header('Location: ../board.php?error=dberror');
            die();
        }

        $existingUser = '';
        if ($existingUser=$stmt->fetch(PDO::FETCH_ASSOC)) {

            if ((password_verify($userPswd, $existingUser['user_password']))||((isset($_SESSION['user_facebook_id']))&&(!empty($_SESSION['user_facebook_id']))&&($_SESSION['user_facebook_id']!==$_SESSION['user_email']))) {

                $returnSuccess = '';
                $returnErrors = '';

                /*Změna jména uživatele */
                #region Name change
                if((isset($_POST['userName']))&&($_POST['userName']!=$_SESSION['user_name'])&&(strlen($_POST['userName'])>=2)){

                    $pattern = '/^\p{Lu}\p{Ll}+(\s\p{Lu}\p{Ll}+)+/u';
                    if(preg_match_all( $pattern, $_POST['userName'])){

                        try{
                            $stmt = $db->prepare('UPDATE rest_user SET user_name=:value WHERE rest_user.user_id=:searched;');
                            $stmt->execute([
                                ':searched' => htmlspecialchars($_SESSION['user_id']),
                                ':value' => htmlspecialchars($_POST['userName'])
                            ]);
                        }
                        catch (PDOException $e){
                            error_log($e->getMessage());
                            header('Location: ../board.php?error=dberror');
                            die();
                        }

                        $_SESSION['user_name'] = $_POST['userName'];

                        if(strlen($returnSuccess)>1){
                            $returnSuccess = $returnSuccess.'-namechaged';
                        }
                        else{
                            $returnSuccess = $returnSuccess.'namechaged';
                        }

                    }
                    else{

                        if(strlen($returnErrors)>1){
                            $returnErrors = $returnErrors.'-incorrectnameform';
                        }
                        else{
                            $returnErrors = $returnErrors.'incorrectnameform';
                        }

                    }

                }
                #endregion

                /*Změna telefoního čísla*/
                #region Phone change
                if((isset($_POST['userPhone']))&&($_POST['userPhone']!=$_SESSION['user_phone'])&&(strlen($_POST['userPhone'])>=9)){

                    $pattern = '/(^[+]420\s?)?\d{3}\s?\d{3}\s?\d{3}$/';
                    if(preg_match_all( $pattern, $_POST['userPhone'])){

                        try{
                            $stmt = $db->prepare('UPDATE rest_user SET user_phone=:value WHERE rest_user.user_id=:searched;');
                            $stmt->execute([
                                ':searched' => htmlspecialchars($_SESSION['user_id']),
                                ':value' => htmlspecialchars($_POST['userPhone'])
                            ]);
                        }
                        catch (PDOException $e){
                            error_log($e->getMessage());
                            header('Location: ../board.php?error=dberror');
                            die();
                        }

                        $_SESSION['user_phone'] = $_POST['userPhone'];

                        if(strlen($returnSuccess)>1){
                            $returnSuccess = $returnSuccess.'-phonechanged';
                        }
                        else{
                            $returnSuccess = $returnSuccess.'phonechanged';
                        }

                    }
                    else{

                        if(strlen($returnErrors)>1){
                            $returnErrors = $returnErrors.'-incorrectphoneform';
                        }
                        else{
                            $returnErrors = $returnErrors.'incorrectphoneform';
                        }

                    }

                }
                #endregion

                /*Změna hesla uživatele*/
                #region Password change
                if((isset($_POST['userPswdNew1']))&&(isset($_POST['userPswdNew2']))&&(strlen($_POST['userPswdNew1'])>=8)&&(strlen($_POST['userPswdNew2'])>=8)&&($_POST['userPswdNew1']!=$userPswd)){

                    $uppercase = preg_match('@[A-Z]@', $_POST['userPswdNew1']);
                    $lowercase = preg_match('@[a-z]@', $_POST['userPswdNew1']);
                    $number    = preg_match('@[0-9]@', $_POST['userPswdNew1']);

                    if($uppercase && $lowercase && $number && strlen($_POST['userPswdNew1']) >= 8) {

                        if($_POST['userPswdNew1']==$_POST['userPswdNew2']){

                            $passwordHash = password_hash($_POST['userPswdNew1'], PASSWORD_DEFAULT);

                            try {
                                $stmt = $db->prepare('UPDATE rest_user SET user_password=:value WHERE rest_user.user_id=:searched;');
                                $stmt->execute([
                                    ':searched' => htmlspecialchars($_SESSION['user_id']),
                                    ':value' => $passwordHash
                                ]);
                            }
                            catch (PDOException $e){
                                error_log($e->getMessage());
                                header('Location: ../board.php?error=dberror');
                                die();
                            }

                            if(strlen($returnSuccess)>1){
                                $returnSuccess = $returnSuccess.'-passwordchanged';
                            }
                            else{
                                $returnSuccess = $returnSuccess.'passwordchanged';
                            }

                        }
                        else{

                            if(strlen($returnErrors)>1){
                                $returnErrors = $returnErrors.'-nomatchpassword';
                            }
                            else{
                                $returnErrors = $returnErrors.'nomatchpassword';
                            }
                        }
                    }
                    else{

                        if(strlen($returnErrors)>1){
                            $returnErrors = $returnErrors.'-incorrectpasswordform';
                        }
                        else{
                            $returnErrors = $returnErrors.'incorrectpasswordform';
                        }
                    }
                }
                #endregion

                if(strlen($returnErrors)<1){
                    $returnErrors = 'none';
                }
                if(strlen($returnSuccess)<1){
                    $returnSuccess = 'none';
                }

                header('Location: ../board.php?success='.$returnSuccess.'&errors='.$returnErrors);

            }
            else{
                header('Location: ../board.php?errors=incorrectpassword'.$_SESSION['user_facebook_id']);
            }
        }
        else{
            header('Location: ../board.php?errors=usernotexist');
        }
    }
    else{
        header('Location: ../board.php?errors=emptyinput');
    }