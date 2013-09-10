<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>Payment Direct - demo</title>
        <style>
            label {
                    display: block;
                    width: 130px;
                    float: left;
            }
            div.clear {
                    clear: both;
                    height: 10px;
            }
            input[type=submit], input[type=button] {
                    width: 100px;
                    margin-left: 185px;
            }
        </style>
        
    </head>
    <body style="margin: 10px;">
        <a href="index.php?mode=AJAX">AJAX method</a> &nbsp;&nbsp;&nbsp;
        <a href="index.php?mode=POST">POST method</a>
        <br />
        
        <?php
        session_start();
        if (isset($_GET['mode'])){
            print '<h1>' . $_GET['mode'] . ' method</h1>';
            
            if ($_GET['mode'] == 'POST')
                include "post.php";
            elseif($_GET['mode'] == 'AJAX')
                include "ajax.php";
        }
        ?>
    </body>
</html>
