<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

function getFileIcon($fileName) {
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    switch ($ext) {
        case 'pdf':
            $icon = 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/1667px-PDF_file_icon.svg.png';
            break;
        case 'doc':
        case 'docx':
            $icon = 'https://cdn-icons-png.freepik.com/512/8361/8361174.png';
            break;
        case 'xls':
        case 'xlsx':
            $icon = 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/34/Microsoft_Office_Excel_%282019%E2%80%93present%29.svg/1101px-Microsoft_Office_Excel_%282019%E2%80%93present%29.svg.png';
            break;
        case 'exe':
        case 'msi':
        case 'dll':
            $icon = "https://files.softicons.com/download/system-icons/file-extension-icons-by-design-bolts/ico/BIN%20File%20Extension.ico";
        break;
	case 'php':
	    $icon = "https://cdn-icons-png.flaticon.com/512/337/337947.png";
	break;
	case 'html':
	    $icon = "https://cdn-icons-png.flaticon.com/256/4248/4248142.png";
	break;
	case 'css':
	    $icon = "https://cdn.icon-icons.com/icons2/2790/PNG/512/css_filetype_icon_177544.png";
	break;
	case 'js':
	    $icon = "https://cdn-icons-png.flaticon.com/512/4726/4726005.png";
	break;
        default:
            $icon = 'https://p1.hiclipart.com/preview/963/138/525/all-flat-icons-the-complete-set-unknown-extension-png-icon.jpg';
        break;
    }
    return $icon;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Archivos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            cursor: pointer;
        }
        li:hover {
            background-color: #f4f4f4;
        }
        .file-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            vertical-align: middle;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Listado de Archivos</h1>
    <ul id="file-list">
	<?php
        $files = scandir(__DIR__);
        foreach ($files as $file) {
            if (substr($file, 0, 1) != "." && $file != ".." && $file != "index.php") {
                echo "<li data-file=\"$file\"><img class=\"file-icon\" src=\"" . getFileIcon($file) . "\"> $file</li>";
            }
        }
    ?>
    </ul>

    <?php
        // Modal 
        echo '<div id="fileModal" class="modal">';
        echo '    <div class="modal-content">';
        echo '        <span class="close">&times;</span>';
        echo '        <iframe id="fileFrame" width="100%" height="400px" frameborder="0"></iframe>';
        echo '    </div>';
        echo '</div>';
    ?>

    <script>
        // Función para obtener el icono de archivo según la extensión
        function getFileIcon(fileName) {
            var ext = fileName.split('.').pop().toLowerCase();
            var icon = '';
            switch (ext) {
                case 'pdf':
                    icon = 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/1667px-PDF_file_icon.svg.png';
                    break;
                case 'doc':
                case 'docx':
                    icon = 'https://cdn-icons-png.freepik.com/512/8361/8361174.png';
                    break;
                case 'xls':
                case 'xlsx':
                    icon = 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/34/Microsoft_Office_Excel_%282019%E2%80%93present%29.svg/1101px-Microsoft_Office_Excel_%282019%E2%80%93present%29.svg.png';
                    break;
                case '':
                case 'exe':
                case 'msi':
                case 'dll':
                    icon = "https://files.softicons.com/download/system-icons/file-extension-icons-by-design-bolts/ico/BIN%20File%20Extension.ico";
                    break;
                default:
                    icon = 'https://p1.hiclipart.com/preview/963/138/525/all-flat-icons-the-complete-set-unknown-extension-png-icon.jpg';
                    break;
            }
            return icon;
        }

        // JavaScript para abrir el modal al hacer clic en un archivo
        document.addEventListener('DOMContentLoaded', function() {
            var fileList = document.getElementById('file-list');
            var modal = document.getElementById('fileModal');
            var closeModal = document.getElementsByClassName('close')[0];
            var fileFrame = document.getElementById('fileFrame');

            fileList.addEventListener('click', function(event) {
                var target = event.target;
                if (target.tagName === 'LI') {
                    var fileName = target.getAttribute('data-file');
                    var fileUrl = encodeURI(fileName);
                    fileFrame.src = fileUrl;
                    modal.style.display = 'block';
                }
            });

            closeModal.onclick = function() {
                modal.style.display = 'none';
            };

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };
        });
    </script>
</body>
</html>