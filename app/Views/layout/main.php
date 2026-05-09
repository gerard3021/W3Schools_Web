<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

    <header>
        <h1>Mi sitio</h1>
    </header>

    <nav>
        <a href="/">Inicio</a>
        <a href="/about">Acerca</a>
        <a href="/productos">Productos</a>
    </nav>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer>
        <p>© 2026</p>
    </footer>

</body>
</html>