<?php

    include 'database.php';

    session_start();

    if(isset($_POST['submitChanges'])){

        $userPswd = $_POST['userPswd'];
        $restaurantId = htmlspecialchars($_POST['restaurantId']);

        $actualRestaurantName = '';
        $actualRestaurantTitle = '';
        $actualRestaurantTags = '';
        $actualRestaurantDescription = '';
        $actualRestaurantEmail = '';
        $actualRestaurantPhone = '';
        $actualOpeningMo = '';
        $actualOpeningTu = '';
        $actualOpeningWe = '';
        $actualOpeningTh = '';
        $actualOpeningFr = '';
        $actualOpeningSa = '';
        $actualOpeningSu = '';

        $temps = $_SESSION['user_restaurants'];
        foreach ($temps as $temp){
            if($temp['own_restaurant_id']==$restaurantId){
                $actualRestaurantName = $temp['name'];
                $actualRestaurantTitle = $temp['title'];
                $actualRestaurantTags = $temp['tags'];
                $actualRestaurantDescription = $temp['description'];
                $actualRestaurantEmail = $temp['email'];
                $actualRestaurantPhone = $temp['phone'];
                $actualOpeningMo = $temp['opening_mo'];
                $actualOpeningTu = $temp['opening_tu'];
                $actualOpeningWe = $temp['opening_we'];
                $actualOpeningTh = $temp['opening_th'];
                $actualOpeningFr = $temp['opening_fr'];
                $actualOpeningSa = $temp['opening_sa'];
                $actualOpeningSu = $temp['opening_su'];

                break;
            }
        }
        unset($temp);


        try{
            $stmt = $db->prepare('SELECT user_password FROM rest_user WHERE user_id=:searched LIMIT 1;');
            $stmt->execute([
                ':searched' => htmlspecialchars($_SESSION['user_id'])
            ]);
        }
        catch (PDOException $e){
            error_log($e->getMessage());
            header('Location: ../myRestaurant.php?error=dberror');
            die();
        }


        $existingUser = '';
        if ($existingUser=$stmt->fetch(PDO::FETCH_ASSOC)) {

            if ((password_verify($userPswd, $existingUser['user_password']))||((isset($_SESSION['user_facebook_id']))&&(!empty($_SESSION['user_facebook_id']))&&($_SESSION['user_facebook_id']!==$_SESSION['user_email']))) {

                $returnSuccess = '';
                $returnErrors = '';

                /*Změna jména restaurace */
                #region Name change
                if((isset($_POST['restaurantName']))&&($_POST['restaurantName']!=$actualRestaurantName)&&(strlen($_POST['restaurantName'])>=2)){

                    try{
                        $stmt = $db->prepare('UPDATE rest_restaurace SET name=:value WHERE rest_restaurace.r_id=:searched;');
                        $stmt->execute([
                            ':value' => htmlspecialchars($_POST['restaurantName']),
                            ':searched' => $restaurantId
                        ]);
                    }
                    catch (PDOException $e){
                        error_log($e->getMessage());
                        header('Location: ../myRestaurant.php?error=dberror');
                        die();
                    }

                    $temps = $_SESSION['user_restaurants'];
                    foreach($temps as &$temp){
                        if($temp['own_restaurant_id']==$restaurantId){
                            $temp['name'] = $_POST['restaurantName'];
                            break;
                        }
                    }
                    unset($temp);
                    unset($_SESSION['user_restaurants']);
                    $_SESSION['user_restaurants'] = $temps;

                    if(strlen($returnSuccess)>1){
                        $returnSuccess = $returnSuccess.'-namechaged';
                    }
                    else{
                        $returnSuccess = $returnSuccess.'namechaged';
                    }
                }
                #endregion

                /*Změna titulku restaurace */
                #region Title change
                if((isset($_POST['restaurantTitle']))&&($_POST['restaurantTitle']!=$actualRestaurantTitle)&&(strlen($_POST['restaurantTitle'])>=2)){

                    try {
                        $stmt = $db->prepare('UPDATE rest_restaurace SET title=:value WHERE rest_restaurace.r_id=:searched;');
                        $stmt->execute([
                            ':value' => htmlspecialchars($_POST['restaurantTitle']),
                            ':searched' => $restaurantId
                        ]);
                    }
                    catch (PDOException $e){
                        error_log($e->getMessage());
                        header('Location: ../myRestaurant.php?error=dberror');
                        die();
                    }

                    $temps = $_SESSION['user_restaurants'];
                    foreach($temps as &$temp){
                        if($temp['own_restaurant_id']==$restaurantId){
                            $temp['title']=$_POST['restaurantTitle'];
                            break;
                        }
                    }
                    unset($temp);
                    unset($_SESSION['user_restaurants']);
                    $_SESSION['user_restaurants'] = $temps;

                    if(strlen($returnSuccess)>1){
                        $returnSuccess = $returnSuccess.'-titlechaged';
                    }
                    else{
                        $returnSuccess = $returnSuccess.'titlechaged';
                    }
                }
                #endregion

                /*Změna popisku restaurace */
                #region Description change
                if((isset($_POST['restaurantDescription']))&&($_POST['restaurantDescription']!=$actualRestaurantDescription)&&(strlen($_POST['restaurantDescription'])>=2)){

                    try {
                        $stmt = $db->prepare('UPDATE rest_restaurace SET description=:value WHERE rest_restaurace.r_id=:searched;');
                        $stmt->execute([
                            ':value' => htmlspecialchars($_POST['restaurantDescription']),
                            ':searched' => $restaurantId
                        ]);
                    }
                    catch (PDOException $e){
                        error_log($e->getMessage());
                        header('Location: ../myRestaurant.php?error=dberror');
                        die();
                    }

                    $temps = $_SESSION['user_restaurants'];
                    foreach($temps as &$temp){
                        if($temp['own_restaurant_id']==$restaurantId){
                            $temp['description']=$_POST['restaurantDescription'];
                            break;
                        }
                    }
                    unset($temp);
                    unset($_SESSION['user_restaurants']);
                    $_SESSION['user_restaurants'] = $temps;

                    if(strlen($returnSuccess)>1){
                        $returnSuccess = $returnSuccess.'-descriptionchaged';
                    }
                    else{
                        $returnSuccess = $returnSuccess.'descriptionchaged';
                    }
                }
                #endregion

                /*Změna tagů restaurace */
                #region Tags change
                if((isset($_POST['restaurantTags']))&&($_POST['restaurantTags']!=$actualRestaurantTags)&&(strlen($_POST['restaurantTags'])>=2)){

                    try {
                        $stmt = $db->prepare('UPDATE rest_restaurace SET tags=:value WHERE rest_restaurace.r_id=:searched;');
                        $stmt->execute([
                            ':value' => htmlspecialchars($_POST['restaurantTags']),
                            ':searched' => $restaurantId
                        ]);
                    }
                    catch (PDOException $e){
                        error_log($e->getMessage());
                        header('Location: ../myRestaurant.php?error=dberror');
                        die();
                    }

                    $temps = $_SESSION['user_restaurants'];
                    foreach($temps as &$temp){
                        if($temp['own_restaurant_id']==$restaurantId){
                            $temp['tags']=$_POST['restaurantTags'];
                            break;
                        }
                    }
                    unset($temp);
                    unset($_SESSION['user_restaurants']);
                    $_SESSION['user_restaurants'] = $temps;

                    if(strlen($returnSuccess)>1){
                        $returnSuccess = $returnSuccess.'-tagschaged';
                    }
                    else{
                        $returnSuccess = $returnSuccess.'tagschaged';
                    }
                }
                #endregion

                /*Změna tagů restaurace */
                #region Tags change
                if((isset($_POST['restaurantTags']))&&($_POST['restaurantTags']!=$actualRestaurantTags)&&(strlen($_POST['restaurantTags'])>=2)){

                    try {
                        $stmt = $db->prepare('UPDATE rest_restaurace SET tags=:value WHERE rest_restaurace.r_id=:searched;');
                        $stmt->execute([
                            ':value' => htmlspecialchars($_POST['restaurantTags']),
                            ':searched' => $restaurantId
                        ]);
                    }
                    catch (PDOException $e){
                        error_log($e->getMessage());
                        header('Location: ../myRestaurant.php?error=dberror');
                        die();
                    }

                    $temps = $_SESSION['user_restaurants'];
                    foreach($temps as &$temp){
                        if($temp['own_restaurant_id']==$restaurantId){
                            $temp['tags']=$_POST['restaurantTags'];
                            break;
                        }
                    }
                    unset($temp);
                    unset($_SESSION['user_restaurants']);
                    $_SESSION['user_restaurants'] = $temps;

                    if(strlen($returnSuccess)>1){
                        $returnSuccess = $returnSuccess.'-tagschaged';
                    }
                    else{
                        $returnSuccess = $returnSuccess.'tagschaged';
                    }
                }
                #endregion

                /*Změna emailu restaurace*/
                #region Email change
                if((isset($_POST['restaurantEmail']))&&($_POST['restaurantEmail']!=$actualRestaurantEmail)&&(strlen($_POST['restaurantEmail'])>=5)){

                    $pattern = '/\w+\.?\w+@\w+\.[a-z][a-z]+/';
                    if(preg_match_all( $pattern, $_POST['restaurantEmail'])){

                        try {
                            $stmt = $db->prepare('UPDATE rest_restaurace SET email=:value WHERE rest_restaurace.r_id=:searched;');
                            $stmt->execute([
                                ':value' => htmlspecialchars($_POST['restaurantEmail']),
                                ':searched' => $restaurantId
                            ]);
                        }
                        catch (PDOException $e){
                            error_log($e->getMessage());
                            header('Location: ../myRestaurant.php?error=dberror');
                            die();
                        }

                        $temps = $_SESSION['user_restaurants'];
                        foreach($temps as &$temp){
                            if($temp['own_restaurant_id']==$restaurantId){
                                $temp['email']=$_POST['restaurantEmail'];
                                break;
                            }
                        }
                        unset($temp);
                        unset($_SESSION['user_restaurants']);
                        $_SESSION['user_restaurants'] = $temps;

                        if(strlen($returnSuccess)>1){
                            $returnSuccess = $returnSuccess.'-emailchanged';
                        }
                        else{
                            $returnSuccess = $returnSuccess.'emailchanged';
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

                /*Změna telefoního čísla restaurace*/
                #region Phone change
                if((isset($_POST['restaurantPhone']))&&($_POST['restaurantPhone']!=$actualRestaurantPhone)&&(strlen($_POST['restaurantPhone'])>=9)){

                    $pattern = '/(^[+]420\s?)?\d{3}\s?\d{3}\s?\d{3}$/';
                    if(preg_match_all( $pattern, $_POST['restaurantPhone'])){

                        try{
                            $stmt = $db->prepare('UPDATE rest_restaurace SET phone=:value WHERE rest_restaurace.r_id=:searched;');
                            $stmt->execute([
                                ':value' => htmlspecialchars($_POST['restaurantPhone']),
                                ':searched' => $restaurantId
                            ]);
                        }
                        catch (PDOException $e){
                            error_log($e->getMessage());
                            header('Location: ../myRestaurant.php?error=dberror');
                            die();
                        }

                        $temps = $_SESSION['user_restaurants'];
                        foreach($temps as &$temp){
                            if($temp['own_restaurant_id']==$restaurantId){
                                $temp['phone']=$_POST['restaurantPhone'];
                                break;
                            }
                        }
                        unset($temp);
                        unset($_SESSION['user_restaurants']);
                        $_SESSION['user_restaurants'] = $temps;

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

                /*Změna otevíracíh hodin v pondělí*/
                #region Opening mo change
                if((isset($_POST['restaurantOpeningMo']))&&($_POST['restaurantOpeningMo']!=$actualOpeningMo)&&(strlen($_POST['restaurantOpeningMo'])>=7)){

                    $pattern = '/(^[0-2]?[0-9]:[0-2]?[0-9]\s?-\s?[0-2]?[0-9]:[0-2]?[0-9])|(Zavřeno)|(zavřeno)/';
                    if(preg_match_all( $pattern, $_POST['restaurantOpeningMo'])){

                        $stmt = $db->prepare('UPDATE rest_restaurace SET opening_mo=:value WHERE rest_restaurace.r_id=:searched;');
                        $stmt->execute([
                            ':value' => htmlspecialchars($_POST['restaurantOpeningMo']),
                            ':searched' => $restaurantId
                        ]);

                        $temps = $_SESSION['user_restaurants'];
                        foreach($temps as &$temp){
                            if($temp['own_restaurant_id']==$restaurantId){
                                $temp['opening_mo']=$_POST['restaurantOpeningMo'];
                                break;
                            }
                        }
                        unset($temp);
                        unset($_SESSION['user_restaurants']);
                        $_SESSION['user_restaurants'] = $temps;

                        if(strlen($returnSuccess)>1){
                            $returnSuccess = $returnSuccess.'-openingmochanged';
                        }
                        else{
                            $returnSuccess = $returnSuccess.'openingmochanged';
                        }

                    }
                    else{

                        if(strlen($returnErrors)>1){
                            $returnErrors = $returnErrors.'-incorrectopeningmoform';
                        }
                        else{
                            $returnErrors = $returnErrors.'incorrectopeningmoform';
                        }

                    }

                }
                #endregion

                /*Změna otevíracíh hodin v úterý*/
                #region Opening tu change
                if((isset($_POST['restaurantOpeningTu']))&&($_POST['restaurantOpeningTu']!=$actualOpeningTu)&&(strlen($_POST['restaurantOpeningTu'])>=7)){

                    $pattern = '/(^[0-2]?[0-9]:[0-2]?[0-9]\s?-\s?[0-2]?[0-9]:[0-2]?[0-9])|(Zavřeno)|(zavřeno)/';
                    if(preg_match_all( $pattern, $_POST['restaurantOpeningTu'])){

                        $stmt = $db->prepare('UPDATE rest_restaurace SET opening_tu=:value WHERE rest_restaurace.r_id=:searched;');
                        $stmt->execute([
                            ':value' => htmlspecialchars($_POST['restaurantOpeningTu']),
                            ':searched' => $restaurantId
                        ]);

                        $temps = $_SESSION['user_restaurants'];
                        foreach($temps as &$temp){
                            if($temp['own_restaurant_id']==$restaurantId){
                                $temp['opening_tu']=$_POST['restaurantOpeningTu'];
                                break;
                            }
                        }
                        unset($temp);
                        unset($_SESSION['user_restaurants']);
                        $_SESSION['user_restaurants'] = $temps;

                        if(strlen($returnSuccess)>1){
                            $returnSuccess = $returnSuccess.'-openingtuchanged';
                        }
                        else{
                            $returnSuccess = $returnSuccess.'openingtuchanged';
                        }

                    }
                    else{

                        if(strlen($returnErrors)>1){
                            $returnErrors = $returnErrors.'-incorrectopeningtuform';
                        }
                        else{
                            $returnErrors = $returnErrors.'incorrectopeningtuform';
                        }

                    }

                }
                #endregion

                /*Změna otevíracíh hodin ve středu*/
                #region Opening we change
                if((isset($_POST['restaurantOpeningWe']))&&($_POST['restaurantOpeningWe']!=$actualOpeningWe)&&(strlen($_POST['restaurantOpeningWe'])>=7)){

                    $pattern = '/(^[0-2]?[0-9]:[0-2]?[0-9]\s?-\s?[0-2]?[0-9]:[0-2]?[0-9])|(Zavřeno)|(zavřeno)/';
                    if(preg_match_all( $pattern, $_POST['restaurantOpeningWe'])){

                        $stmt = $db->prepare('UPDATE rest_restaurace SET opening_we=:value WHERE rest_restaurace.r_id=:searched;');
                        $stmt->execute([
                            ':value' => htmlspecialchars($_POST['restaurantOpeningWe']),
                            ':searched' => $restaurantId
                        ]);

                        $temps = $_SESSION['user_restaurants'];
                        foreach($temps as &$temp){
                            if($temp['own_restaurant_id']==$restaurantId){
                                $temp['opening_we']=$_POST['restaurantOpeningWe'];
                                break;
                            }
                        }
                        unset($temp);
                        unset($_SESSION['user_restaurants']);
                        $_SESSION['user_restaurants'] = $temps;

                        if(strlen($returnSuccess)>1){
                            $returnSuccess = $returnSuccess.'-openingwechanged';
                        }
                        else{
                            $returnSuccess = $returnSuccess.'openingwechanged';
                        }

                    }
                    else{

                        if(strlen($returnErrors)>1){
                            $returnErrors = $returnErrors.'-incorrectopeningweform';
                        }
                        else{
                            $returnErrors = $returnErrors.'incorrectopeningweform';
                        }

                    }

                }
                #endregion

                /*Změna otevíracíh hodin ve čtvrtek*/
                #region Opening th change
                if((isset($_POST['restaurantOpeningTh']))&&($_POST['restaurantOpeningTh']!=$actualOpeningTh)&&(strlen($_POST['restaurantOpeningTh'])>=7)){

                    $pattern = '/(^[0-2]?[0-9]:[0-2]?[0-9]\s?-\s?[0-2]?[0-9]:[0-2]?[0-9])|(Zavřeno)|(zavřeno)/';
                    if(preg_match_all( $pattern, $_POST['restaurantOpeningTh'])){

                        $stmt = $db->prepare('UPDATE rest_restaurace SET opening_th=:value WHERE rest_restaurace.r_id=:searched;');
                        $stmt->execute([
                            ':value' => htmlspecialchars($_POST['restaurantOpeningTh']),
                            ':searched' => $restaurantId
                        ]);

                        $temps = $_SESSION['user_restaurants'];
                        foreach($temps as &$temp){
                            if($temp['own_restaurant_id']==$restaurantId){
                                $temp['opening_th']=$_POST['restaurantOpeningTh'];
                                break;
                            }
                        }
                        unset($temp);
                        unset($_SESSION['user_restaurants']);
                        $_SESSION['user_restaurants'] = $temps;

                        if(strlen($returnSuccess)>1){
                            $returnSuccess = $returnSuccess.'-openingthchanged';
                        }
                        else{
                            $returnSuccess = $returnSuccess.'openingthchanged';
                        }

                    }
                    else{

                        if(strlen($returnErrors)>1){
                            $returnErrors = $returnErrors.'-incorrectopeningthform';
                        }
                        else{
                            $returnErrors = $returnErrors.'incorrectopeningthform';
                        }

                    }

                }
                #endregion

                /*Změna otevíracíh hodin v pátek*/
                #region Opening fr change
                if((isset($_POST['restaurantOpeningFr']))&&($_POST['restaurantOpeningFr']!=$actualOpeningFr)&&(strlen($_POST['restaurantOpeningFr'])>=7)){

                    $pattern = '/(^[0-2]?[0-9]:[0-2]?[0-9]\s?-\s?[0-2]?[0-9]:[0-2]?[0-9])|(Zavřeno)|(zavřeno)/';
                    if(preg_match_all( $pattern, $_POST['restaurantOpeningFr'])){

                        $stmt = $db->prepare('UPDATE rest_restaurace SET opening_fr=:value WHERE rest_restaurace.r_id=:searched;');
                        $stmt->execute([
                            ':value' => htmlspecialchars($_POST['restaurantOpeningFr']),
                            ':searched' => $restaurantId
                        ]);

                        $temps = $_SESSION['user_restaurants'];
                        foreach($temps as &$temp){
                            if($temp['own_restaurant_id']==$restaurantId){
                                $temp['opening_fr']=$_POST['restaurantOpeningFr'];
                                break;
                            }
                        }
                        unset($temp);
                        unset($_SESSION['user_restaurants']);
                        $_SESSION['user_restaurants'] = $temps;

                        if(strlen($returnSuccess)>1){
                            $returnSuccess = $returnSuccess.'-openingfrchanged';
                        }
                        else{
                            $returnSuccess = $returnSuccess.'openingfrchanged';
                        }

                    }
                    else{

                        if(strlen($returnErrors)>1){
                            $returnErrors = $returnErrors.'-incorrectopeningfrform';
                        }
                        else{
                            $returnErrors = $returnErrors.'incorrectopeningfrform';
                        }

                    }

                }
                #endregion

                /*Změna otevíracíh hodin v sobotu*/
                #region Opening sa change
                if((isset($_POST['restaurantOpeningSa']))&&($_POST['restaurantOpeningSa']!=$actualOpeningSa)&&(strlen($_POST['restaurantOpeningSa'])>=7)){

                    $pattern = '/(^[0-2]?[0-9]:[0-2]?[0-9]\s?-\s?[0-2]?[0-9]:[0-2]?[0-9])|(Zavřeno)|(zavřeno)/';
                    if(preg_match_all( $pattern, $_POST['restaurantOpeningSa'])){

                        try {
                            $stmt = $db->prepare('UPDATE rest_restaurace SET opening_sa=:value WHERE rest_restaurace.r_id=:searched;');
                            $stmt->execute([
                                ':value' => htmlspecialchars($_POST['restaurantOpeningSa']),
                                ':searched' => $restaurantId
                            ]);
                        }
                        catch (PDOException $e){
                            error_log($e->getMessage());
                            header('Location: ../myRestaurant.php?error=dberror');
                            die();
                        }

                        $temps = $_SESSION['user_restaurants'];
                        foreach($temps as &$temp){
                            if($temp['own_restaurant_id']==$restaurantId){
                                $temp['opening_sa']=$_POST['restaurantOpeningSa'];
                                break;
                            }
                        }
                        unset($temp);
                        unset($_SESSION['user_restaurants']);
                        $_SESSION['user_restaurants'] = $temps;

                        if(strlen($returnSuccess)>1){
                            $returnSuccess = $returnSuccess.'-openingsachanged';
                        }
                        else{
                            $returnSuccess = $returnSuccess.'openingsachanged';
                        }

                    }
                    else{

                        if(strlen($returnErrors)>1){
                            $returnErrors = $returnErrors.'-incorrectopeningsaform';
                        }
                        else{
                            $returnErrors = $returnErrors.'incorrectopeningsaform';
                        }

                    }

                }
                #endregion

                /*Změna otevíracíh hodin v neděli*/
                #region Opening su change
                if((isset($_POST['restaurantOpeningSu']))&&($_POST['restaurantOpeningSu']!=$actualOpeningSu)&&(strlen($_POST['restaurantOpeningSu'])>=7)){

                    $pattern = '/(^[0-2]?[0-9]:[0-2]?[0-9]\s?-\s?[0-2]?[0-9]:[0-2]?[0-9])|(Zavřeno)|(zavřeno)/';
                    if(preg_match_all( $pattern, $_POST['restaurantOpeningSu'])){

                        try {
                            $stmt = $db->prepare('UPDATE rest_restaurace SET opening_su=:value WHERE rest_restaurace.r_id=:searched;');
                            $stmt->execute([
                                ':value' => htmlspecialchars($_POST['restaurantOpeningSu']),
                                ':searched' => $restaurantId
                            ]);
                        }
                        catch (PDOException $e){
                            error_log($e->getMessage());
                            header('Location: ../myRestaurant.php?error=dberror');
                            die();
                        }

                        $temps = $_SESSION['user_restaurants'];
                        foreach($temps as &$temp){
                            if($temp['own_restaurant_id']==$restaurantId){
                                $temp['opening_su']=$_POST['restaurantOpeningSu'];
                                break;
                            }
                        }
                        unset($temp);
                        unset($_SESSION['user_restaurants']);
                        $_SESSION['user_restaurants'] = $temps;

                        if(strlen($returnSuccess)>1){
                            $returnSuccess = $returnSuccess.'-openingsuchanged';
                        }
                        else{
                            $returnSuccess = $returnSuccess.'openingsuchanged';
                        }

                    }
                    else{

                        if(strlen($returnErrors)>1){
                            $returnErrors = $returnErrors.'-incorrectopeningsuform';
                        }
                        else{
                            $returnErrors = $returnErrors.'incorrectopeningsuform';
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

                header('Location: ../myRestaurant.php?success='.$returnSuccess.'&errors='.$returnErrors);

            }
            else{
                header('Location: ../myRestaurant.php?errors=incorrectpassword');
            }
        }
        else{
            header('Location: ../myRestaurant.php?errors=usernotexist');
        }
    }
    else{
        header('Location: ../myRestaurant.php?errors=emptyinput');
    }