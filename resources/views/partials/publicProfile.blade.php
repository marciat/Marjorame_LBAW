<main role="main" class="col-12 col-md-10 profile_content">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2><?= $user->first_name ?>'s Profile</h2>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="ml-3">
            <h4><?= $user->first_name ?> <?= $user->last_name ?> </h4>
          </div>
        </div>
        <div class="row ml-3">
          <?php if (strcmp($country->name, 'Portugal') == 0) { ?>
            <i class="pt flag-pt flag mt-2"></i>
          <?php } else  if (strcmp($country->name, 'Italy') == 0) { ?>
            <i class="it flag-it flag mt-2"></i>
          <?php } else if (strcmp($country->name, 'Germany') == 0) { ?>
            <i class="de flag-de flag mt-2"></i>
          <?php } else if (strcmp($country->name, 'Netherlands') == 0) { ?>
            <i class="nl flag-nl flag mt-2"></i>
          <?php } else if (strcmp($country->name, 'Spain') == 0) { ?>
            <i class="es flag-es flag mt-2"></i>
          <?php } else if (strcmp($country->name, 'France') == 0) { ?>
            <i class="fr flag-fr flag mt-2"></i>
          <?php }  ?>
          <a class="public_profile_information">
            <?php
            if ($country != null)
              echo $country->name;
            ?>

          </a>
        </div>
        <h4 class="mb-3 mt-5">Contact Information:</h4>
        <div class="row ml-3">
          <a class="public_profile_subtitle"> E-mail: </a>
          <a class="public_profile_information ml-1"><?= $user->email ?></a>
        </div>
        <div class="row ml-3">
          <a class="public_profile_subtitle"> Phone Number: </a>
          <a class="public_profile_information ml-1"><?= $buyer->phone_number ?></a>
        </div>
      </div>
    </div>
  </div>

</main>
</div>