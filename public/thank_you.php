
<!-- Configuration Here -->
<?php require_once("../resources/config.php"); ?>
<?php require_once("cart.php"); ?>

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