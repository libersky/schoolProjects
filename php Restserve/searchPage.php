<?php

    $pageName = "Výsledky hledání";

    include 'includes/database.php';

    include 'includes/header.php';

?>


    <div class="leftSideScreen">
<?php

    //Vyhledavac
    include 'includes/search.php';

    if(isset($_GET['searched'])) {
        $searchedWord = $_GET['searched'];
        //Kontrola zakázaných vstupů
        if((strpos($searchedWord, '>') !== FALSE)||(strpos($searchedWord, '<') !== FALSE)||(strpos($searchedWord, ';') !== FALSE)){
            $string = date("d-m-Y").' '.date("h:i:s").' Uživatel zadal do vyhledávače: '.$searchedWord."\n";
            file_put_contents('repository/errorLog.txt', $string, FILE_APPEND);
            echo '<div>Pro hledaný dotaz nebylo nic nalezeno.</div>';
        }
        else{
            $restaurantsQuery = $db->prepare('SELECT * FROM rest_restaurace WHERE name LIKE :searched OR tags LIKE :searched OR city LIKE :searched OR street LIKE :searched;');
            $restaurantsQuery->execute([
                ':searched' => "%".$searchedWord."%"
            ]);
            $restaurants = $restaurantsQuery->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($restaurants)) {
                echo "<p>Nalezených výsledků: " . sizeof($restaurants) . "</p>";
                foreach ($restaurants as $restaurant) {
                    echo '<a class="foundedRestaurant" href="restaurant.php?restaurantid='.htmlspecialchars($restaurant['r_id']).'&history='.htmlspecialchars($_GET['searched']).'">';
                    echo '<div class="foundedRestaurantImage"';
                    if (!empty($restaurant['picture'])) {
                        echo ' style="background-image: url(\'./graphics/' . htmlspecialchars($restaurant['picture']) . '.jpg\')"';
                    }
                    echo '></div><div class="foundedRestaurantContent">';
                    echo '<h2 class="foundedRestaurantName">' . htmlspecialchars($restaurant['name']) . '</h2>';
                    echo '<h3 class="foundedRestaurantSubtitle">' . htmlspecialchars($restaurant['city']) . '</h3>';
                    echo '<div class="foundedRestaurantTags">';
                    $restaurantTags = explode(",", htmlspecialchars($restaurant['tags']));
                    foreach ($restaurantTags as $restaurantTag) {
                        echo '<div class="foundedRestaurantTag">' . $restaurantTag . '</div>';
                    }
                    echo '</div>';
                    echo '</div></a>';
                }
            }
            else{
                echo '<div>Pro hledaný dotaz nebylo nic nalezeno.</div>';
            }
        }


    }
    else{
        header('Location: index.php');
    }
?>

    </div>
    <div class="rightSideScreen">
        <div class="userReservation">
            <?php
                if(isset($_SESSION['user_id'])){

                    echo '<p>Tvé rezervace:</p>';
                    echo '<div class="listOfReservations">';
                        include 'includes/reservation.php';
                    echo '</div>';

                }
                else{

                    echo '<div class="notRegisteredUserReservation">';
                    echo    '<p>Zaregistruj se pro další výhody.</p>';
                    echo '</div>';

                }
            ?>
        </div>
        <p>Naše návrhy:</p>
        <div class="recommendation">
            <?php
                include "includes/offer.php";
            ?>
        </div>
    </div>

<?php
    include 'includes/footer.php';
