<?php

$upload_directory = "uploads";

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

        $product_image = display_image($row['prod_image']);

        $product = <<<DELIMETER
        
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
            <a href="item.php?id={$row['prod_id']}"><img src="../resources/{$product_image}" alt=""></a>
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

    $product_image = display_image($row['prod_image']);

$show_product = <<<DELIMETER
        
<div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <img src="../resources/{$product_image}" alt="">
            <div class="caption">
                <h3>{$row['prod_title']}</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <p>
                    <a href="../resources/cart.php?add={$row['prod_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['prod_id']} "id= class="btn btn-default">More Info</a>
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

    $product_image = display_image($row['prod_image']);

$show_product_in_shop_page = <<<DELIMETER
        
<div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <img src="../resources/{$product_image}" alt="">
            <div class="caption">
                <h3>{$row['prod_title']}</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <p>
                    <a href="../resources/cart.php?add={$row['prod_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['prod_id']} "id= class="btn btn-default">More Info</a>
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


/************************************Admin Products Page****************************************/

function display_image($picture){

global $upload_directory;

return $upload_directory . DS . $picture;

}


function get_products_in_admin(){
$query = query("SELECT * FROM products");
confirm($query);

while($row = fetch_array($query)){

    $category = show_product_category_title($row['prod_category_id']);

    $product_image = display_image($row['prod_image']);


$product = <<<DELIMETER
        
        <tr>
            <td>{$row['prod_id']}</td>
            <td>{$row['prod_title']}<br>
            <a href="index.php?edit_product&id={$row['prod_id']}"><img width='100' src="../../resources/{$product_image}" alt=""></a>
            </td>
            <td>{$category}</td>
            <td>{$row['prod_price']}</td>
            <td>{$row['prod_quantity']}</td>
            <td><a class='btn btn-danger' href="../../resources/templates/back/delete_product.php?id={$row['prod_id']}"><span class='glyphicon glyphicon-remove'></span></a>
                    <a class='btn btn-success' href=""><span class='glyphicon glyphicon-plus'></span></a>
                    <!-- this will delete complete entry-->
                    </td>
        </tr>

DELIMETER;
    echo $product;

    }    

}

function show_product_category_title($product_category_id){

    $category_query = query("SELECT * FROM categories WHERE cat_id = '{$product_category_id}'");
    confirm($category_query);
    
    while ($category_row = fetch_array($category_query)) {
        return $category_row ['cat_title'];
    }





}


/************************************Add Products in admin****************************************/

function add_product(){
    if (isset($_POST['publish'])) {
        
        $product_title              = escape_string($_POST['prod_title']);
        $product_category_id        = escape_string($_POST['prod_category_id']);
        $product_price              = escape_string($_POST['prod_price']);
        $product_description        = escape_string($_POST['prod_description']);
        $short_desc                 = escape_string($_POST['prod_short_desc']);
        $product_quantity           = escape_string($_POST['prod_quantity']);
        $product_image              = escape_string($_FILES['file']['name']);
        // Files super global variable is wajah se use kiya because hame apni files upload karni hai
        $image_temp_location        = escape_string($_FILES['file']['tmp_name']);
        // 2 array define kiye and then 2 keys like file and tmp_name, tmp_name is wajah se k ham kisi bhi file ko temp location par save karaenge and then image ki directory main move karenge.

        move_uploaded_file($image_temp_location , UPLOAD_DIRECTORY . DS . $product_image);

        $query = query("INSERT INTO products(prod_title, prod_category_id, prod_price, prod_description, prod_short_desc, prod_quantity, prod_image) VALUES('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_description}', '{$short_desc}', '{$product_quantity}', '{$product_image}')");
        $last_id = last_id();

        confirm($query);
        set_message("New Product with id {$last_id} Added");
        redirect("index.php?products");
        
    }
}


function show_categories_add_product_page(){
    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)){

$categories_options = <<<DELIMETER
        
<option value="{$row['cat_id']}">{$row['cat_title']}</option>

DELIMETER;
        
    echo $categories_options;

    }
        
}



/************************************Updating Product Code****************************************/

function update_product(){
    if (isset($_POST['update'])) {
        
        $product_title              = escape_string($_POST['prod_title']);
        $product_category_id        = escape_string($_POST['prod_category_id']);
        $product_price              = escape_string($_POST['prod_price']);
        $product_description        = escape_string($_POST['prod_description']);
        $short_desc                 = escape_string($_POST['prod_short_desc']);
        $product_quantity           = escape_string($_POST['prod_quantity']);
        $product_image              = escape_string($_FILES['file']['name']);
        // Files super global variable is wajah se use kiya because hame apni files upload karni hai
        $image_temp_location        = escape_string($_FILES['file']['tmp_name']);
        // 2 array define kiye and then 2 keys like file and tmp_name, tmp_name is wajah se k ham kisi bhi file ko temp location par save karaenge and then image ki directory main move karenge.
        

        if(empty($product_image)){

            $get_pic = query("SELECT prod_image FROM products WHERE prod_id=" . escape_string($_GET['id']) . " ");
            confirm($get_pic);

            while ($pic = fetch_array($get_pic)) {
                $product_image = $pic['prod_image'];
            }
        }

        move_uploaded_file($image_temp_location , UPLOAD_DIRECTORY . DS . $product_image);

        $query = "UPDATE products SET ";
        $query .= "prod_title         = '{$product_title}'          , ";
        $query .= "prod_category_id   = '{$product_category_id}'    , ";
        $query .= "prod_price         = '{$product_price}'          , ";
        $query .= "prod_description   = '{$product_description}'    , ";
        $query .= "prod_short_desc    = '{$product_short_desc}'     , ";
        $query .= "prod_quantity      = '{$product_quantity}'       , ";
        $query .= "prod_image         = '{$product_image}'            ";
        $query .= "WHERE prod_id=" . escape_string($_GET['id']);

        $send_update_query = query($query);
        confirm($send_update_query);
        set_message("Product has been updated");
        redirect("index.php?products");
        
    }
}


/************************************Categories in admin****************************************/

function show_categories_in_admin(){

    $category_query = query("SELECT * FROM categories");
    confirm($category_query);

    while ($row = fetch_array($category_query)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

$category = <<<DELIMETER

<tr>
    <td>{$cat_id}</td>
    <td>{$cat_title}</td>
    <td><a class='btn btn-danger' href="../../resources/templates/back/delete_category.php?id={$row['cat_id']}"><span class='glyphicon glyphicon-remove'></span></a>
    <!-- this will delete complete entry-->
    </td>
</tr>

DELIMETER;

echo $category;

    }
}

function add_category(){

    if (isset($_POST['add_category'])) {
    $cat_title = escape_string($_POST['cat_title']);

    if(empty($cat_title) || $cat_title == " "){

        echo "<p class='bg-danger'> THIS CANNOT BE EMPTY </p>";
    }else{

    $insert_cat = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}') ");
    confirm($insert_cat);

    set_message("Category Created");
        }

    }
}

?>
