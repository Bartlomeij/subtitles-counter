<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>The Subtitles Counter</title>
    <meta name="description" content="The Subtitles Counter">
    <meta name="author" content="Bartlomiej Rozycki">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<h2>Subtitles Counter</h2>
<div><?=$errorMessage?></div>
<form id="upload_form" enctype="multipart/form-data" method="POST">
    <p>Select file to upload (.txt and .srt files only):</p>
    <input type="file" name="file" id="file" accept=".txt,.srt"><br />
    <input type="submit" value="Upload File">
</form>
<div>
<?if (!empty($wordsTable)):?>
    <p>Words counter in file: <?=$originalFileName?></p>
    <table>
        <tr>
            <th>Word</th>
            <th>Counter</th>
        </tr>
        <?foreach ($wordsTable as $word => $counter):?>
        <tr>
            <td><?=$word?></td>
            <td><?=$counter?></td>
        </tr>
        <?endforeach;?>
    </table>
<?endif;?>
</div>
</body>
</html>