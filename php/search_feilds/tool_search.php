<?php
echo '
    <h3>Tool Search</h3>
    <form id="tool-search" action="" method="POST" onKeyPress="submitOnEnter(event, `php/searchProduct.php`)">
        <div id="search-feilds">
            <input placeholder="ID" id="tool_id" value="">
            <input placeholder="Name" id="tool_name" value="">
            <input placeholder="Description" id="tool_description" value="">
        </div>
        <div id="result-feilds">
            
        </div>
    </form>';
?>
