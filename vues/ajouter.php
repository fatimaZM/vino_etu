<div class="ajouter">

    <div class="nouvelleBouteille" vertical layout>
        <form id="recherche_catalogue">
        <input type="text" name="nom_bouteille" placeholder="Rechercher une bouteille dans le catalogue ">
            </form>
        <ul class="listeAutoComplete">
        </ul>
        
        <div id="ajouter_une_bouteille">
            <p><label>Nom   </label><span name = "nom" data-id_cellier="<?= $_SESSION['info_utilisateur']['id']?>" class="nom_bouteille"></span></p>
            <p><label>Millesime   </label><input type="text" name="millesime"></p>
            <span class='erreur millesime'></span>
            <p><label>Quantite   </label><input input type="text" name="quantite" value="1"></p>
            <span class='erreur quantite'></span>
            <p><label>Date achat   </label><input type="date" name="date_achat"></p>
            <span class='erreur date_achat'></span>
            <p><label>Prix   </label><input input type=number name="prix"></p>
            <span class='erreur prix'></span>
            <p><label>Garde   </label><input input type="text" name="garde_jusqua"></p>
            <span class='erreur garde_jusqua'></span>
            <p><label>Notes </label><input input type="text" name="notes"></p>
            <span class='erreur notes'></span>
       
        <button name="ajouterBouteilleCellier">Ajouter la bouteille</button>
             </div>
    </div>

    <div class="modal">
        <div class="contenu_modal">
            <p class="msg_sql"></p>
            <input type="button" class="retour_cellier" value="Retour au cellier">
        </div>

    </div>
</div>
</div>