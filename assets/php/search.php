<?php
require_once 'partials/_curl.php';
$from = $_GET['frm']??null;
$to = $_GET['to']??null;


if(is_null($from) || is_null($to)){
    var_dump($from);
    echo "Missing parameter";
    return false;
}

$result =  search($from, $to);
if(!isset($result)){
    echo "Internal Server error";
    return false;
}

$result =  json_decode($result, true);
if($result['code']==400 || $result['code']== 404){
    echo "Error 404: Could not determine path";
    return false;

}
if($result['code']==500 || $result['code']== 502){
    echo "Error 500: Something went wrong. Try again";
    return false;
}
if($result['code']==200){
    $message = $result['message'];
    loadView($message);
}

function search ($from, $to): bool|string
{
    $param = array(
        'start'=>$from,
        'end'=>$to
    );
    $curl =  new CURL('routes', 'byFromAndTo', $param );
    $curl->ready();
    return $curl->execute();
}

function loadView($message){
?>
<?php
include_once 'partials/header_1.php'; ?>
<title>Search Result</title>
<?php
include_once 'partials/header_2.php' ?>
<?php
include_once 'partials/nav.php'; ?>
    <p class="hidden" id="hiddenP">
        <?php
        echo (json_encode($message));
        ?>
    </p>
    <section style="width: 70%; margin: 10vh auto;" id="searchResults">
        <h3 id="showMsg"></h3>
        <div id="map">

        </div>
    </section>

<?php
    echo "</body>";
    echo "<script src = '../js/search.js'></script>";
    echo '
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8pwb7nZMZCjhAwzTqBSvO1bWEa-NY0DE&callback=initMap&v=weekly"
        defer>
    </script>' ?>
    <?php
    include_once 'partials/adminFooter.php';
}