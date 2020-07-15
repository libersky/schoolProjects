<form class="searchPageSearchForm" method="get" action="searchPage.php">
    <input class="searchPageSearchInput" type="text" name="searched" placeholder="Zkus vyhledat svojí oblíbenou restauraci..." value="<?php if(isset($_GET['searched'])) {echo htmlspecialchars($_GET['searched']);} ?>" required>
    <button id="searchButton" class="searchPageSearchButton" type="submit"><i class="fas fa-search"></i></button>
</form>