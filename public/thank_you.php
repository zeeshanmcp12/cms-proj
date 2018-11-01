
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

process_transaction();

?>

    <!-- Page Content  -->
    <div class="container">
        <h1 class="text-center">THANK YOU</h1>

    </div>


    <!-- /.container -->

<!-- Footer Here -->
<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>