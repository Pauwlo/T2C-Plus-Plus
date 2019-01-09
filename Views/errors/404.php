<?php

$title = 'Page introuvable – T2C++';

ob_start();
?>
<div class="container mt-5">

    <header>
        <div class="row text-center align-middle">
            <div class="col h4"><a href="javascript:history.back()" onclick="return false;"><i class="fas fa-chevron-left align-middle"></i></a></div>
            <div class="col-6 h2">Erreur</div>
            <div class="col h4"></div>
        </div>
    </header>

    <main role="main">

        <div class="row mt-4">
            <div class="col">
                <h3>Page introuvable</h3>
                <p>Cette page n'existe pas.</p>
            </div>
        </div>

    </main>

    </div> <!-- #app -->
<?php
$content = ob_get_clean();

require __DIR__ . '/../layouts/app.php';
