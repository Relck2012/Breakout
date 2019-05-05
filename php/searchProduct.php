<?php
    require '../../../connections/db_connection.php';
    //$conn = new mysqli('localhost', 'root', '' , 'breakout_manager') or die("Connect failed: %s\n". $conn -> error);
    $sql = "";
    $conditions = "";
    if(sizeof($_POST) == 1){
        $sql="SELECT * FROM " .$_POST["search"];
    }
    else if($_POST["search"] == "service"){
        $sql="SELECT * FROM " .$_POST["search"];
        $sql.=" INNER JOIN product_list ON product_list.service_id=service.service_id";
        if(isset($_POST['id']) || isset($_POST['summary']) || isset($_POST['description'])){
            $sql.=" WHERE ";
        }
        $a = 0;
        foreach($_POST as $key => $value){
            if($key != 'search'){
                if($a == sizeof($_POST) - 1){
                    if(isset($_POST['product_id'])){
                        $conditions .= " GROUP BY service.service_id";
                        $conditions .= " HAVING COUNT(service.service_id) >= ".$value;
                    }
                    else{
                        $conditions .= "`" .$key. "` LIKE '" .$value. "'";
                    }
                }
                else{
                    $conditions .= "`" .$key. "` LIKE '" .$value. "' AND ";
                }
            }
            $a++;
        }
        $sql .= $conditions;
        //echo $sql;
    }
    else{
        $sql="SELECT * FROM " .$_POST["search"]. " WHERE ";
        $a = 0;
        foreach($_POST as $key => $value){
            if($key != 'search'){
                if($a == sizeof($_POST) - 1){
                    $conditions .= "`" .$key. "` LIKE '" .$value. "'";
                }
                else{
                    $conditions .= "`" .$key. "` LIKE '" .$value. "' AND ";
                }
            }
            $a++;
        }
        $sql .= $conditions;
    }
    
    $result = $db_con->query($sql);
    $json = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($json, $row);
    }
    echo json_encode(utf8ize($json));
    $db_con->close();

    function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }
?>