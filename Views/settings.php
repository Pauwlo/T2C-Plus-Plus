<?php

$title = 'Paramètres – T2C++';

ob_start();
?>
<div class="container mt-5">

    <header>
        <div class="row text-center align-middle">
            <div class="col h4"><a href="."><i class="fas fa-chevron-left align-middle"></i></a></div>
            <div class="col-6 h2">Paramètres</div>
            <div class="col h4"></div>
        </div>
    </header>

    <main role="main">

        <div class="row mt-4">
            <div class="col-lg-5 col-md-8">

<?php if (isset($errors)) {
    echo '<p class="text-danger">';
    foreach ($errors as $e) {
        echo $e . '<br>';
    }
    echo '</p>';
}
?>

                <h3>Sauvegarde en ligne</h3>
                
<?php if (! $isLogged): ?>
                <form id="auth" method="POST" action="settings">
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" class="form-control" required>
                    </div>

                    <input id="action" name="action" type="hidden" value="">
                    <input id="password-hash" name="password-hash" type="hidden" value="">

                    <button id="save" name="save" class="btn btn-lg">Sauvegarder</button>
                    <button id="load" class="btn btn-lg">Charger</button>
                </form>
<?php else: ?>
                <p>Activée.</p>
                <form method="POST" action="settings">
                    <button type="submit" name="logout" class="btn btn-lg mb-4">Désactiver</button>
                </form>
<?php endif; ?>
            </div>
        </div>

<?php if ($isLogged) { ?>
        <div class="row mt-2">
            <div class="col-lg-5 col-md-8">
                <h3>Favoris</h3>

<?php if (count($favorites)) { ?>
    <table class="table table-responsive mt-4" id="favorites-table">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Arrêt</th>
                            <th scope="col">Direction</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="favorites-table-body">
<?php foreach ($favorites as $f) { ?>
        <tr>
            <th scope="row"><?= $f->getName() ?></th>
            <td><?= $f->getStop() ?></td>
            <td><?= $f->getDirection() ?></td>
            <td class="pt-1"><button type="button" class="btn btn-sm btn-danger btn-delete-favorite" data-name="<?= $f->getName() ?>"><i class="fas fa-trash-alt"></i></button></td>
        </tr>
<?php } ?>
                    </tbody>
                </table>
<?php } else { ?>
    <p>Vous n'avez pas encore créé de favori.</p>
<?php } ?>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-lg-5 col-md-8">
                <h3>Préférences</h3>

                <p>Afficher le bouton d'ajout de favoris : <span id="t-showBtnAdd"><?= $showBtnAdd ? 'Oui' : 'Non' ?></span></p>
                <button id="s-showBtnAdd" class="btn btn-setting" data-name="showBtnAdd" data-value="<?= $showBtnAdd ? 'true' : 'false' ?>"><?= $showBtnAdd ? 'Désactiver' : 'Activer' ?></button>

                <p class="mt-4">Mode jour : <span id="t-dayMode"><?= $dayMode ? 'Oui' : 'Non' ?></span></p>
                <button id="s-dayMode" class="btn btn-setting" data-name="dayMode" data-value="<?= $dayMode ? 'true' : 'false' ?>"><?= $dayMode ? 'Désactiver' : 'Activer' ?></button>
            </div>
        </div>
<?php } ?>

    </main>

    </div> <!-- #app -->
<?php
$content = ob_get_clean();

ob_start();
?>
    <script src="./public/js/sha256.js"></script>
    <script src="./public/js/settings.js"></script>
<?php
$scripts = ob_get_clean();

require 'layouts/app.php';
