<?php

require_once "./controler/ContactControler.php";

switch (getURL()) {
    case 'Form_Contact/':
    case 'Form_Contact/index.php':
    case 'Form_Contact/index.php/accueil':
        showContacts(ContactRepository::getAllContact());
        break;
    
    case 'Form_Contact/index.php/contact':
        if($_GET) showContactDetails(ContactRepository::getContactById($_GET['id']));
        if(!empty($_POST['delete'])){
            ContactRepository::deleteContact($_POST['delete']);
            header("Location: /Form_Contact");
        }
        break;
    
    case 'Form_Contact/index.php/addcontact':
        createContact();
        if (!empty($_POST['lastName']) && !empty($_POST['firstName']) && !empty($_POST['mail']) && !empty($_POST['phone']) && !empty($_POST['birthDay'])) {           
            header("Location: /Form_Contact/index.php/contact?id=".ContactRepository::addContact());
        }
        break;
    
    case 'Form_Contact/index.php/updatecontact':
        if($_GET) updateContact(ContactRepository::getContactById($_GET['id']));
        if (!empty($_POST['lastName']) && !empty($_POST['firstName']) && !empty($_POST['mail']) && !empty($_POST['phone']) && !empty($_POST['birthDay'])) {           
            header("Location: /Form_Contact/index.php/contact?id=".ContactRepository::updateContact($_GET['id']));
        }
        break;

    default:
        break;
}

?>