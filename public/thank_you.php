
<!-- Configuration Here -->
<?php require_once("../resources/config.php"); ?>

<!-- Header Here -->
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>


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