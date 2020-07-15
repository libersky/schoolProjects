<?php

    include 'database.php';

    session_start();

    if(isset($_POST['submitChanges'])) {

        $restaurantId = htmlspecialchars($_POST['restaurant_id']);
        $restaurantName = htmlspecialchars($_POST['restaurant_name']);
        $restaurantCity = htmlspecialchars($_POST['restaurant_city']);
        $restaurantStreet = htmlspecialchars($_POST['restaurant_street']);
        $restaurantNo = htmlspecialchars($_POST['restaurant_no']);
        $restaurantZip = htmlspecialchars($_POST['restaurant_zip']);

        if(!empty($_POST['restaurant_contribution'])){
            $restaurantContribution = htmlspecialchars($_POST['restaurant_contribution']);
        }
        else{
            $restaurantContribution = 0;
        }

        $restaurantRemoveOwner = htmlspecialchars($_POST['restaurant_remove_owner']);
        $restaurantAddOwner = htmlspecialchars($_POST['restaurant_add_owner']);

        if((strlen($restaurantName)<=50)&&(strlen($restaurantName)>=2)){

            $patternCity = '/^\p{L}+\.?((\s|-)\p{L}+\.?)*/';
            if((strlen($restaurantCity)<=50)&&(strlen($restaurantCity)>=2)&&(preg_match_all($patternCity, $restaurantCity))){

                $patternStreet = '/^\p{L}+\.?((\s|-)\p{L}+\.?)*/';
                if((strlen($restaurantStreet)<=50)&&(strlen($restaurantStreet)>=2)&&(preg_match_all($patternStreet, $restaurantStreet))){

                    $patternNo = '/^\d+(\/?\d+)?/';
                    if((strlen($restaurantNo)<=9)&&(strlen($restaurantNo)>=1)&&(preg_match_all($patternNo, $restaurantNo))){

                        $patternZip = '/^\d\d\d\s?\d\d$/';
                        if((strlen($restaurantZip)<=6)&&(strlen($restaurantZip)>=5)&&(preg_match_all($patternZip, $restaurantZip))){

                            $patternContribution = '/^\d+/';
                            if((strlen($restaurantContribution)<=50)&&(preg_match_all($patternContribution, $restaurantContribution))){

                                try{
                                    $stmt = $db->prepare('UPDATE rest_restaurace 
                                                                    SET name=:restaurantName, city=:restaurantCity, street=:restaurantStreet, no=:restaurantNo, zip=:restaurantZip, contribution=:restaurantContribution 
                                                                    WHERE rest_restaurace.r_id=:restaurantId;');
                                    $stmt->execute([
                                        ':restaurantName' => $restaurantName,
                                        ':restaurantCity' => $restaurantCity,
                                        ':restaurantStreet' => $restaurantStreet,
                                        ':restaurantNo' => $restaurantNo,
                                        ':restaurantZip' => $restaurantZip,
                                        ':restaurantContribution' => $restaurantContribution,
                                        ':restaurantId' => $restaurantId
                                    ]);

                                    $stringAditional ='';

                                    if(!empty($restaurantRemoveOwner)){

                                        $stmt = $db->prepare('SELECT user_id FROM rest_user WHERE user_email=:ownerEmail;');
                                        $stmt->execute([
                                            ':ownerEmail' => $restaurantRemoveOwner
                                        ]);
                                        $deleteOwnerId = $stmt->fetch(PDO::FETCH_ASSOC);

                                        $stmt = $db->prepare('DELETE FROM rest_own WHERE rest_own.own_restaurant_id =:restId AND rest_own.own_user_id=:userId;');
                                        $stmt->execute([
                                            ':restId' => $restaurantId,
                                            ':userId' => $deleteOwnerId['user_id']
                                        ]);

                                        $stringAditional = "ownerremoved";
                                    }

                                    if(!empty($restaurantAddOwner)){

                                        $stmt = $db->prepare('SELECT user_id FROM rest_user WHERE user_email=:ownerEmail;');
                                        $stmt->execute([
                                            ':ownerEmail' => $restaurantAddOwner
                                        ]);
                                        $addOwnerId = $stmt->fetch(PDO::FETCH_ASSOC);

                                        $stmt = $db->prepare('INSERT INTO rest_own (own_restaurant_id, own_user_id) VALUES (:restId, :userId);');
                                        $stmt->execute([
                                            ':restId' => $restaurantId,
                                            ':userId' => $addOwnerId['user_id']
                                        ]);

                                        $stringAditional = "owneradded";

                                    }

                                    header('Location: ../admin.php?success=restaurantadded'.$stringAditional);
                                    die();

                                }
                                catch (PDOException $e){
                                    error_log($e->getMessage());
                                }

                                header('Location: ../admin.php?error=dbcrash');
                            }
                            else{
                                header('Location: ../admin.php?error=contributionincorrectform');
                            }
                        }
                        else{
                            header('Location: ../admin.php?error=zipincorrectform');
                        }
                    }
                    else{
                        header('Location: ../admin.php?error=noincorrectform');
                    }
                }
                else{
                    header('Location: ../admin.php?error=streetincorrectform');
                }
            }
            else{
                header('Location: ../admin.php?error=cityincorrectform');
            }
        }
        else{
            header('Location: ../admin.php?error=nameincorrectform');
        }



      /*  $restaurantId = htmlspecialchars($_POST['restaurant_id']);
        $restaurantName = htmlspecialchars($_POST['restaurant_name']);
        $restaurantCity = htmlspecialchars($_POST['restaurant_city']);
        $restaurantStreet = htmlspecialchars($_POST['restaurant_street']);
        $restaurantNo = htmlspecialchars($_POST['restaurant_no']);
        $restaurantZip = htmlspecialchars($_POST['restaurant_zip']);
        $restaurantContribution = htmlspecialchars($_POST['restaurant_contribution']);
        $restaurantRemoveOwner = htmlspecialchars($_POST['restaurant_remove_owner']);
        $restaurantAddOwner = htmlspecialchars($_POST['restaurant_add_owner']);

        $actualRestaurant = '';

        try {
            $restaurantQuery = $db->prepare('SELECT * FROM rest_restaurace WHERE r_id=:searched LIMIT 1;');
            $restaurantQuery->execute([
                ':searched' => $restaurantId
            ]);
            $actualRestaurant = $restaurantQuery->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            header('Location: ../admin.php?error=dbrestcrash');
            die();
        }

        if (!empty($actualRestaurant)) {
            $actualRestaurantId = htmlspecialchars($actualRestaurant['r_id']);
            $actualRestaurantName = htmlspecialchars($actualRestaurant['name']);
            $actualRestaurantCity = htmlspecialchars($actualRestaurant['city']);
            $actualRestaurantStreet = htmlspecialchars($actualRestaurant['street']);
            $actualRestaurantNo = htmlspecialchars($actualRestaurant['no']);
            $actualRestaurantZip = htmlspecialchars($actualRestaurant['ip']);
            $actualRestaurantContribution = htmlspecialchars($actualRestaurant['contribution']);*/




    }
    else{
        header('Location: ../admin.php?errors=emptyinput');
    }