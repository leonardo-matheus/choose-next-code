<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectId = $_POST['project_id'];
    $projectName = $_POST['project_name'];
    $projectDescription = $_POST['project_description'];
    $projectTechnologies = $_POST['project_technologies'];
    $projectLink = $_POST['project_link'];

    $stmt = $pdo->prepare("UPDATE projects SET name = :name, description = :description, technologies = :technologies, link = :link WHERE id = :id");
    $stmt->execute([
        'name' => $projectName,
        'description' => $projectDescription,
        'technologies' => $projectTechnologies,
        'link' => $projectLink,
        'id' => $projectId
    ]);

    header("Location: index.php");
    exit();
}
?>
