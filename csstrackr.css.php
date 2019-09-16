<?php
declare(strict_types=1);
header("Content-type: text/css");

require('config.php');
require('functions.php');

/*get real user IP*/
$_SERVER['REMOTE_ADDR'] = getRequestIP();

if(isset($_SERVER['HTTP_USER_AGENT']) && in_array(strtolower($_SERVER['HTTP_USER_AGENT']),$banned_agents)){
  echo "/*blocked agent*/";
  exit;
}else if (in_array($_SERVER['REMOTE_ADDR'],$banned_ips)){
  echo "/*blocked ip*/";
  exit;
} else {
  foreach($banned_ips as $ip) {
    if($ip==substr($_SERVER['REMOTE_ADDR'], 0,strlen($ip))){
      echo "/*blocked ip by like*/";
      exit;
    }
  }
}

if (!isset($actions)){
  echo "/*no actions*/";
  exit;
}

if (isset($actions['click']) && !empty($actions['click'])){
  foreach($actions['click'] as $selector=>$value){?>
  /* <style> */
    <?= $selector?>:active::after {
        content: url("index.php?action=click&value=<?= urlencode($value)?>");
        display: inline-block;
        position: absolute;
        top: 0px;
        left: 0px;
        margin: 0px;
        width: 0px;
        height: 0px;
        padding: 0px;
    }
<?php }
}

if (isset($actions['hover']) && !empty($actions['hover'])){
  foreach($actions['hover'] as $selector=>$value){?>
    <?= $selector?>:hover::before {
        content: url("index.php?action=hover&value=<?= urlencode($value)?>");
        display: inline-block;
        position: absolute;
        top: 0px;
        left: 0px;
        margin: 0px;
        width: 0px;
        height: 0px;
        padding: 0px;
    }
<?php }
}

if (isset($actions['check']) && !empty($actions['check'])){
  foreach($actions['check'] as $selector=>$value){?>
    <?= $selector?>:checked {
        content: url("index.php?action=check&value=<?= urlencode($value)?>");
        display: block;
        margin: 0px;
        width: 0px;
        height: 0px;
        padding: 0px;
    }
<?php }
}



$keyframes = 0;
if (isset($actions['hoverhold']) && !empty($actions['hoverhold'])){
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
}

?>
/** http://browserhacks.com/ **/
@supports (-webkit-appearance:none) and (not (-ms-ime-align:auto)){
    body::before {
        content: "";
        -moz-animation: keyframeCHROME 10s;
        -webkit-animation: keyframeCHROME 10s;
        animation: keyframeCHROME 10s;
        animation-name: keyframeCHROME;
        animation-duration: 10s;
        display: block;
        margin: 0px;
        width: 0px;
        height: 0px;
        padding: 0px;
    }
    @keyframes keyframeCHROME {
        0% {background-image: none;}
        10% {background-image: url("index.php?action=browser&value=chrome")}
        20% {background-image: none}
        30% {background-image: none}
        40% {background-image: none}
        50% {background-image: none}
        60% {background-image: none}
        70% {background-image: none}
        80% {background-image: none}
        90% {background-image: none}
        100% {background-image: none}
    }
}

@media screen and (min--moz-device-pixel-ratio:0) {
    body::before {
        content: "";
        -moz-animation: keyframeFIREFOX 10s;
        -webkit-animation: keyframeFIREFOX 10s;
        animation: keyframeFIREFOX 10s;
        animation-name: keyframeFIREFOX;
        animation-duration: 10s;
        display: block;
        margin: 0px;
        width: 0px;
        height: 0px;
        padding: 0px;
    }
    @keyframes keyframeFIREFOX {
        0% {background-image: none;}
        10% {background-image: url("index.php?action=browser&value=firefox")}
        20% {background-image: none}
        30% {background-image: none}
        40% {background-image: none}
        50% {background-image: none}
        60% {background-image: none}
        70% {background-image: none}
        80% {background-image: none}
        90% {background-image: none}
        100% {background-image: none}
    }
}

@supports (-ms-ime-align:auto) {
    body::before {
        content: "";
        -moz-animation: keyframeEDGE 10s;
        -webkit-animation: keyframeEDGE 10s;
        animation: keyframeEDGE 10s;
        animation-name: keyframeEDGE;
        animation-duration: 10s;
        display: block;
        margin: 0px;
        width: 0px;
        height: 0px;
        padding: 0px;
    }
    @keyframes keyframeEDGE {
        0% {background-image: none;}
        10% {background-image: url("index.php?action=browser&value=edge")}
        20% {background-image: none}
        30% {background-image: none}
        40% {background-image: none}
        50% {background-image: none}
        60% {background-image: none}
        70% {background-image: none}
        80% {background-image: none}
        90% {background-image: none}
        100% {background-image: none}
    }
}

/** Orientation **/

@media (orientation: portrait) {
    html::after {
        content: "";
        -moz-animation: keyframePORTRAIT 10s;
        -webkit-animation: keyframePORTRAIT 10s;
        animation: keyframePORTRAIT 10s;
        animation-name: keyframePORTRAIT;
        animation-duration: 10s;
        display: block;
        margin: 0px;
        width: 0px;
        height: 0px;
        padding: 0px;
    }
    @keyframes keyframePORTRAIT {
        0% {background-image: none;}
        10% {background-image: none}
        20% {background-image: none}
        30% {background-image: none}
        40% {background-image: none}
        50% {background-image: url("index.php?action=orientation&value=portrait")}
        60% {background-image: none}
        70% {background-image: none}
        80% {background-image: none}
        90% {background-image: none}
        100% {background-image: none}
    }
}

