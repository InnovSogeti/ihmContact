<?php include('common/header.php'); ?>
    </br>
    <div class="container">
        <form action="/addsalon" name="addsalon" method="post">
            <div class="form-group">
                <label for="ville_salon">Ville du salon *</label>
                <input type="text" class="form-control" name="ville_salon" placeholder="ville du salon" required>
            </div>
            <div class="form-group">
                <label for="nom_salon">Nom du salon *</label>
                <input type="text" class="form-control" name="nom_salon" placeholder="nom du salon" required>
            </div>
            <div class="form-group">
                <label for="description_salon">Description du salon:</label>
                <textarea class="form-control" rows="3" name="description_salon"></textarea>
            </div>
            <div class="form-group">
                <label for="debut_salon">Du : *</label>
                <input type="date" class="form-control" name="debut_salon" required>
            </div>
            <div class="form-group">
                <label for="fin_salon">Au : *</label>
                <input type="date" class="form-control" name="fin_salon" required>
            </div>
            <button type="submit" class="btn btn-success btn-lg btn-block">Valider</button>
            </br>
            <label>* : Champs obligatoire</label>
            </br>
            </br>
        </form>
    </div>
<?php include('common/footer.php'); ?>