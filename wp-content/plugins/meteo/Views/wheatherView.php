<?php
ob_start();
?>

<div class="wrap" id="meteo-card" style="all:initial">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100" style="color: #282828;">
        <div class="col-md-9 col-lg-7 col-xl-5">
          <div class="card mb-4 gradient-custom" style="border-radius: 25px;">
            <div class="card-body p-4">            
                <div class="d-flex justify-content-between mb-4 pb-2">
                  <div>
                    <h4 class="display-2"><strong> <?= round($tmp)?>°C </strong></h4>
                    <p class="text-muted fs-2 mb-0"><?= $atts ?></p>
                    <p class="text-muted fs-2 mb-0"><?= $desc ?></p>
                  </div>
                  <div>
                    <img src=" <?= $url_icon ?>" alt="" width="150px">
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<?php
$html = ob_get_clean();
?>