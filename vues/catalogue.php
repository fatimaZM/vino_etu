<div class="catalogue">
    <header>
        <form id="recherche" method="post">
            <div class="rechercheBouteilleCatalogue" vertical layout>

                <input type="text" class="nom_bouteille_catalogue" name="nom_bouteille_catalogue" placeholder="id,nom, pays " value="">
                <button type="submit" name="recherche" value="Rechercher"><i class="fa fa-search"></i></button>
                <ul class="listeAutoCompleteCatalogue">
                </ul>
            </div>
        </form>

    </header>
    <div class="tri_cellier">
        <form id="tri" method="post">

            <?php
            //Vérifie si un champs de tri "type" a déja été appliqué
            //Si oui le laisse sélectionné au submit ou refresh

            if (isset($_POST["type"])) {
            ?>
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
                    <option <?php if (!(strcmp("prix_saq", $_POST["type"]))) {
                                echo "selected=\"selected\"";
                            } ?>value="prix_saq">Prix</option>
                </select>
            <?php
                //Si aucun champs sélectionné 
            } else {
            ?>

                <select name="type">
                    <option value="" disabled selected>Choisir un tri</option>
                    <option value="nom">Nom</option>
                    <option value="pays">Pays</option>
                    <option value="type">Type de vin</option>
                    <option value="prix_saq">Prix</option>
                </select>
            <?php
            }
            //Vérifie si un champs de tri "ordre" a déja été appliqué
            //Si oui le laisse sélectionné au submit ou refresh
            if (isset($_POST["ordre"])) {
            ?>

                <select name="ordre">

                    <option <?php if (!(strcmp("ASC", $_POST["ordre"]))) {
                                echo "selected=\"selected\"";
                            } ?>value="ASC" selected>Croissant</option>
                    <option <?php if (!(strcmp("DESC", $_POST["ordre"]))) {
                                echo "selected=\"selected\"";
                            } ?>value="DESC">Décroissant</option>
                </select>
            <?php
                //Si aucun champs sélectionné
            } else {
            ?>
                <select name="ordre">

                    <option value="ASC" selected>Croissant</option>
                    <option value="DESC">Décroissant</option>
                </select>
            <?php
            }
            ?>
        <input type="submit" name="tri" value="Triez">
        </form>

        
    </div>
    <h2>Catalogue de la SAQ</h2>
    <!----------------------------->
    <div class="container_bouteille">
        <?php
        if ($data == null) {
            ?><h4>La recherche n'a donnée aucun résultat</h4>
        <?php
        }
        foreach ($data as $cle => $bouteille) {
            ?>

<div class="bouteille" data-quantite="">
    <article class="vignette">
        
        <div class="img">
            <img src="https:<?php echo $bouteille['image'] ?>">
                    </div>

                    <div class="description">

                        <h4 class="nom"><?php echo $bouteille['nom'] ?></h4>


                        <div class="description_colunne1">
                            <p class="pays"><i class='fas fa-flag'></i> <?php echo  $bouteille['pays'] ?></p>
                            <p class="type"><i class='fas fa-wine-bottle'></i> <?php echo $bouteille['type'] ?></p>
                            <p class="prix"><i class='fas fa-dollar-sign'></i> <?php echo $bouteille['prix_saq'] ?>$</p>


                        </div>
                        <div class="description_colunne2">


                            <p class="format"><i class='fas fa-wine-glass-alt'></i> <?php echo $bouteille['format'] ?></p>

                            <p><a href="<?php echo  $bouteille['url_saq'] ?>"><i class="fas fa-external-link-square-alt"></i> Voir SAQ</a></p>
                        </div>
                    </div>

                    <div class="options">
                    </div>
                </article>
            </div>

    </div>


<?php
        }
?>
</div>
</div>