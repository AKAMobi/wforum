<?php
    require("inc/funcs.php");
?>
<html>
<head>
<title><?php echo $HTMLTitle; ?></title>
</head>
<frameset name="mainframe" id="mainframe" frameborder="0" border="1" cols="150,*">
    <frame name="menu" marginwidth="0" marginheight="0" src="bbsleft.php">
    <frame name="main" marginwidth="0" marginheight="0" src="<?php echo isset($_GET["target"])?urldecode($_GET["target"]):"index.php"; ?>">
</frameset>
</html>
