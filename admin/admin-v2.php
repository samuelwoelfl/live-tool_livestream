<?php include "admin-header-start.php" ?>

    <link rel="stylesheet" href="../css/style-v1.css">
    <link rel="stylesheet" href="../css/style-v1_input.css">

<?php include "admin-header-end.php" ?>



    <div class="wrapper">
        <div class="board">

            <div class="top">
                <div class="content">
                    <input type="text" id="title" value="Title" database-variable>
                </div>
            </div>

            <div class="center">
                <div class="heading_container">
                    <input type="text" id="heading" value="Heading" database-variable>
                    <!-- <input type="text" id="RGX" value="1234" database-variable> -->
                    <div class="rgx">
                        <img id="normal" src="../img/rgx_small.png" alt="">
                        <img id="pro" src="../img/rgxpro_small.png" alt="">
                        <input type="text" id="RGX" value="1234" database-variable>
                    </div>
                </div>

                <!-- <input type="text" id="text" value="Message" database-variable> -->
                <textarea rows="5" cols="60" id="text" value="Message" placeholder="Text"></textarea>

                <div class="checkbox_input">
                    <span>Show Heading</span>
                    <input type="checkbox" id="showHeading" value="" database-variable>
                </div>

                <div class="checkbox_input">
                    <span>Show RGX</span>
                    <input type="checkbox" id="showRGX" value="" database-variable>
                </div>

                <div class="checkbox_input">
                    <span>Is Pro</span>
                    <input type="checkbox" id="isPro" value="" database-variable>
                </div>
                
            </div>

        </div>

        <button id="toggle">Einblenden</button>

        
    </div>

    <?php include "admin-settings.php" ?>

</body>

</html>