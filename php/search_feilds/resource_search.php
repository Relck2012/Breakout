<?php
echo '
    <h3>Resource Search</h3>
    <form id="resource-search" action="" method="POST" onKeyPress="submitOnEnter(event, `php/searchProduct.php`);">
        <div id="search-feilds">
            <select id="department_name" style="float: left;">
                <option value="" selected>Department Name</option>
                <option value="Installation Services">Installation Services</option>
                <option value="Physical Security">Physical Security</option>
            </select> 
            <input placeholder="Description" id="description" value="">
            <input placeholder="Rate" id="rate" value="">
        </div>
        <div id="result-feilds">
            
        </div>
    </form>';
?>