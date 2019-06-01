<?php
function getRequestIP(){
    return (isset($_SERVER['HTTP_CF_CONNECTING_IP']))? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];
}