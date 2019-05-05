<?php
    require '../../../connections/db_connection.php';
    
    function createProduct($summary, $description, $manf, $manf_num, $cost_price, $sell_price){
        global $db_con;
        $sql = "INSERT INTO product (summary, description, manufacture, model_num, buy_for, sell_for)
                VALUES ('$summary', '$description', '$manf', '$manf_num', '$cost_price', '$sell_price')";

        if ($db_con->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $db_con->error;
        }
    }
    
    function createService($summary, $description, $install_time, $config_time, $charge_rate, $product_list, $install_by, $config_by, $tool_list){
        global $db_con;
        $sql_product = "INSERT INTO product_list (service_id, product_id, quantity)
                        VALUES ";
        $sql_install = "INSERT INTO install_by (service_id, depart_name, depart_rate, quantity)
                        VALUES ";
        $sql_config = "INSERT INTO config_by (service_id, depart_name, depart_rate, quantity)
                       VALUES ";
        $sql_tool = "INSERT INTO tools_list (service_id, tool_id, quantity)
                     VALUES ";
        $sql_service = "INSERT INTO service (summary, description, install_time, config_time, charge_rate)
                        VALUES ('$summary', '$description', '$install_time', '$config_time', '$charge_rate')";
        
        $last_id;
        if ($db_con->query($sql_service) === TRUE) {
            $last_id = $db_con->insert_id;
        }
        else {
            echo "Error: " . $sql_service . "<br>" . $db_con->error;
        }

        //Create product_list
        $value = "";
        for($i = 0; $i < sizeof($product_list); $i++){
            $product_id = $product_list[$i][0];
            $quantity = $product_list[$i][1];
            $value .= "('$last_id', '$product_id', '$quantity'), ";
        }
        submitSql(substr($sql_product . $value, 0, -2), "Produt_List");

        //Create install_by
        $value = "";
        for($i = 0; $i < sizeof($install_by); $i++){
            $department = $install_by[$i][0];
            $rate = $install_by[$i][1];
            $quantity = $install_by[$i][2];
            $value .= "('$last_id', '$department', '$rate', '$quantity'), ";
        }
        submitSql(substr($sql_install . $value, 0, -2), "Install_By");

        //Create config_by
        $value = "";
        for($i = 0; $i < sizeof($config_by); $i++){
            $department = $config_by[$i][0];
            $rate = $config_by[$i][1];
            $quantity = $config_by[$i][2];
            $value .= "('$last_id', '$department', '$rate', '$quantity'), ";
        }
        submitSql(substr($sql_config . $value, 0, -2), "Config_By");

        //Create tool_list
        $value = "";
        for($i = 0; $i < sizeof($tool_list); $i++){
            $product_id = $tool_list[$i][0];
            $quantity = $tool_list[$i][1];
            $value .= "('$last_id', '$product_id', '$quantity'), ";
        }
        submitSql(substr($sql_tool . $value, 0, -2), "Tool_List");
        
    }

    function createResource($summary, $description, $name, $rate){
        global $db_con;
        $sql = "INSERT INTO technician (summary, description, department_name, rate)
                VALUES ('$summary', '$description', '$name', '$rate')";

        if ($db_con->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $db_con->error;
        }
    }

    function createTool($name, $description){
        global $db_con;
        $sql = "INSERT INTO tool (name, description)
                VALUES ('$name', '$description')";

        if ($db_con->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $db_con->error;
        }
    }

    function submitSql($sql, $string){
        global $db_con;
        if ($db_con->query($sql) === TRUE) {
            echo $string;
        }
        else {
            echo "Error: " . $sql . "<br>" . $db_con->error;
        }
    }

    function delete($table, $id){
        $sql;
        if(!isset($_POST['rate'])){
            if($table = 'service'){
                $sql="DELETE FROM ".$table." WHERE service_id=".$id;
            }
            else{
                $sql="DELETE FROM ".$table." WHERE id=".$id;
            }
        }
        else{
            $sql="DELETE FROM ".$table." WHERE department_name='".$id."' AND rate=".$_POST['rate'];
        }
        submitSql($sql, "Item Deleted Successfully");
    }

    function update($table, $id){
        global $db_con;
        //Get data from server and store it in an array
        $sql = "";
        $data = array();
        $condition;
        if($table == "service"){
            //Delete arrays from coresponding tables
            $sql = "DELETE FROM product_list WHERE service_id=".$id.";";
            $db_con->query($sql);
            $sql = "DELETE FROM tools_list WHERE service_id=".$id.";";
            $db_con->query($sql);
            $sql = "DELETE FROM config_by WHERE service_id=".$id.";";
            $db_con->query($sql);
            $sql = "DELETE FROM install_by WHERE service_id=".$id.";";
            $db_con->query($sql);
            //echo $sql;

            //Add updated array to coresponding tables
            $sql = "INSERT INTO product_list(service_id, product_id, quantity) VALUES ";
            if(isset($_POST['product_id'])){
                foreach($_POST['product_id'] as $key=>$value){
                    $sql.="(".$_POST['id'].", ".$value.", ".$_POST["product_quantity"][$key]."), ";
                }
                $sql = substr(trim($sql), 0, -1);
                $db_con->query($sql);
                //echo $sql;
            }
            
            
            if(isset($_POST['tool_id'])){
                $sql = "INSERT INTO tools_list(service_id, tool_id, quantity) VALUES "; 
                foreach($_POST['tool_id'] as $key=>$value){
                    $sql.="(".$_POST['id'].", ".$value.", ".$_POST["tool_quantity"][$key]."), ";
                }
                $sql = substr(trim($sql), 0, -1);
                $db_con->query($sql);
                //echo $sql;
            }
            
            if(isset($_POST['install_name'])){
                $sql = "INSERT INTO install_by(service_id, depart_name, depart_rate, quantity) VALUES "; 
                foreach($_POST['install_name'] as $key=>$value){
                    $sql.="('".$_POST['id']."','".$value."','".$_POST['install_rate'][$key]."','".$_POST['install_quantity'][$key]."'), ";
                }
                $sql = substr(trim($sql), 0, -1);
                $db_con->query($sql);
                //echo $sql;
            }
            
            if(isset($_POST['config_name'])){
                //print_r($_POST['install_name']);
                $sql = "INSERT INTO config_by(service_id, depart_name, depart_rate, quantity) VALUES "; 
                foreach($_POST['config_name'] as $key=>$value){
                    $sql.="('".$_POST['id']."','".$value."','".$_POST['config_rate'][$key]."','".$_POST['config_quantity'][$key]."'), ";
                }
                $sql = substr(trim($sql), 0, -1);
                $db_con->query($sql);
                //echo $sql;
            }
            
            
            //Update Service with variables
            $sql = "UPDATE service SET summary='".$_POST['summary']."', description='".$_POST['description']."'";
            submitSql($sql, "Updated Successfully");
            //echo $sql;
        }
        else{
            if(!isset($_POST['rate'])){
                $condition = " WHERE id=".$id;
                $sql .= "SELECT * FROM ".$table.$condition;
                $result = $db_con->query($sql);
                
                while($row = mysqli_fetch_assoc($result)){
                    array_push($data, $row);
                }
            }
            else{
                $condition = " WHERE department_name='".$id."' AND rate=".$_POST['i_rate'];
                $sql .= "SELECT * FROM ".$table.$condition;
                $result = $db_con->query($sql);
                while($row = mysqli_fetch_assoc($result)){
                    array_push($data, $row);
                }
            }
    
            //Compare global values with array
            //Loop though each entry and compare it with $data
            //If $data != entry put it in the update queue
            
            $update = " SET ";
            foreach($_POST as $key => $value){
                if(isset($data[0][$key])){
                    //echo $data[0][$key]. "</br>";
                    if($data[0][$key] !== $value){
                        $update .= $key."= '".$value."', ";
                        //echo bin2hex($data[0][$key])."</br>".bin2hex($value);
                    }
                }
            }
            $update = substr(trim($update), 0, -1);
            $sql = "UPDATE ".$table. " " .$update.$condition;
            submitSql($sql, "Updated Successfully");
        }
        
        
    }
        
?>