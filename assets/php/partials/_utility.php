<?php
session_start();
//User functions
function updtUser($id, $name, $phone, $email, $role_id)
{
    $ch = curl_init();
    $url = "https://kungadi.000webhostapp.com/Api/index.php?en=user&op=updateUser ";
    $data_array = array(
        "id" => $id,
        "name" => $name,
        "phone" => $phone,
        "email" => $email,
        "role_id" => $role_id,
    );
    $data = json_encode($data_array);
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: : application/json')

    );

    curl_setopt_array($ch, $options);
    $resp = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($resp, true);
    echo '<script>';
    echo 'alert("' . $decoded['message'] . '");';
    echo 'window.location = "' . $_SESSION['prev_url'] . '"';
    echo '</script>';
}
function promUser($id)
{
    $ch = curl_init();
    $url = "https://kungadi.000webhostapp.com/Api/index.php?en=user&op=promoteUser";
    $data_array = array(
        "id" => $id,
    );
    $data = json_encode($data_array);
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: : application/json')

    );

    curl_setopt_array($ch, $options);
    $resp = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($resp, true);
    echo '<script>';
    echo 'alert("' . $decoded['message'] . '");';
    echo 'window.location = "' . $_SESSION['prev_url'] . '"';
    echo '</script>';
}

function deltUser($id)
{
    $ch = curl_init();
    $url = "https://kungadi.000webhostapp.com/Api/index.php?en=user&op=deleteUser ";
    $data_array = array(
        "id" => $id,
    );
    $data = json_encode($data_array);
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: : application/json')

    );

    curl_setopt_array($ch, $options);
    $resp = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($resp, true);
    echo '<script>';
    echo 'alert("' . $decoded['message'] . '");';
    echo 'window.location = "' . $_SESSION['prev_url'] . '"';
    echo '</script>';
}

//Node functions

function createNode($name, $lat, $lng)
{
    $coordinates = $lat . ", " . $lng;
    $ch = curl_init();
    $url = "https://kungadi.000webhostapp.com/Api/index.php?en=node&op=addNode";
    $data_array = array(
        "name" => $name,
        "coordinates" => $coordinates
    );
    $data = json_encode($data_array);
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: : application/json')
    );

    curl_setopt_array($ch, $options);
    $resp = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($resp, true);
    echo '<script>';
    echo 'alert("' . $decoded['message'] . '");';
    echo 'window.location = "' . $_SESSION['prev_url'] . '"';
    echo '</script>';
}


function updtNode($id, $name, $longitude, $latitude)
{
    $ch = curl_init();
    $url = "https://kungadi.000webhostapp.com/Api/index.php?en=node&op=updateNode";
    $data_array = array(
        "id" => $id,
        "name" => $name,
        "longitude" => $latitude,
        "latitude" => $longitude
    );
    $data = json_encode($data_array);
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: : application/json')
    );

    curl_setopt_array($ch, $options);
    $resp = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($resp, true);
    echo '<script>';
    echo 'alert("' . $decoded['message'] . '");';
    echo 'window.location = "' . $_SESSION['prev_url'] . '"';
    echo '</script>';
}

function deltNode($id)
{
    $ch = curl_init();
    $url = "https://kungadi.000webhostapp.com/Api/index.php?en=node&op=deleteNode ";
    $data_array = array(
        "id" => $id,
    );
    $data = json_encode($data_array);
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: : application/json')

    );

    curl_setopt_array($ch, $options);
    $resp = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($resp, true);
    echo '<script>';
    echo 'alert("' . $decoded['message'] . '");';
    echo 'window.location = "' . $_SESSION['prev_url'] . '"';
    echo '</script>';
}

//Route Function
function updtRoute($id)
{
    echo $id;
}

function deltRoute($id)
{
    $ch = curl_init();
    $url = "https://kungadi.000webhostapp.com/Api/index.php?en=routes&op=deleteRoute";
    $data_array = array(
        "id" => $id,
    );
    $data = json_encode($data_array);
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: : application/json')
    );

    curl_setopt_array($ch, $options);
    $resp = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($resp, true);
    echo '<script>';
    echo 'alert("' . $decoded['message'] . '");';
    echo 'window.location = "' . $_SESSION['prev_url'] . '"';
    echo '</script>';
}

//Node Request
function apprNode($id, $cid, $sid)
{
    if ($sid == 1) {
        echo '<script>';
        echo 'alert("Already Approved");';
        echo 'window.location = "' . $_SESSION['prev_url'] . '"';
        echo '</script>';
    } else {
        $ch = curl_init();
        $url = "https://kungadi.000webhostapp.com/Api/index.php?en=contribute_node&op=acceptContribution ";
        $data_array = array(
            "id" => $id,
            "coordinate_id" => $cid
        );
        $data = json_encode($data_array);
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-Type: : application/json')

        );

        curl_setopt_array($ch, $options);
        $resp = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($resp, true);
        echo '<script>';
        echo 'alert("' . $decoded['message'] . '");';
        echo 'window.location = "' . $_SESSION['prev_url'] . '"';
        echo '</script>';
    }
}
function deltNReq($id)
{
    $ch = curl_init();
    $url = "https://kungadi.000webhostapp.com/Api/index.php?en=contribute_node&op=deleteContribution ";
    $data_array = array(
        "id" => $id,
    );
    $data = json_encode($data_array);
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: : application/json')

    );

    curl_setopt_array($ch, $options);
    $resp = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($resp, true);
    echo '<script>';
    echo 'alert("' . $decoded['message'] . '");';
    echo 'window.location = "' . $_SESSION['prev_url'] . '"';
    echo '</script>';
}


//Route Request deleteContribution
function updtRRoute($id, $rid)
{
    $ch = curl_init();
    $url = "https://kungadi.000webhostapp.com/Api/index.php?en=contribute_route&op=acceptContribution";
    $data_array = array(
        "id" => $id,
        "route_id" => $rid
    );
    $data = json_encode($data_array);
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: : application/json')

    );

    curl_setopt_array($ch, $options);
    $resp = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($resp, true);
    echo '<script>';
    echo 'alert("' . $decoded['message'] . '");';
    echo 'window.location = "' . $_SESSION['prev_url'] . '"';
    echo '</script>';
}
function deltRRoute($id)
{
    //    deleteContribution
    $ch = curl_init();
    $url = "https://kungadi.000webhostapp.com/Api/index.php?en=contribute_route&op=deleteContribution";
    $data_array = array(
        "id" => $id
    );
    $data = json_encode($data_array);
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: : application/json')

    );

    curl_setopt_array($ch, $options);
    $resp = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($resp, true);
    echo '<script>';
    echo 'alert("' . $decoded['message'] . '");';
    echo 'window.location = "' . $_SESSION['prev_url'] . '"';
    echo '</script>';
}
