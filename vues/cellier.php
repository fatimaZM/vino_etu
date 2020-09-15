<div class="cellier">
    <form id="tri" action="" method="post">
        <h3><strong>Critères de tri :</strong></h3>
        <?php
        if (isset($_POST["type"])) {
        ?>
            <label>Type</label>
            <select name="type">

                <option <?php if (!(strcmp("nom", $_POST["type"]))) {
                            echo "selected=\"selected\"";
                        } ?>value="nom">Nom</option>
                <option <?php if (!(strcmp("pays", $_POST["type"]))) {
                            echo "selected=\"selected\"";
                        } ?>value="pays">Pays</option>
                <option <?php if (!(strcmp("type", $_POST["type"]))) {
                            echo "selected=\"selected\"";
                        } ?>value="type">Type de vin</option>
                <option <?php if (!(strcmp("quantite", $_POST["type"]))) {
                            echo "selected=\"selected\"";
                        } ?>value="quantite">Quantité</option>
                <option <?php if (!(strcmp("date_achat", $_POST["type"]))) {
                            echo "selected=\"selected\"";
                        } ?>value="date_achat">Date d'achat</option>
            </select>
        <?php
        } else {
        ?>
            <label>Type</label>
            <select name="type">
                <option value="" disabled selected>Choisir un tri</option>
                <option value="nom">Nom</option>
                <option value="pays">Pays</option>
                <option value="type">Type de vin</option>
                <option value="quantite">Quantité</option>
                <option value="date_achat">Date d'achat</option>
            </select>
        <?php
        }
        ?>
        <?php
        if (isset($_POST["ordre"])) {
        ?>
            <label>Ordre</label>
            <select name="ordre">

                <option <?php if (!(strcmp("ASC", $_POST["ordre"]))) {
                            echo "selected=\"selected\"";
                        } ?>value="ASC" selected>Croissant</option>
                <option <?php if (!(strcmp("DESC", $_POST["ordre"]))) {
                            echo "selected=\"selected\"";
                        } ?>value="DESC">Décroissant</option>
            </select>
        <?php
        } else {
        ?>
            <label>Ordre</label>
            <select name="ordre">

                <option value="ASC" selected>Croissant</option>
                <option value="DESC">Décroissant</option>
            </select>
        <?php
        }
        ?>
        <input type="submit" name="tri" value="Triez">
    </form>
    <?php
    foreach ($data as $cle => $bouteille) {
    ?>
        <div class="bouteille" data-quantite="">
            <div class="img">
                <img src="https:<?php echo $bouteille['image'] ?>">
            </div>
            <div class="description">
                <p class="nom">Nom : <?php echo $bouteille['nom'] ?></p>
                <p class="quantite">Quantité : <span><?php echo $bouteille['quantite'] ?></span></p>
                <p class="pays">Pays : <?php echo $bouteille['pays'] ?></p>
                <p class="type">Type : <?php echo $bouteille['type'] ?></p>
                <p class="notes">Notes : <?php echo $bouteille['notes'] ?></p>
                <p class="millesime">Millesime : <?php echo $bouteille['millesime'] ?></p>
                <p class="date_achat">Date d'achat : <?php echo $bouteille['date_achat'] ?></p>
                <p><a href="<?php echo $bouteille['url_saq'] ?>">Voir SAQ</a></p>
            </div>

            <div class="options" data-id="<?php echo $bouteille['vino__bouteille_id'] ?>">

                <button class='btnModifier'><a href="?requete=modifierBouteilleCellier&id=<?php echo $bouteille['id'] ?>&cellier=<?php echo $bouteille['vino__cellier_id'] ?>">Modifier</a></button>
                <button class='btnAjouter'>Ajouter</button>
                <button class='btnBoire'>Boire</button>

            </div>
        </div>
    <?php
    }
    ?>
</div>