<?php
require_once  __DIR__ . '/../Models/Data.php';
require_once  __DIR__ . '/../Controllers/meteoController.php';


//IMPORTANT: Change with the correct path to wp-load.php in your installation
//require_once ('../../../../wp-load.php');

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<h1>Plugin Météo</h1>
<div class="container w-70">

    <div class="container my-4 p-4  border shadow bg-body rounded">
        <!-- <div id="icon-options-general" class="icon32"></div> -->

        <form method="post" action="options.php">
            <?php

            // add_settings_section callback is displayed here. For every new section we need to call settings_fields.
            settings_fields("meteo_section");

            // all the add_settings_field callbacks is displayed here
            do_settings_sections("theme-options");

            // Add the submit button to serialize the options
            submit_button();
            ?>
        </form>
    </div>

    <!-- Formulaire génération du shortdecode -->
    <div class="container my-4 p-4  border shadow  bg-body rounded ">
        <h3>Générer un short code </h3>
        <form class="col-6 row g-3">
            <div class="col-12">
                <div class="row mb-3">
                    <label for="commune" class="col-sm-2 col-form-label">Commune</label>
                    <div class="col-sm-10">
                        <input name="commune" list="list-communes1" type="text" class="form-control" id="commune1">
                        <datalist id="list-communes1">
                        </datalist>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row mb-3">
                    <label for="shortcode" class="col-sm-2 col-form-label">Shortcode</label>
                    <div class="col-sm-10">
                        <input name="shortcode" type="text" class="form-control" id="shortcode">
                        <span id="copy-msg"></span>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <button type="button" class="btn btn-primary" id="copy-btn">Copier le short code</button>
            </div>
        </form>

    </div>

    <!-- Formulaire génération du shortdecode -->
    <div class="container my-4 p-4  border shadow  bg-body rounded ">
        <h3>Gérer les options de la méteo </h3>
        <form class="col-6 row g-3">
            <div class="col-12">
                <div class="row mb-3">
                    <label for="commune" class="col-sm-2 col-form-label">Commune</label>
                    <div class="col-sm-10">
                        <input name="commune" list="list-communes2" type="text" class="form-control" id="commune2">
                        <datalist id="list-communes2">
                        </datalist>

                    </div>
                </div>
            </div>

            <!-- Les options -->
            <div class="col-12 ">
                <div class="form-check">
                    <input style="margin-top: 5px" class="form-check-input position-static" type="checkbox" id="inlineFormCheck">
                    <label class="form-check-label pb-1 " for="inlineFormCheck">Température</label>
                </div>
                <div class="form-check">
                    <input style="margin-top: 5px" class="form-check-input position-static" type="checkbox" id="inlineFormCheck">
                    <label class="form-check-label pb-1 " for="inlineFormCheck">Température ressentie</label>
                </div>
                <div class="form-check">
                    <input style="margin-top: 5px" class="form-check-input position-static" type="checkbox" id="inlineFormCheck">
                    <label class="form-check-label pb-1 " for="inlineFormCheck">Force du vent</label>
                </div>
                <div class="form-check">
                    <input style="margin-top: 5px" class="form-check-input position-static" type="checkbox" id="inlineFormCheck">
                    <label class="form-check-label pb-1 " for="inlineFormCheck">Direction du vent</label>
                </div>
                <div class="form-check">
                    <input style="margin-top: 5px" class="form-check-input position-static" type="checkbox" id="inlineFormCheck">
                    <label class="form-check-label pb-1 " for="inlineFormCheck">Direction du vent</label>
                </div>
            </div>

            <div class="col-12">
                <button type="button" class="btn btn-primary" id="copy-btn">Générer le shortcode</button>
            </div>
        </form>
    </div>
</div>

<?php $path = plugin_dir_url(__DIR__) ?>
<script>
    var commune1 = document.getElementById("commune1");
    commune1.addEventListener("input", function(){ listCommunes(1)});
    commune1.addEventListener("change", generateShortcode);

    var copyBtn = document.getElementById("copy-btn");
    copyBtn.addEventListener("click", copyToClipboard);

    var commune2 = document.getElementById("commune2");
    commune2.addEventListener("input", function(){ listCommunes(2)});


    function listCommunes(numCommuneField) {
        var commune = document.getElementById("commune"+numCommuneField);
        if (commune.value.length > 2) {
            listeCommunes = "";
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var communes = JSON.parse(this.response);
                    let listeCommunes = document.getElementById("list-communes"+numCommuneField);
                    listeCommunes.innerHTML = "";
                    for (let i = 0; i < communes.length; i++) {
                        var option = document.createElement('option');
                        option.value = communes[i]['code_comm'] + ' - ' + communes[i]['nom_comm'];
                        listeCommunes.appendChild(option);
                    }
                }
            }
            let ajaxPath = '<?= $path ?>';
            xmlhttp.open("GET", ajaxPath + "admin/search.php?commune=" + commune.value)
            xmlhttp.send()
        }
    }

    function generateShortcode() {
        //Generer le short code
        shortcode = document.getElementById("shortcode");
        const tab = commune1.value.split(" - ");

        communeChoisie = tab[1];
        shortcode.value = '[meteo ville = "' + communeChoisie + '"]';
    }

    function copyToClipboard() {
        console.log('toto');
        var shortcode = document.getElementById("shortcode");
        /* Select the text field */
        shortcode.select();
        shortcode.setSelectionRange(0, 99999); /* For mobile devices */
        /* Copy the text inside the text field */
        navigator.clipboard.writeText(shortcode.value);
        document.getElementById("copy-msg").textContent = "copié !";
    }
</script>