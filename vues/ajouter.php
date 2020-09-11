<div class="ajouter">

    <div class="nouvelleBouteille" vertical layout>
        Recherche : <input type="text" name="nom_bouteille">
        <ul class="listeAutoComplete">
        </ul>
        <div>
            <p>Nom : <span data-id="" class="nom_bouteille"></span></p>
            <p>Millesime : <input name="millesime"></p>
            <span class='erreur millesime'></span>
            <p>Quantite : <input name="quantite" value="1"></p>
            <span class='erreur quantite'></span>
            <p>Date achat : <input type="date" name="date_achat"></p>
            <span class='erreur date_achat'></span>
            <p>Prix : <input name="prix"></p>
            <span class='erreur prix'></span>
            <p>Garde : <input name="garde_jusqua"></p>
            <span class='erreur garde_jusqua'></span>
            <p>Notes <input name="notes"></p>
            <span class='erreur notes'></span>
        </div>
        <button name="ajouterBouteilleCellier">Ajouter la bouteille</button>
    </div>

    <div class="modal">
        <div class="contenu_modal">
            <p class="msg_sql"></p>
            <input type="button" class="retour_cellier" value="Retour au cellier">
        </div>

    </div>
</div>
</div>