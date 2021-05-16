<!DOCTYPE html>
<html lang="en">

</html>

<?php require_once 'html/head.php' ?>

<body class="preloading">

    <!-- FACEBOOK -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v10.0" nonce="lRWqnPso"></script>


    <?php require_once 'block/loader_skeleton.php' ?>

    <?php require_once 'html/header.php' ?>

    <?php require_once PATH_MODULE . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php'; ?>

    <?php require_once 'html/footer.php' ?>

    <?php require_once 'block/tap-top.php' ?>


    <?php echo $this->_jsFiles; ?>

    <script>
        function openSearch() {
            document.getElementById("search-overlay").style.display = "block";
            document.getElementById("search-input").focus();
        }

        function closeSearch() {
            document.getElementById("search-overlay").style.display = "none";
        }
        var THEME_DATA = {
            "user": "<?php echo  $_SESSION['user']  ?>",
        };
    </script>

    <?php require_once 'html/nut_goi.php' ?>
    <?php require_once 'html/fb_chat.php' ?>
    <?php require_once 'html/plugin_fb.php' ?>

</body>

</html>