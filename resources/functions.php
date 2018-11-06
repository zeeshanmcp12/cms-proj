<?php

//Helper functions


function last_id(){

    global $connection;
    return mysqli_insert_id ($connection);

}



function set_message($msg){
    if(!empty($msg)){
        $_SESSION['message'] = $msg;

    }else{
        $msg = "";
    }
    
}

function display_message(){

    if(isset($_SESSION['message'])){

        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }

}


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
                    <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['prod_id']}">Add to Cart</a>
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

function get_products_in_cat_page(){
    $query = query("SELECT * FROM products WHERE prod_category_id = " . escape_string($_GET['id']) . " ");
    confirm($query);

    while($row = fetch_array($query)){

$show_product = <<<DELIMETER
        
<div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <img src="{$row['prod_image']}" alt="">
            <div class="caption">
                <h3>{$row['prod_title']}</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <p>
                    <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['prod_id']} "id= class="btn btn-default">More Info</a>
                </p>
            </div>
        </div>
    </div>

DELIMETER;
    echo $show_product;

    }
}
//http://placehold.it/800x500


function get_products_in_shop_page(){
    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)){

$show_product_in_shop_page = <<<DELIMETER
        
<div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <img src="{$row['prod_image']}" alt="">
            <div class="caption">
                <h3>{$row['prod_title']}</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <p>
                    <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['prod_id']} "id= class="btn btn-default">More Info</a>
                </p>
            </div>
        </div>
    </div>

DELIMETER;
    echo $show_product_in_shop_page;

    }
}

function login_user(){

    if(isset($_POST['submit'])){
        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);

        $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
        confirm($query);

        if(mysqli_num_rows($query) == 0){

            set_message("Username or Password is incorrect");
            redirect("login.php");

        }else{

            $_SESSION['username'] = $username;
            // set_message("Welcome to Admin {$username} ");
            redirect("admin");
        }
    }
}

function send_message(){

    if(isset($_POST['submit'])){

        $to         = "someEmail@gmail.com";
        $from_name  = $_POST['name'];
        $subject    = $_POST['subject'];
        $email      = $_POST['email'];
        $message    = $_POST['message'];

        $headers = "From: {$from_name} {$email}";

        $result = mail($to, $subject, $message, $headers);

        if(!$result){
            set_message("ERROR");
            redirect("contact.php");
        }
        else{
             set_message("Message sent successfully.");
             redirect("contact.php");
        }
    }
}




/*****************************BACK END FUNCTIONS***********************************/

function display_order(){

    $query = query("SELECT * FROM orders");
    confirm($query);


while ($row = fetch_array($query)){
$orders = <<<DELIMETER
    <tr>
        <td>{$row['order_id']}</td>
        <td>{$row['order_amount']}</td>
        <td>{$row['order_transaction']}</td>
        <td>{$row['order_currency']}</td>
        <td>{$row['order_status']}</td>
        <td><a class='btn btn-danger' href="../../resources/templates/back/delete_order.php?id={$row['order_id']}"><span class='glyphicon glyphicon-remove'></span></a>
                    <a class='btn btn-success' href=""><span class='glyphicon glyphicon-plus'></span></a>
                    <a class='btn btn-danger' href=""><span class='glyphicon glyphicon-remove'></span></a>
                    <!-- this will delete complete entry-->
                    </td>
    </tr>
DELIMETER;

// ../resources/cart.php?delete={$row['prod_id']}
echo $orders;

    }
}


/************************************Admin Products****************************************/
function get_products_in_admin(){
$query = query("SELECT * FROM products");
confirm($query);

while($row = fetch_array($query)){

$product = <<<DELIMETER
        
        <tr>
            <td>{$row['prod_id']}</td>
            <td>{$row['prod_title']}<br>
            <img src="{$row['prod_image']}" alt="">
            </td>
            <td>Category</td>
            <td>{$row['prod_price']}</td>
            <td>{$row['prod_quantity']}</td>
        </tr>

DELIMETER;
    echo $product;

    }    

}


?>
