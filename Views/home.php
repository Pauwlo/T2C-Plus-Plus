<?php

$title = 'T2C++';

ob_start();
?>
<div id="app" class="container mt-5">

    <header>
        <div class="row text-center align-middle">
            <div class="col h4"><a href="#" id="show-modal" @click.prevent="showModal = true"><i class="fas fa-info-circle align-middle"></i></a></div>
            <div class="col-6 h2">T2C++</div>
            <div class="col h4"><a href="settings"><i class="fas fa-cog align-middle"></i></a></div>
        </div>
    </header>

    <main role="main">

<?php if (isset($favorites)) { ?>
        <div class="row mt-4">
            <div class="col">
                <span id="favorites">
<?php
    foreach ($favorites as $f) {
        $name = $f->getName();
        $stop = $f->getStop();
        $direction = $f->getDirection();
        echo "<button class=\"btn btn-lg\" data-stop=\"$stop\" data-direction=\"$direction\">$name</button>\n";
    }
?>
                </span>
<?php if ($showBtnAdd) { ?>
                <button class="btn btn-lg" id="add-favorite" v-bind:disabled="stopSelected == 0 || directionSelected == 0">+</button>
<?php } ?>
            </div>
        </div>
<?php } ?>

        <div class="row mt-4">
            <div class="col-8 ml-4">
                <div class="row mb-2">
                    <div class="form-group">
                        <label for="stop">Arrêt</label>
                        <select class="custom-select" id="stop" v-model="stopSelected">
                            <option value="0" selected>-- Sélectionnez --</option>
                            <option v-for="stop in stops" v-bind:value="stop">
                                {{ stop }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group mb-0">
                        <label for="direction">Direction</label>
                        <select class="custom-select" id="direction" v-model="directionSelected" v-bind:disabled="stopSelected == 0">
                            <option value="0">-- Sélectionnez --</option>
                            <option v-for="direction in directions" v-bind:value="direction">
                                {{ direction }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col text-center m-auto">
                <div class="line">
                    <small>ligne</small>
                    <span class="h3 d-block">A</span>
                </div>
            </div>
        </div>

        <template v-if="stopSelected != 0 && directionSelected != 0">
            <hr class="mt-5 mb-4">

            <div class="container">
                <div class="row">
                    <ul class="list-unstyled m-auto text-center">
                        <li v-for="time in times">
                            <p class="time" v-bind:class="[time.class]">{{ time.text }}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </template>

    </main>

    <modal v-if="showModal" @close="showModal = false"></modal>

</div> <!-- #app -->
<?php
$content = ob_get_clean();

ob_start();
?>
    <script type="text/x-template" id="modal-template">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-container">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">À propos de T2C++</h5>
                            </div>
                            <div class="modal-body">
                                <p>T2C++ vous offre une meilleure expérience numérique avec les services T2C.</p>
                                <p>Pour toute réclamation, contactez <a href="mailto:pauwlo@outlook.com">pauwlo@outlook.com</a>.</p>
                                <p class="text-muted">
                                    © <a href="https://www.pauwlo.fr/" target="_blank">Pauwlo</a> 2019<br>
                                    Version 0.7
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn" data-dismiss="modal" @click="$emit('close')">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </script>

    <script src="./public/js/home.js"></script>
<?php
$scripts = ob_get_clean();

require 'layouts/app.php';
