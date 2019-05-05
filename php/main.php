<?php
//var_dump($_POST);
require 'functions.php';

$func = $_POST['dbFunction'];

if($func == 'createProduct'){
    //Insert into database
    $summary = $_POST['summary'];
    $description = $_POST['description'];
    $manf = $_POST['manf'];
    $manf_num = $_POST['manf_model'];
    $cost_price = $_POST['item_cost'];
    $sell_price = $_POST['item_sell'];

    createProduct($summary, $description, $manf, $manf_num, $cost_price, $sell_price);
    //echo "$summary <br> $description <br> $manf <br> $manf_num <br> $cost_price <br> $sell_price";
    echo "Product Created";
}
if($func == 'createService'){
    $summary = $_POST['summary'];
    $description = $_POST['description'];
    $install_time = $_POST['install_time'];
    $config_time = $_POST['config_time'];
    $charge_rate = $_POST['charge_rate'];
    $products_list = json_decode($_POST['product_list']);
    $install_by = json_decode($_POST['install_by']);
    $config_by = json_decode($_POST['config_by']);
    $tool_list = json_decode($_POST['tool_list']);

    createService($summary, $description, $install_time, $config_time, $charge_rate, $products_list, $install_by, $config_by, $tool_list);
    echo "Service Created";
}
if($func == 'createRate'){
    $summary = $_POST['summary'];
    $description = $_POST['description'];
    $name = $_POST['department'];
    $rate = $_POST['rate'];

    createResource($summary, $description, $name, $rate);
}
if($func == 'createTool'){
    $name = $_POST['name'];
    $description = $_POST['description'];

    createTool($name, $description);
}
if($func == 'update'){
    $id;
    if(isset($_POST['id'])){
        $id = $_POST['id'];
    }
    else {
        $id = $_POST['department_name'];
    }
    update($_POST['table'], $id);
}
if($func == 'delete'){
    $id;
    if(isset($_POST['id'])){
        $id = $_POST['id'];
    }
    else {
        $id = $_POST['department_name'];
    }
    delete($_POST['table'], $id);
}

?>