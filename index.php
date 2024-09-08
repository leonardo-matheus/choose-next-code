<?php
session_start();
require 'db.php';

// Verificar autenticação
if (!isset($_SESSION['user'])) {
    header('Location: auth.php');
    exit();
}

// Selecionar projetos do banco de dados
$stmt = $pdo->query("SELECT * FROM projects");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roleta de Projetos</title>
    <style>
        /* CSS para a roleta e animação */
        body {
            font-family: Arial, sans-serif;
        }

        .wheel-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }

        .wheel {
            width: 300px;
            height: 300px;
            border-radius: 50%;
            border: 5px solid #333;
            position: relative;
            transition: transform 5s cubic-bezier(0.33, 1, 0.68, 1);
        }

        .slice {
            position: absolute;
            width: 50%;
            height: 50%;
            background-color: #f4f4f4;
            border: 1px solid #333;
            transform-origin: 100% 100%;
            text-align: center;
            line-height: 150px;
            color: #333;
            font-weight: bold;
        }

        .slice:nth-child(1) { transform: rotate(0deg) translate(50%, 50%); }
        .slice:nth-child(2) { transform: rotate(60deg) translate(50%, 50%); }
        .slice:nth-child(3) { transform: rotate(120deg) translate(50%, 50%); }

        /* Animação e modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        #spinButton {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #008cba;
            color: white;
            border: none;
            cursor: pointer;
        }

        #spinButton:hover {
            background-color: #005f5f;
        }
    </style>
</head>
<body>
    <h1>Roleta de Projetos</h1>

    <div class="wheel-container">
        <div class="wheel" id="wheel">
            <?php foreach ($projects as $project): ?>
                <div class="slice"><?= htmlspecialchars($project['name']) ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <button id="spinButton" onclick="spin()">Girar</button>

    <!-- Modal para exibir projeto sorteado -->
    <div id="projectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Projeto</h2>
            <p id="modalDescription">Descrição</p>
            <p id="modalTechnologies">Tecnologias</p>
            <a id="modalLink" href="#">Ver Projeto</a>
        </div>
    </div>

    <script>
        let wheel = document.getElementById("wheel");

        function spin() {
            let randomRotations = Math.floor(Math.random() * 3) + 5;
            let anglePerSlice = 360 / <?= count($projects) ?>;
            let randomSlice = Math.floor(Math.random() * <?= count($projects) ?>);
            let randomAngle = randomSlice * anglePerSlice;
            let totalRotation = (randomRotations * 360) + randomAngle;
            wheel.style.transform = `rotate(${totalRotation}deg)`;

            setTimeout(() => {
                showProjectModal(randomSlice);
            }, 5000);
        }

        function showProjectModal(sliceIndex) {
            let projects = <?= json_encode($projects) ?>;
            let project = projects[sliceIndex];
            document.getElementById('modalTitle').textContent = project.name;
            document.getElementById('modalDescription').textContent = project.description;
            document.getElementById('modalTechnologies').textContent = "Tecnologias: " + project.technologies;
            document.getElementById('modalLink').href = project.link;
            document.getElementById('projectModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('projectModal').style.display = 'none';
        }
    </script>
</body>
</html>
