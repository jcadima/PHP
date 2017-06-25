<?php
use PHP\File\Upload;

if (isset($_POST['upload'])) {
    // define the path to the upload folder
    $destination = 'uploads/';
    require_once 'Upload.php';
    try {
        $loader = new Upload($destination);
        $loader->uploadFile();
        $result = $loader->getMessages();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta  charset="utf-8">
    <title>Upload File(s)</title>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>

<body>
<?php
if (isset($result)) {
    echo '<ul>';
    foreach ($result as $message) {
        echo "<li>$message</li>";
    }
    echo '</ul>';
}
?>
<form action="" method="post" enctype="multipart/form-data" id="uploadImage">
    <p>
        <label for="image">Upload image:</label>
        <input type="file" name="image[]" id="standard-upload-files" multiple>
    </p>
    <p>
        <input type="submit" name="upload" id="upload" value="Upload">
    </p>
</form>
</body>
</html>