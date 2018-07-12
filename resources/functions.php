<?php

//Helper functions
function redirect($location){
    header("Location: $location ");

}

function query($sql){

    global $connection;
    return mysqli_query($connection, $sql);
}

function confirm($result){

    global $connection;
    if(!$result){
        die("QUERY FAILED " . mysqli_error($connection));
    }
}

//This function will save us from SQL injection
function escape_string($string){

    global $connection;
    return mysqli_real_escape_string($connection, $string);
}


function fetch_array($result){

    return mysqli_fetch_array($result);
}


/*****************************FRONT END FUNCTIONS***********************************/
//get products

function get_products(){
    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)){

        $product = <<<DELIMETER
        
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
            <a href="item.php?id={$row['prod_id']}"><img src="{$row['prod_image']}" alt=""></a>
                <div class="caption">
                    <h4 class="pull-right">&#8360;{$row['prod_price']}</h4>
                    <h4><a href="item.php?id={$row['prod_id']}">{$row['prod_title']}</a>
                    </h4>
                    <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                    <a class="btn btn-primary" target="_blank" href="item.php?id={$row['prod_id']}">Add to Cart</a>
                </div>
            </div>
        </div>

DELIMETER;
    echo $product;

    }
}
//Agar hamne massive amount of strings ko under php tag echo karana ho tu ham DELIMETER ka use karte hain so hame us string main double quotes or single quotes ko exchange karne ki zaroorat na pare.
//Note: <<<DELIMETER k bad ko space nahi hona chahiye or na hi closing DELIMTER main koi space hona chahiye.
//Hamne PKR k liye HTML ki entity &#8360; ko use kiya

function get_categories(){
    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)){

$categories_links = <<<DELIMETER
        
        <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>

DELIMETER;
        
    echo $categories_links;

    }
        
}
//square bracket main agar cat_title nahi likhenge tu categories table k cat_title se data fetch nahi hoga.


/*****************************BACK END FUNCTIONS***********************************/

?>
