<?php
setlocale (LC_TIME, 'fr_FR.utf8','fra');
ob_start();
?>

<!-- ob start 
ici la vue qui affiche la météo en utilisant le shortcode détaillé-->

<style>
  .gradient-custom {
    /* fallback for old browsers */
    background: #ffffff;

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right, rgba(255, 255, 255, 1), rgba(255, 236, 210, 1));

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right, rgba(255, 255, 255, 1), rgba(255, 236, 210, 1))
  }
  #thumb-day{
    background-color: rgba(235, 218 , 195, 1);
    border-radius: 25px;
  }

</style>
<div class="wrap" id="meteo-forecast" style="all:initial">

  <section class="vh-100" style="background-color: #C1CFEA;">
    <div class="container py-5 h-100">

      <div class="row d-flex justify-content-center align-items-center h-100" style="color: #282828;">
        <div class="col-md-9 col-lg-7 col-xl-5">

          <div class="card mb-4 gradient-custom" style="border-radius: 25px;">
            <div class="card-body p-4">

              <div id="demo1" class="carousel slide" data-ride="carousel">

                <!-- Carousel inner -->
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <div class="d-flex justify-content-between mb-4 pb-2">
                      <div>
                        <h2 class="display-2"><strong><?= round($tmp) ?>°C</strong></h2>
                        <p class="text-muted mb-0"><?= $atts ?></p>
                        <p class="text-muted fs-2 mb-0"><?= $desc ?></p>
                        <p><?=ucfirst(strftime("%a - %R",$datas['list'][0]['dt']))?></p>

                      </div>
                      <div>
                        <img src=" <?= $url_icon ?>" alt="" width="150px">
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <div id="demo3" class="carousel slide" data-ride="carousel">

                <!-- Carousel inner -->
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <div class="d-flex justify-content-around text-center mb-4 pb-3 pt-2">
                      <?php                      
                      for ($i=12; $i < 37; $i+=8) { 
                        ?>
                        <div class="flex-column" id="thumb-day">
                        <p class="small"><strong><?=round($datas['list'][$i]['main']['temp'])?>°C</strong></p>
                        
                        <img src=" <?="http://openweathermap.org/img/wn/" . $datas['list'][$i]['weather'][0]['icon'] . "@2x.png" ?>" alt="<?=$datas['list'][$i]['weather'][0]['description'];?>" title="<?=$datas['list'][$i]['weather'][0]['description'];?>">
                        <p class="mb-0"><strong><?=ucfirst(strftime("%a",$datas['list'][$i]['dt']))?></strong></p>
                      </div>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
$html = ob_get_clean();
?>