<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Image Upload (Drag & Drop + Click)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .upload-container {
            width: 400px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .upload-box {
            border: 2px dashed #ccc;
            padding: 30px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .upload-box.dragover {
            border-color: #6c5ce7;
            background-color: #f0f0ff;
        }

        .upload-box p {
            margin: 0;
            font-size: 16px;
            color: #888;
        }

        input[type="file"] {
            display: none;
        }

        .preview img {
            margin-top: 15px;
            max-width: 100%;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="upload-container">
        <form id="uploadForm">
            <label for="fileInput" class="upload-box" id="uploadBox">
                <p>Drag & drop an image here<br>or click to select</p>
                <input type="file" id="fileInput" accept="image/*">
            </label>
            <div class="preview" id="preview"></div>
        </form>
    </div>

    <script>
        const uploadBox = document.getElementById('uploadBox');
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');

        // Show preview
        function previewImage(file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Image Preview">`;
            };
            reader.readAsDataURL(file);
        }

        // File selected
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                previewImage(file);
            }
        });

        // Drag & Drop handlers
        uploadBox.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadBox.classList.add('dragover');
        });

        uploadBox.addEventListener('dragleave', () => {
            uploadBox.classList.remove('dragover');
        });

        uploadBox.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadBox.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                previewImage(file);
            }
        });

    </script>

</body>

</html>