@media (orientation: landscape) {
    html::after {
        content: "";
        -moz-animation: keyframeLANDSCAPE 10s;
        -webkit-animation: keyframeLANDSCAPE 10s;
        animation: keyframeLANDSCAPE 10s;
        animation-name: keyframeLANDSCAPE;
        animation-duration: 10s;
        display: block;
        margin: 0px;
        width: 0px;
        height: 0px;
        padding: 0px;
    }
    @keyframes keyframeLANDSCAPE {
        0% {background-image: none;}
        10% {background-image: none}
        20% {background-image: none}
        30% {background-image: none}
        40% {background-image: none}
        50% {background-image: url("index.php?action=orientation&value=landscape")}
        60% {background-image: none}
        70% {background-image: none}
        80% {background-image: none}
        90% {background-image: none}
        100% {background-image: none}
    }
}

/** Screen size based on boostrap 3 **/

/* xs */
@media (max-width: 767px) {
  body::after {
      content: "";
      -moz-animation: keyframeWIDTH 10s;
      -webkit-animation: keyframeWIDTH 10s;
      animation: keyframeWIDTH 10s;
      animation-name: keyframeWIDTH;
      animation-duration: 10s;
      display: block;
      margin: 0px;
      width: 0px;
      height: 0px;
      padding: 0px;
  }
  @keyframes keyframeWIDTH {
      0% {background-image: none;}
      10% {background-image: none}
      20% {background-image: none}
      30% {background-image: none}
      40% {background-image: none}
      50% {background-image: none}
      60% {background-image: none}
      70% {background-image: none}
      80% {background-image: none}
      90% {background-image: none}
      100% {background-image: url("index.php?action=viewport&value=xs")}
  }
}

/* sm */
@media (min-width: 768px) and (max-width: 991px) {
   body::after {
       content: "";
       -moz-animation: keyframeWIDTH 10s;
       -webkit-animation: keyframeWIDTH 10s;
       animation: keyframeWIDTH 10s;
       animation-name: keyframeWIDTH;
       animation-duration: 10s;
       display: block;
       margin: 0px;
       width: 0px;
       height: 0px;
       padding: 0px;
   }
   @keyframes keyframeWIDTH {
       0% {background-image: none;}
       10% {background-image: none}
       20% {background-image: none}
       30% {background-image: none}
       40% {background-image: none}
       50% {background-image: none}
       60% {background-image: none}
       70% {background-image: none}
       80% {background-image: none}
       90% {background-image: none}
       100% {background-image: url("index.php?action=viewport&value=sm")}
   }
}

/* md */
@media (min-width: 992px) and (max-width: 1199px) {
  body::after {
      content: "";
      -moz-animation: keyframeWIDTH 10s;
      -webkit-animation: keyframeWIDTH 10s;
      animation: keyframeWIDTH 10s;
      animation-name: keyframeWIDTH;
      animation-duration: 10s;
      display: block;
      margin: 0px;
      width: 0px;
      height: 0px;
      padding: 0px;
  }
  @keyframes keyframeWIDTH {
      0% {background-image: none;}
      10% {background-image: none}
      20% {background-image: none}
      30% {background-image: none}
      40% {background-image: none}
      50% {background-image: none}
      60% {background-image: none}
      70% {background-image: none}
      80% {background-image: none}
      90% {background-image: none}
      100% {background-image: url("index.php?action=viewport&value=md")}
  }
}

/* lg */
@media (min-width: 1200px) and (max-width: 1920px){
  body::after {
      content: "";
      -moz-animation: keyframeWIDTH 10s;
      -webkit-animation: keyframeWIDTH 10s;
      animation: keyframeWIDTH 10s;
      animation-name: keyframeWIDTH;
      animation-duration: 10s;
      display: block;
      margin: 0px;
      width: 0px;
      height: 0px;
      padding: 0px;
  }
  @keyframes keyframeWIDTH {
      0% {background-image: none;}
      10% {background-image: none}
      20% {background-image: none}
      30% {background-image: none}
      40% {background-image: none}
      50% {background-image: none}
      60% {background-image: none}
      70% {background-image: none}
      80% {background-image: none}
      90% {background-image: none}
      100% {background-image: url("index.php?action=viewport&value=lg")}
  }
}

/* xlg */
@media (min-width: 1921px) {
  body::after {
      content: "";
      -moz-animation: keyframeWIDTH 10s;
      -webkit-animation: keyframeWIDTH 10s;
      animation: keyframeWIDTH 10s;
      animation-name: keyframeWIDTH;
      animation-duration: 10s;
      display: block;
      margin: 0px;
      width: 0px;
      height: 0px;
      padding: 0px;
  }
  @keyframes keyframeWIDTH {
      0% {background-image: none;}
      10% {background-image: none}
      20% {background-image: none}
      30% {background-image: none}
      40% {background-image: none}
      50% {background-image: none}
      60% {background-image: none}
      70% {background-image: none}
      80% {background-image: none}
      90% {background-image: none}
      100% {background-image: url("index.php?action=viewport&value=xlg")}
  }
}
