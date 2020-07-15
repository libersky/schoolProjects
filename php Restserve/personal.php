<?php

    $pageName = "Správa uživatelů";

    include 'includes/header.php';
    include 'includes/database.php';

    if($_SESSION['user_admin']==1){

?>

    <div class="manageUsersContainer">

        <h2>Uživatelé</h2>
        <p>Uživatele je možné odebírat a měnit jim práva.</p>
        <?php

        try{
            $usersQuery = $db->prepare('SELECT user_id, user_name, user_email, user_phone, user_owner, user_admin
                                                FROM rest_user ORDER BY user_name ASC, user_email ASC;');
            $usersQuery->execute();
            $users = $usersQuery->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e){
            error_log($e->getMessage());
        }

        echo '<table class="tablesTable">';
        echo    '<tr>';
        echo        '<th>Jméno:</th>';
        echo        '<th>Email:</th>';
        echo        '<th>Telefon:</th>';
        echo        '<th>Admin:</th>';
        echo        '<th>Správce:</th>';
        echo        '<th>Operace:</th>';
        echo    '</tr>';

        if(!empty($users)){
            foreach ($users as $user){
                echo '<tr>';
                echo    '<td>'.htmlspecialchars($user['user_name']).'</td>';
                echo    '<td>'.htmlspecialchars($user['user_email']).'</td>';
                echo    '<td>'.htmlspecialchars($user['user_phone']).'</td>';
                if($user['user_admin']==1){
                    echo    '<td>Admin</td>';
                }
                else{
                    echo    '<td></td>';
                }

                if($user['user_owner']==1) {

                    echo    '<td>Správce</td>';
                    echo '<td>
                            <form method="post" action="includes/ownerSystem.php">
                                <input type="hidden" value="'.htmlspecialchars($user['user_id']).'" name="user_id" />
                                <input type="hidden" value="0" name="own" />
                                <button class="cancelButton" name="submitOwn" type="submit">Odebrat správu</button>
                            </form>
                          </td>';


                }
                else{
                    echo    '<td></td>';
                    echo '<td>
                            <form method="post" action="includes/ownerSystem.php">
                                <input type="hidden" value="'.htmlspecialchars($user['user_id']).'" name="user_id" />
                                <input type="hidden" value="1" name="own" />
                                <button class="cancelButton" name="submitOwn" type="submit">Přidat správu</button>
                            </form>
                          </td>';
                }
                echo '</tr>';
            }
        }
        else{
            echo '<tr>';
            echo    '<td class="emptyTd" colspan="7">Žádní uživatelé nebyli nalezeni.</td>';
            echo '</tr>';
        }
        echo '</table>';
        ?>


    </div>

<?php
    }
    else{
        header('Location: index.php');
        die();
    }
    include 'includes/footer.php';
