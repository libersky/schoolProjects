<?php

    include 'includes/database.php';

    include 'includes/header.php';

?>

    <div class="frame" id="search">
        <form class="search" method="get" action="searchPage.php">
            <input class="searchInput" type="text" name="searched" placeholder="Zkus vyhledat svojí oblíbenou restauraci..." required>
            <button id="searchButton" class="searchButton" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <div class="offer" id="offer">
        <h1>Restaurace</h1>
        <div class="restaurantOffer">

            <?php
                try{
                    $restaurantsQuery = $db->prepare('SELECT * FROM rest_restaurace WHERE contribution>:price ORDER BY contribution DESC LIMIT 6;');
                    $restaurantsQuery->execute([
                        ':price'=>$priceLimit
                    ]);
                    $restaurants = $restaurantsQuery->fetchAll(PDO::FETCH_ASSOC);
                }
                catch (PDOException $e){
                    error_log($e->getMessage());
                }

                if (!empty($restaurants)) {
                    foreach ($restaurants as $restaurant) {
                        echo    '<a class="restaurantTile" href="restaurant.php?restaurantid='.htmlspecialchars($restaurant['r_id']).'">';
                        echo        '<div class="restaurantImage"';
                        if(!empty($restaurant['picture'])){
                            echo        ' style="background-image: url(\'./graphics/'.htmlspecialchars($restaurant['picture']).'.jpg\')"';
                        }
                        echo        '></div>';
                        echo        '<h2 class="restaurantName">'.htmlspecialchars($restaurant['name']).'</h2>';
                        echo        '<h3 class="restaurantSubtitle">'.htmlspecialchars($restaurant['city']).'</h3>';
                        echo        '<div class="restaurantTags">';
                        $restaurantTags = explode(",", htmlspecialchars($restaurant['tags']));
                        foreach ($restaurantTags as $restaurantTag){
                            echo '<div class="restaurantTag">'.$restaurantTag.'</div>';
                        }
                        echo        '</div>';
                        echo    '</a>';
                    }
                }
            ?>

        </div>
    </div>


<?php

    include 'includes/footer.php';
