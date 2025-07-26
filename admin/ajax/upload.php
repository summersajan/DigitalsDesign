<?php
function isAllowedDigitalFile($filename)
{
    $allowedExtensions = ['pdf', 'zip', 'doc', 'docx', 'txt', 'rar'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, $allowedExtensions);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['upload_image']) && isset($_FILES['image_file'])) {
        $targetDir = "../../uploads/";
        $file = $_FILES['image_file'];
        $fileName = basename($file["name"]);
        $targetFile = $targetDir . time() . "_" . $fileName;

        // Validate image
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                echo "Image uploaded successfully: $targetFile";
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    if (isset($_POST['upload_digital']) && isset($_FILES['digital_file'])) {
        $targetDir = "../../digitals/";
        $file = $_FILES['digital_file'];
        $fileName = basename($file["name"]);
        $targetFile = $targetDir . time() . "_" . $fileName;

        // Validate file extension
        if (isAllowedDigitalFile($fileName)) {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                echo "Digital file uploaded successfully: $targetFile";
            } else {
                echo "Error uploading digital file.";
            }
        } else {
            echo "Unsupported digital file type.";
        }
    }
} else {
    echo "Invalid request.";
}
?>