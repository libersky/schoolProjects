<?php

    include 'database.php';

    if(isset($_POST['submitAdd'])){

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
                                    $stmt = $db->prepare('INSERT INTO rest_restaurace (name, city, street, no, zip, contribution) 
                                            VALUES (:restaurantName, :restaurantCity, :restaurantStreet, :restaurantNo, :restaurantZip, :restaurantContribution);');
                                    $stmt->execute([
                                        ':restaurantName' => $restaurantName,
                                        ':restaurantCity' => $restaurantCity,
                                        ':restaurantStreet' => $restaurantStreet,
                                        ':restaurantNo' => $restaurantNo,
                                        ':restaurantZip' => $restaurantZip,
                                        ':restaurantContribution' => $restaurantContribution
                                    ]);

                                    header('Location: ../admin.php?success=restaurantadded');
                                    die();

                                }
                                catch (PDOException $e){
                                    error_log($e->getMessage());
                                }

                                header('Location: ../admin.php?error=dbcrash');
                            }
                            else{
                                header('Location: ../myRestaurant.php?error=contributionincorrectform');
                            }
                        }
                        else{
                            header('Location: ../myRestaurant.php?error=zipincorrectform');
                        }
                    }
                    else{
                        header('Location: ../myRestaurant.php?error=noincorrectform');
                    }
                }
                else{
                    header('Location: ../myRestaurant.php?error=streetincorrectform');
                }
            }
            else{
                header('Location: ../myRestaurant.php?error=cityincorrectform');
            }
        }
        else{
            header('Location: ../myRestaurant.php?error=nameincorrectform');
        }
    }
    else{
        header('Location: ../myRestaurant.php?error=restaurantaddfail');
    }
