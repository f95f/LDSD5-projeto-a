<?php
    require_once __DIR__ . '/../controllers/diario-controller.php';


    $controller = new DiarioController();

    $diarios = $controller->getAllDiarios();
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {        
        $action = isset($_POST['action']) ? $_POST['action'] : '';


        switch ($action) {

            case 'CREATE':
                $request = $_POST;
                
                $diario['title'] = $_POST['tituloDiario'];
                $diario['content'] = $_POST['conteudoDiario'];
                $diario['created_at'] = date("Y/m/d");

                $controller->createDiario($diario);
                echo json_encode(['success' => true, 'message' => 'Diário criado.']);
                break;


            case 'SEARCH':
                $query = $_POST;
                $diarios = $controller->searchDiarios($query);
                echo json_encode(['success' => true, 'message' => $diarios]);
                break;


            case 'UPDATE':
                $diario['id'] = $_POST['idDiario'];
                $diario['title'] = $_POST['tituloDiario'];
                $diario['content'] = $_POST['conteudoDiario'];
                
                $controller->updateDiario($diario);
                echo json_encode(['success' => true, 'message' => 'Diario Atualizado']);
                break;



            case 'DELETE':
                $diarioId = $_POST['id'];
                
                $controller->deleteDiario($diarioId);
                echo json_encode(['success' => true, 'message' => 'Diário Excluído']);
                break;

    
                
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                break;
        }


        exit();
    }

    define("TITLE", "Diário | Journalling");
    define("PAGE", "DIARIO");
    define("STYLESHEET", "diario");
    include __DIR__ . '/../layout/side-menu.php'; 
    include __DIR__ . '/../layout/header.php';
    include __DIR__ . '/../layout/notifications.php';

?>

<header>
    <div class="title">
        <i class="fa-solid fa-book"></i>
        <h1>Diário Pessoal</h1>
    </div>
</header>
<main>
    <div class="wrapper">
        

        <div class="menubar">
            <!-- <form   method="POST"
                    id="searchForm"
                    class="searchbar">
                <input  type="text" 
                        id="searchInput"
                        name="searchInput"
                        placeholder="Pesquisar..."
                        class="inline-input" >
                <button type="submit" role='button' 
                    class="inline-button">
                    <i class="fa-solid fa-magnifying-glass icon search-icon"></i>
                </button>
            </form> -->
            <button id="showFormModal" class="pill-button">
                <i class="fa-solid fa-plus"></i>
                Novo Diário
            </button>
        </div>


        <ul class="card-grid" id="diarioList">
        <?php foreach($diarios as $item): ?>
            <li class="card-item">
                <div class="card-row">
                    <h3>
                        <i class="fa-solid fa-book"></i>
                        <?= $item['title']?>
                    </h3>
                    <div class="actions-wrapper">
                        <a  role="button"
                            class="inline-button editButton"
                            data-note-title="<?= $item['title'] ?>"
                            data-note-content="<?= $item['content'] ?>"
                            data-note-id="<?= $item['id'] ?>">
                            <i class="fa-solid fa-edit light-text"></i>
                        </a>
                        <span class="light-text">|</span>
                        <a  role="button"
                            class="inline-button deleteButton"
                            data-note-id="<?= $item['id'] ?>">
                            <i class="fa-solid fa-trash light-text"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?= $item['content']; ?>
                </div>
                
                <div class="card-row">
                    <a href="diario-details.php?id=<?= $item['id']?>"
                        class="inline-button">
                        <i class="fa-solid fa-circle-info"></i>
                        Ver mais...
                    </a>
                </div>
            </li>
        <?php endforeach ?>
        </ul>
    </div>

    <div class="overlay"></div>
    <div class="modal" id="createModal">
        <div class="modal-wrapper">
            <div class="modal-header">
                <h2>Adicionar Diário</h2>
            </div>
            <div class="modal-body">
                
            <form method="POST" id="addDiarioForm" name="addDiarioForm">
                <div class="input-row">
                    <label for="tituloDiario">Título do Diário:</label>
                    <input
                        type="text"
                        id="tituloDiario"
                        name="tituloDiario"
                        placeholder="Qual o título do diário?"
                    >
                </div>

                <div class="input-row">
                    <label for="conteudoDiario">Nota</label>
                    <textarea
                        rows="12"
                        type="text"
                        id="conteudoDiario"
                        name="conteudoDiario"
                        placeholder="Escreva o que quiser..."
                    >
                    </textarea>
                </div>

                <input type="hidden"
                        id="idDiario"
                        name="idDiario">
                
                <div class="modal-footer">
                    <button
                        type="button"
                        id="closeCreateModal"
                        class="pill-button secondary"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        id="submitDiario"
                        class="pill-button"
                    >
                        <i class="fa-solid fa-plus"></i>
                        Adicionar
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<div class="toast" id="toast" style="display:none;">
    <div class="icon" id="icon"></div>
    <div class="toast-text">
        <div class="toast-header">
            <span class="toast-title" id="toastTitle"></span>
        </div>
        <div class="toast-body">
            <span class="toast-message" id="toastMessage"></span>
        </div>
    </div>
</div>


<footer>
    <script type="module"  src="../scripts/toast.js"></script>
    <script type="module"  src="../scripts/validation.js"></script>
    <script type="module"  src="../scripts/diario.js"></script>
</footer>