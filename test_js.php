<?php declare(strict_types=1);
error_reporting(E_ERROR);ini_set('display_errors',"1");set_include_path(get_include_path().PATH_SEPARATOR.'luokat/');spl_autoload_extensions('.class.php');spl_autoload_register();
function debug($var,$var_dump=false){echo"<br><pre>Print_r ::<br>";print_r($var);echo"</pre>";if($var_dump){echo"<br><pre>Var_dump ::<br>";var_dump($var);echo"</pre><br>";};
}
if(!empty($_POST)){debug($_POST);}if(!empty($_GET)){debug($_GET);}
?>

<!DOCTYPE html>
<html lang="fi">

<?php require 'html_head.php'; ?>

<body>

<?php require 'html_header.php'; ?>

<main class="main_body_container">



</main>

<?php require 'html_footer.php'; ?>

<script>
</script>

</body>
</html>
