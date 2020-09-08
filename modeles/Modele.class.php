<?php
/**
 * Class Modele
 * Template de classe modèle. Dupliquer et modifier pour votre usage.
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */
class Modele {
	
    protected $_db;

    /**
     * Constructeur de la classe 
     *
     */ 
	function __construct ()
	{
		$this->_db = MonSQL::getInstance();
	}
    
    /**
     * Destructeur de la classe 
     *
     */ 
	function __destruct ()
	{
		
	}
}
?>