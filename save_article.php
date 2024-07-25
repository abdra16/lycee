<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $supplier_id = $_POST['supplier_id'];

    // Handling file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                // Insert article data into database
                $stmt = $conn->prepare("INSERT INTO articles (name, description, category_id, supplier_id, image_path) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdds", $name, $description, $category_id, $supplier_id, $targetFilePath);

                if ($stmt->execute()) {
                    header("Location: article.php?success=1");
                    exit();
                } else {
                    echo "Erreur : " . $stmt->error;
                }
            } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            }
        } else {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        }
    } else {
        echo "Veuillez sélectionner un fichier à télécharger.";
    }
}
?>
