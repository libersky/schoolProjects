<?php

    try {
        $restaurantsQuery = $db->prepare('SELECT * FROM rest_restaurace WHERE contribution>:price ORDER BY contribution DESC LIMIT 2;');
        $restaurantsQuery->execute([
            ':price' => $priceLimit
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
            echo        '<p class="restaurantDescription">'.htmlspecialchars($restaurant['description']).'</p>';
            echo        '<div class="restaurantTags">';
            $restaurantTags = explode(",", htmlspecialchars($restaurant['tags']));
            foreach ($restaurantTags as $restaurantTag){
                echo '<div class="restaurantTag">'.$restaurantTag.'</div>';
            }
            echo        '</div>';
            echo    '</a>';
        }
    }