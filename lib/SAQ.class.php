<?php

/**
 * 
 *
 *
 * @author Jonathan Martel
 * @version 1.0
 *
 *
 *
 */
class SAQ extends Modele
{

	const DUPLICATION = 'duplication';
	const ERREURDB = 'erreurdb';
	const INSERE = 'Nouvelle bouteille insérée';

	private static $_webpage;
	private static $_status;
	private $stmt;

	public function __construct()
	{
		parent::__construct();
		if (!($this->stmt = $this->_db->prepare("INSERT INTO vino__bouteille(nom, type, image, code_saq, pays, description, prix_saq, url_saq, url_img, format) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
			echo "Echec de la préparation : (" . $mysqli->errno . ") " . $mysqli->error;
		}
	}

	/**
	 * getProduits
	 * Cette méthode récupére et affiche la liste des bouteilles de la page 
	 * @param int $nombre
	 * @param int $debut
	 * @return int
	 */
	 
	public function getProduits($nombre = 24, $page = 1)
	{
		$s = curl_init();
		$url = "https://www.saq.com/fr/produits/vin/vin-rouge?p=1&product_list_limit=24&product_list_order=name_asc";
		curl_setopt($s, CURLOPT_URL, $url);
		curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($s, CURLOPT_FOLLOWLOCATION, 1);

		self::$_webpage = curl_exec($s);
		self::$_status = curl_getinfo($s, CURLINFO_HTTP_CODE);
		curl_close($s);

		$doc = new DOMDocument(); //instanciation de la classe DOMDocument()
		$doc->recover = true;
		$doc->strictErrorChecking = false;
		$doc->loadHTML(self::$_webpage); //chargement du code html de la page web
		$elements = $doc->getElementsByTagName("li"); //Création de l'objet contenant la liste des 
		                                             //éléments li
		$i = 0;

		foreach ($elements as $key => $noeud) {
			//var_dump($noeud -> getAttribute('class')) ;
			
				//tester si la classe "product-item existe
			if (strpos($noeud->getAttribute('class'), "product-item") !== false) {

				//echo $this->get_inner_html($noeud);
				$info = self::recupereInfo($noeud);
				echo "<p>" . $info->nom;
				$retour = $this->ajouteProduit($info);
				echo "<br>Code de retour : " . $retour->raison . "<br>";
				if ($retour->succes == false) {
					echo "<pre>";
					var_dump($info);
					echo "</pre>";
					echo "<br>";
				} else {
					$i++;
				}
				echo "</p>";
			}
		}

		return $i;
	}

	/**
	 * get_inner_html
	 * Cette méthode sauvegarde la collection d'éléments dans une chaine de caractéres 
	 * @param string $node
	 * @return string
	 */

	private function get_inner_html($node)
	{
		$innerHTML = '';
		$children = $node->childNodes; //récuperer la collection d'éléments
		foreach ($children as $child) {
			$innerHTML .= $child->ownerDocument->saveXML($child); //sauvegarde la liste dans une chaine de caractéres
		}

		return $innerHTML;
	}
	
	/**
	 * nettoyerEspace
	 * Cette méthode enléve les espace en trop dans la chaine
	 * @param string $node
	 * @return string
	 */

	static private function nettoyerEspace($chaine)
	{
		return preg_replace('/\s+/', ' ', $chaine);
	}

    /**
	 * recupereInfo
	 * Cette méthode enléve les espace en trop dans la chaine
	 * @param string $node
	 * @return string
	 */
	private static function recupereInfo($noeud)
	{

		$info = new stdClass(); //déclaration d'un objet vide
		$info->img = $noeud->getElementsByTagName("img")->item(0)->getAttribute('src'); //TODO : Nettoyer le lien
		;
		$a_titre = $noeud->getElementsByTagName("a")->item(0);
		$info->url = $a_titre->getAttribute('href');

		$info->nom = self::nettoyerEspace(trim($a_titre->textContent));	//TODO : Retirer le format de la bouteille du titre.

		// Type, format et pays
		$aElements = $noeud->getElementsByTagName("strong");
		foreach ($aElements as $node) {
			if ($node->getAttribute('class') == 'product product-item-identity-format') {
				$info->desc = new stdClass();
				$info->desc->texte = $node->textContent;
				$info->desc->texte = self::nettoyerEspace($info->desc->texte);
				$aDesc = explode("|", $info->desc->texte); // Type, Format, Pays
				if (count($aDesc) == 3) {

					$info->desc->type = trim($aDesc[0]);
					$info->desc->format = trim($aDesc[1]);
					$info->desc->pays = trim($aDesc[2]);
				}

				$info->desc->texte = trim($info->desc->texte);
			}
		}

		//Code SAQ
		$aElements = $noeud->getElementsByTagName("div");
		foreach ($aElements as $node) {
			if ($node->getAttribute('class') == 'saq-code') {
				if (preg_match("/\d+/", $node->textContent, $aRes)) {
					$info->desc->code_SAQ = trim($aRes[0]);
				}
			}
		}

		$aElements = $noeud->getElementsByTagName("span");
		foreach ($aElements as $node) {
			if ($node->getAttribute('class') == 'price') {
				$info->prix = trim($node->textContent);
			}
		}
		//var_dump($info);
		return $info;
	}

	private function ajouteProduit($bte)
	{
		$retour = new stdClass();
		$retour->succes = false;
		$retour->raison = '';

		//var_dump($bte);
		// Récupère le type
		$rows = $this->_db->query("select id from vino__type where type = '" . $bte->desc->type . "'");

		if ($rows->num_rows == 1) {
			$type = $rows->fetch_assoc();
			//var_dump($type);
			$type = $type['id'];


			$rows = $this -> _db -> query("select id from vino__bouteille where code_saq = '" . $bte -> desc -> code_SAQ . "'");
			if ($rows -> num_rows < 1) {
				$this -> stmt -> bind_param("sissssdsss", $bte -> nom, $type, $bte -> img, $bte -> desc -> code_SAQ, $bte -> desc -> pays, $bte -> desc -> texte, $bte -> prix, $bte -> url, $bte -> img, $bte -> desc -> format);
				$retour -> succes = $this -> stmt -> execute();
				$retour -> raison = self::INSERE;

			
				//var_dump($this->stmt);
			} else {
				$retour->succes = false;
				$retour->raison = self::DUPLICATION;
			}
		} else {
			$retour->succes = false;
			$retour->raison = self::ERREURDB;
		}
		return $retour;
	}
}
