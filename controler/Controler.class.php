<?php

/**
 * Class Controler
 * Gère les requêtes HTTP
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */

class Controler
{

	/**
	 * Traite la requête
	 * @return void
	 */
	public function gerer()
	{
		switch ($_GET['requete']) {
			case 'autocompleteBouteille':
				$this->autocompleteBouteille();
				break;
			case 'ajouterNouvelleBouteilleCellier':
				$this->ajouterNouvelleBouteilleCellier();
				break;
			case 'ajouterBouteilleCellier':
				$this->ajouterBouteilleCellier();
				break;
			case 'boireBouteilleCellier':
				$this->boireBouteilleCellier();
				break;
			default:
				$this->accueil();
				break;
		}
	}

	/**
	 * Affiche la page d'accueil sur la liste des bouteilles du cellier
	 * @return files
	 */
	private function accueil()
	{
		$bte = new Bouteille();
		$data = $bte->getListeBouteilleCellier();
		include("vues/entete.php");
		include("vues/cellier.php");
		include("vues/pied.php");
	}

	/**
	 * Récupère les résultats de la recherche d'auto-complétion.
	 * @return json
	 */
	private function autocompleteBouteille()
	{
		$bte = new Bouteille();
		// var_dump(file_get_contents('php://input'));
		$body = json_decode(file_get_contents('php://input'));
		// var_dump($body);
		$listeBouteille = $bte->autocomplete($body->nom);

		echo json_encode($listeBouteille);
	}

	/**
	 * Récupère les informations sur la bouteille à ajouter et déclenche la requete sql d'ajout.
	 * Si php://input est vide, affiche le formulaire d'ajout de bouteille
	 * @return mixted
	 */
	private function ajouterNouvelleBouteilleCellier()
	{
		$body = json_decode(file_get_contents('php://input'));


		if (!empty($body)) {
			var_dump($body);
			$bte = new Bouteille();
			$resultat = $bte->ajouterBouteilleCellier($body);
			echo json_encode($resultat);
		} else {
			include("vues/entete.php");
			include("vues/ajouter.php");
			include("vues/pied.php");
		}
	}

	/**
	 * Récupère les informations sur la bouteille dont la quantité doit être modifiée et déclenche la requete sql de modification de quantité avec -1.
	 * @return json
	 */
	private function boireBouteilleCellier()
	{
		$body = json_decode(file_get_contents('php://input'));

		$bte = new Bouteille();
		$resultat = $bte->modifierQuantiteBouteilleCellier($body->id, -1);
		echo json_encode($resultat);
	}

	/**
	 * Récupère les informations sur la bouteille dont la quantité doit être modifiée et déclenche la requete sql de modification de quantité avec +1.
	 * @return json
	 */
	private function ajouterBouteilleCellier()
	{
		$body = json_decode(file_get_contents('php://input'));

		$bte = new Bouteille();
		$resultat = $bte->modifierQuantiteBouteilleCellier($body->id, 1);
		echo json_encode($resultat);
	}
}
