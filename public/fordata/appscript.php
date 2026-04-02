<?php

    header("Content-Type: application/javascript");
    
    $options = array(
        CURLOPT_RETURNTRANSFER => false,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120,    // time-out on response
    ); 

    $ch = curl_init("https://script.google.com/macros/s/AKfycbwP170icSsellUP5Lghpk_8idMoXGFUO496kRzvaR9h9OO_xY8IA0RWJbSxLGgP0kvz/exec?callback=antiredir&nim=".$_GET['nim']."&ultah=".$_GET['ultah']."&exportnim=".urlencode($_GET['exportnim'])."&anakmana=".$_GET['anakmana']);
    
    curl_setopt_array($ch, $options);

    $content  = curl_exec($ch);

    curl_close($ch);
?>