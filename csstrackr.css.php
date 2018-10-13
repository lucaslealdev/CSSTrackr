<?php
header("Content-type: text/css");

require('config.php');

foreach($actions['click'] as $selector=>$value){?>
    <?= $selector?>:active::after {
        content: url("index.php?action=click&value=<?= urlencode($value)?>");
    }
<?php }

foreach($actions['hover'] as $selector=>$value){?>
    <?= $selector?>:hover::after {
        content: url("index.php?action=hover&value=<?= urlencode($value)?>");
    }
<?php }

foreach($actions['check'] as $selector=>$value){?>
    <?= $selector?>:checked {
        content: url("index.php?action=check&value=<?= urlencode($value)?>");
    }
<?php }
$keyframes = 0;
foreach($actions['hoverhold'] as $selector=>$value){?>
    @keyframes keyframe<?= $keyframes?> {
        0% {background-image: none;}
        10% {background-image: url("index.php?action=hover&value=<?= urlencode($value.' 1s')?>")}
        20% {background-image: url("index.php?action=hover&value=<?= urlencode($value.' 2s')?>")}
        30% {background-image: url("index.php?action=hover&value=<?= urlencode($value.' 3s')?>")}
        40% {background-image: url("index.php?action=hover&value=<?= urlencode($value.' 4s')?>")}
        50% {background-image: url("index.php?action=hover&value=<?= urlencode($value.' 5s')?>")}
        60% {background-image: url("index.php?action=hover&value=<?= urlencode($value.' 6s')?>")}
        70% {background-image: url("index.php?action=hover&value=<?= urlencode($value.' 7s')?>")}
        80% {background-image: url("index.php?action=hover&value=<?= urlencode($value.' 8s')?>")}
        90% {background-image: url("index.php?action=hover&value=<?= urlencode($value.' 9s')?>")}
        100% {background-image: url("index.php?action=hover&value=<?= urlencode($value.' 10s')?>")}
    }

    <?= $selector?>:hover {
        -moz-animation: keyframe<?= $keyframes?> 10s;
        -webkit-animation: keyframe<?= $keyframes?> 10s;
        animation: keyframe<?= $keyframes?> 10s;
        animation-name: keyframe<?= $keyframes?>;
        animation-duration: 10s;
    }
<?php
$keyframes++;
}

?>

/** http://browserhacks.com/ **/
@supports (-webkit-appearance:none) and (not (-ms-ime-align:auto)){
    body::before {
        content: url("index.php?action=browser&value=chrome");
    }
}

@supports (-moz-appearance:meterbar) {
    body::before {
        content: url("index.php?action=browser&value=firefox");
    }
}

@supports (-ms-ime-align:auto) {
    body::before {
        content: url("index.php?action=browser&value=edge")
    }
}

/** Orientation **/

@media (orientation: portrait) {
    html::after {
        content: url("index.php?action=orientation&value=portrait");
    }
}

@media (orientation: landscape) {
    html::after {
        content: url("index.php?action=orientation&value=landscape");
    }
}

/** Screen size based on boostrap 3 **/

/* xs */
@media (max-width: 767px) {
  body::after {
      content: url("index.php?action=viewport&value=xs");
  }
}

/* sm */
@media (min-width: 768px) and (max-width: 991px) {
   body::after {
       content: url("index.php?action=viewport&value=sm");
   }
}

/* md */
@media (min-width: 992px) and (max-width: 1199px) {
  body::after {
      content: url("index.php?action=viewport&value=md");
  }
}

/* lg */
@media (min-width: 1200px) and (max-width: 1920px){
  body::after {
      content: url("index.php?action=viewport&value=lg");
  }
}

/* xlg */
@media (min-width: 1921px) {
  body::after {
      content: url("index.php?action=viewport&value=xlg");
  }
}