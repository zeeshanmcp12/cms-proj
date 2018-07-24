
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

/*******************************************
            * Cart Function
*******************************************/
function cart(){

    foreach ($_SESSION as $name => $value) {

    if ($value > 0) {
        if (substr($name, 0, 8) == "product_") {
            //substring 0 se start ho kar string k last digit tak count hoti hai...for example: p=1 and t=7


        $length = strlen($name - 8);

        $id = substr($name, 8, $length);

                $query = query("SELECT * FROM products WHERE prod_id = " . escape_string($id) . " " );
                confirm($query);
            
                while ($row = fetch_array($query)) {
            
                    $product = <<<DELIMETER
                    <tr>
                    <td>{$row['prod_title']}</td>
                    <td>{$row['prod_price']}</td>
                    <td>{$row['prod_quantity']}</td>
                    <td>2</td>
                    <td>
                    <a class='btn btn-warning' href="cart.php?remove={$row['prod_id']}"><span class='glyphicon glyphicon-minus'></span></a>
                    <a class='btn btn-success' href="cart.php?add={$row['prod_id']}"><span class='glyphicon glyphicon-plus'></span></a>
                    <a class='btn btn-danger' href="cart.php?delete={$row['prod_id']}1"><span class='glyphicon glyphicon-remove'></span></a>
                    <!-- this will delete complete entry-->
                    </td>             
                    </tr>
DELIMETER;
            
            echo $product;
                    }
                }
             }
        }  
}

?>