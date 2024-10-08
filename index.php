<?php
    define("TITLE", "Início | Journalling");
    define("PAGE", null);
    define("STYLESHEET", null);
?>

<?php include('layout/side-menu.php'); ?>
<?php include('layout/header.php'); ?>
    </div>

    <script>
        $(document).ready(function() {
            var currentUrl = window.location.href; 
            window.location.href = currentUrl + 'pages/inicio.php';
        });
    </script>
</body>

</html> 