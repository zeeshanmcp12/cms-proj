
<!-- Configuration Here -->
<?php require_once("../resources/config.php"); ?>

<?php

    if (isset($_GET['add'])) {


        $query = query("SELECT * FROM products WHERE prod_id =" . escape_string($_GET['add']). "" );
        confirm($query);

        // $_SESSION['product_' . $_GET['add']] +=1;   //yahan hamne session banaya phr product id k sath concatenate kardiya k jab bhi user add to cart par click karega to new session ban jayega or id auto increament hoti rahegi.

        // redirect("index.php");
    }


?>