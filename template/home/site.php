<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h1>
    hello <?= $title ?>
</h1>

<ul>
    <?php foreach ($result as $item): ?>
        <li><?= $item['title'] ?></li>
    <?php endforeach; ?>
</ul>
</body>
</html>

