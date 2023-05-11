<?php

switch($_GET['action']) {

    //appel api de verification de disponibilité de date de reservation
    case 'borrowDisponibility':
        $id = $_GET['id'];
        $start = $_GET['start'];
        $end = $_GET['end'];
        $disponibility = BorrowingRepository::getBorrowDisponibility($id, $start, $end);
        $result = array("success" => $disponibility);
        header('Content-Type: application/json');
        echo json_encode($result);
        break;

    //appel api de vérification si un utilisatuer a des biens en cours de location
    case 'goodRented':
        $id = $_GET['id'];
        $disponibility = UserRepository::getGoodRented($id);
        $result = array("success" => $disponibility);
        header('Content-Type: application/json');
        echo json_encode($result);
        break;

}
?>
