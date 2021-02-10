<?php
require_once "files/header.html";
require_once "files/menu.php";
require_once "files/menu_categories.php";
require_once "files/categories.php";
if(preg_match("#edit.+#i", $_GET['option']))
{
    $row = mysqli_fetch_assoc($result);
    require "files/edit_admin.php";
}
elseif(preg_match("#add.+#i", $_GET['option']))
    require "files/add_admin.php";
else
    require "files/content_admin.php";
require_once "files/footer.html";