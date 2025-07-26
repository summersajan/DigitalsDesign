<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Image & Digital File</title>
</head>

<body>
    <h2>Upload Image</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image_file" accept="image/*" required>
        <button type="submit" name="upload_image">Upload Image</button>
    </form>

    <h2>Upload Digital File (PDF, ZIP, etc.)</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="digital_file" required>
        <button type="submit" name="upload_digital">Upload Digital</button>
    </form>
</body>

</html>