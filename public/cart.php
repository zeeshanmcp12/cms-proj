
<!-- Configuration Here -->
<?php require_once("../resources/config.php"); ?>

<?php

    if (isset($_GET['add'])) {


        $query = query("SELECT * FROM products WHERE prod_id=" . escape_string($_GET['add']). "" );
        confirm($query);

        // $_SESSION['product_' . $_GET['add']] +=1;   //yahan hamne session banaya phr product id k sath //concatenate kardiya k jab bhi user add to cart par click karega to new session ban jayega or id auto //increament hoti rahegi.

        // redirect("index.php");


        while ($row = fetch_array($query)) {    //Database se details fetch karne k liye fetch_query helper                                                //function ka use kiya.

            if($row['prod_quantity'] != $_SESSION['product_' . $_GET['add']]){

                $_SESSION['product_' . $_GET['add']] +=1;    //Here we are increamenting into which we fetched                                                  //from database.
                redirect("checkout.php");

            }else {
                set_message("We only have " . $row['prod_quantity'] . " " . "{$row['prod_title']}" . " available");
                redirect("checkout.php");
            }
        }
    }

    if(isset($_GET['remove'])){

        $_SESSION['product_' . $_GET['remove']] --;

        if($_SESSION['product_' . $_GET['remove']] < 1){
             redirect("checkout.php");

        }else {
            redirect("checkout.php");
        }
    }

    if(isset($_GET['delete'])){

        $_SESSION['product_' . $_GET['delete']] = '0';
        redirect("checkout.php");
        }

?>