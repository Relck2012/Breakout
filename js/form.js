var product_ids = [];
var install_resources = [];
var config_resources = [];
var tool_ids = [];

var searchResults;
var insert;

function changeSearch(html, insert){
    this.insert = insert;
    $("#search").attr("src", html);
    if(html == 'product-search.html'){
        $("h3").html("Product Search");
    }
    else if(html == 'resource_search.html'){
        $("h3").html("Resource Search");
    }
}

function remove(element){
    if($(element).parent('#products').length){
        product_ids.splice(($(element).index() - 2), 1);
    }
    else if($(element).parent('#resource-install').length){
        install_resources.splice(($(element).index() - 2), 1);
    }
    else if($(element).parent('#resource-config').length){
        config_resources.splice(($(element).index() - 2), 1);
    }
    else if($(element).parent('#tools').length){
        tool_ids.splice(($(element).index() - 2), 1);
    }
    $(element).remove();
    if($("#" + insert + " li").length < 2){
        $("#" + insert + " li:first").nextAll().remove();
    }
}

function createService(){
    var xhttp;
    var str = "dbFunction=createService&";

    //loop through products and get qt
    $('#products li div .qt input').each(function(index){
        product_ids[index].push($(this).val());
    });
    $('#resource-install li div .qt input').each(function(index){
        install_resources[index].push($(this).val());
    });
    $('#resource-config li div .qt input').each(function(index){
        config_resources[index].push($(this).val());
    });
    $('#tools li div .qt input').each(function(index){
        tool_ids[index].push($(this).val());
    });

    var form = document.forms[0]
    
    var summary = form.summary.value;
    var description = form.description.value;
    var install_time = ""; //calculate install time based off install and config times
    var config_time = ""; //same with config
    var charge_rate = ""; //could also be calculated with an algorithm

    str += `summary=` + summary 
    str += `&description=` + description;
    str += `&install_time=` + install_time;
    str += `&config_time=` + config_time;
    str += `&charge_rate=` + charge_rate;
    str += `&product_list=` + JSON.stringify(product_ids);
    str += `&install_by=` + JSON.stringify(install_resources); 
    str += `&config_by=` + JSON.stringify(config_resources);
    str += `&tool_list=` + JSON.stringify(tool_ids);

    console.log(JSON.stringify(product_ids));

    if (str != "") {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                $('body').replaceWith(this.responseText);
            }
        };
        xhttp.open("POST", "../php/main.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(str);
    }

    return false;
}

//In order to serialize list items for a service
function index(){
    $("#products li ").each(function(index){
        $(this).find('input[name="product_id"]').attr("name","product_id[" + (index-1) + "]");
        $(this).find('input[name="product_quantity"]').attr("name","product_quantity[" + (index-1) + "]");
    });
    $("#resource-install li").each(function(index){
        $(this).find('input[name="install_name"]').attr("name","install_name[" + (index-1) + "]");
        $(this).find('input[name="install_rate"]').attr("name","install_rate[" + (index-1) + "]");
        $(this).find('input[name="install_quantity"]').attr("name","install_quantity[" + (index-1) + "]");
    });
    $("#resource-config li").each(function(index){
        $(this).find("input[name='config_name']").attr("name","config_name[" + (index-1) + "]");
        $(this).find("input[name='config_rate']").attr("name","config_rate[" + (index-1) + "]");
        $(this).find("input[name='config_quantity']").attr("name","config_quantity[" + (index-1) + "]");
    });
    $("#tools li").each(function(index){
        $(this).find("input[name='tool_id']").attr("name","tool_id[" + (index-1) + "]");
        $(this).find("input[name='tool_quantity']").attr("name","tool_quantity[" + (index-1) + "]");
    });
}