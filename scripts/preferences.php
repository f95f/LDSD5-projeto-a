<?php 
    require_once __DIR__ . '/../controllers/usuario-controller.php';
    
    session_start();
    $usuarioController = new UsuarioController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $action = $_POST['action']? $_POST['action'] : '';

        switch($action) {

            case "UPDATE_PREFERENCES":
                $preferences = $_POST['daysBeforeDeadlineWarning'];

                $usuarioController->setDeadlinePreferences($preferences);
                echo json_encode('Item atualizado.');
                exit();

            break;
            
        }
      
    }
    

?>