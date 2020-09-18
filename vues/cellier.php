<header> 
<h1>Mon cellier</h1>
<aside>
				<input placeholder="Trouvez une bouteille" type="search">
				<span>🔍</span>
			</aside>
    </header>
<div class="cellier">
   
    <?php
    foreach ($data as $cle => $bouteille) {
    ?>
    <div class="bouteille" data-quantite="">
        <article class="vignette">
            
                <div class="img">
                    <img src="https:<?php echo $bouteille['image'] ?>">
                </div>
            
            <div class="description">
                <h4 class="nom"><?php echo $bouteille['nom'] ?></h4>
                <p class="quantite">Quantité : <span><?php echo $bouteille['quantite'] ?></span></p>
                <p class="pays">Pays : <?php echo $bouteille['pays'] ?></p>
                <p class="type">Type : <?php echo $bouteille['type'] ?></p>
                <p class="notes">Notes : <?php echo $bouteille['notes'] ?></p>
                <p class="millesime">Millesime : <?php echo $bouteille['millesime'] ?></p>
                <p><span>★★☆☆☆</span></p>
                <p><a href="<?php echo $bouteille['url_saq'] ?>">Voir SAQ</a></p>
            </div>

            <div class="options" data-id="<?php echo $bouteille['vino__bouteille_id'] ?>">

                <button class='btnModifier'><a href="?requete=modifierBouteilleCellier&id=<?php echo $bouteille['id'] ?>&cellier=<?php echo $bouteille['vino__cellier_id'] ?>">Modifier</a></button>
                <button class='btnAjouter'>Ajouter</button>
                <button class='btnBoire'>Boire</button>
                <button class='btnSupprimer'><a href="?requete=supprimerBouteille&id=<?php echo $bouteille['id'] ?>&cellier=<?php echo $bouteille['vino__cellier_id'] ?>">Supprimer</a></button>

            </div>
        </article>
    </div>

    <div class="modal">
        <div class="contenu_modal">
            <p class="msg_sql"></p>
            <input type="button" class="confirmer_suppression" value="Confirmer la suppression">

            <input type="button" class="retour_cellier" value="Retour au cellier">
        </div>

    </div>
    <?php
    }
    ?>
</div>
