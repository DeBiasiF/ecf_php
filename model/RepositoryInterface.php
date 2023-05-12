<?php

interface RepositoryInterface {

       
    //Permet la création d'un Objet 
    public static function create(Array $myArray) : ?Object;

    //Permet l'appel à l'integralité des emprunts et renvoie un tableau d'objet "Borrowing"
    public static function getAll() : Array ;

    //Permet l'ajout d'un emprunt
    public static function add(Object $object) : int ;

    //Permet l'édition d'un emprunt
    public static function update(Object $object) : int ;

    //Permet la suppression d'un emprunt
    public static function delete(int $id) : void ;

    //Permet l'appel à un objet "Borrowing" via son ID
    public static  function getById(int $id) : ?Object ;

}
?>
