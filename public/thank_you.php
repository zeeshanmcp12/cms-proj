
<!-- Configuration Here -->
<?php require_once("../resources/config.php"); ?>

<!-- Header Here -->
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<!-- <?php echo $_SESSION['product_1']; ?> --> <!-- this is just for testing -->

<!-- <?php 
    if(isset($_SESSION['product_1'])){

        // echo $_SESSION['product_1'];

        echo $_SESSION['item_total'];
    }

?> -->

<?php 
    if (isset($_GET['tx'])){

    $amount = $_GET['amt'];
    $currency = $_GET['cc'];
    $transaction = $_GET['tx'];
    $status = $_GET['st'];

    // below query will get our submitted value and put it into our db
    $query = query("INSERT INTO orders (order_amount, order_transaction, order_status, order_currency) VALUES('{$amount}', '{$transaction}', '{$status}', '{$currency}')");

    confirm($query);


    report();


    // session_destroy();



    } else {

        redirect("index.php");
    }





?>

    <!-- Page Content  -->
    <div class="container">
        <h1 class="text-center">THANK YOU</h1>

    </div>


    <!-- /.container -->

<!-- Footer Here -->
<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>