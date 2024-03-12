<?php
session_start();
$pushworker_file = "./pushworker.js";
if (!file_exists($pushworker_file)){
$pusworker = file_get_contents("./pushworker.txt");
file_put_contents("./pushworker.js", $pusworker);
}
if(@$_POST["action"] == "install"){
function token($length = 20) {
    return substr(str_shuffle(str_repeat($x='23456789abcdefghijklmnopqrstuvwxyz', ceil($length/strlen($x)) )),1,$length);
}
define('ROOTDIR', dirname(__FILE__));
define('LIBDIR', ROOTDIR);
define('CONFIG_FILE', './pushtoken.php');

define('CE_NEWLINE', "\r\n");
define('CE_WORDWRAP', 60);
require_once(LIBDIR.'/confedit.class.php');

// Creating an instance of ConfigEditor
$config = new ConfigEditor();

    $config->SetVar('email', $_POST["email"], 'Email to login to Push Panel');
	$config->SetVar('password', $_POST["password"], 'Password to login to Push Panel');
	$config->SetVar('push_token', token(), 'Your Website Unique token');
	$config->Save(CONFIG_FILE);
    file_put_contents("./config.lock", "locked");  
}  

if(@$_POST["action"] == "login"){
	
require_once("./pushtoken.php");
if(!empty($_POST["email"]) && !empty($_POST["password"])){
if($_POST["email"] == $email && $_POST["password"] == $password){
$_SESSION["pushadmin"] = $_POST["email"];
header('Location: ./sendpush.php');
exit;
}else{
$error	= "<div class='bg-danger text-white p-3'>Invalid Login Information</div>";	
}		
}	

}
?>
<!doctype html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Mobipush - Admin Login</title>
<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' rel='stylesheet'>
<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
<style>body {
    background-color: #eee;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh
}

.card {
    width: 400px;
    padding: 20px;
    border: none
}

.account {
    font-weight: 500;
    font-size: 17px
}

.contact {
    font-size: 13px
}

.form-control {
    text-indent: 14px
}

.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #4a148c;
    outline: 0;
    box-shadow: none
}

.inputbox {
    margin-bottom: 10px;
    position: relative
}

.inputbox i {
    position: absolute;
    left: 8px;
    top: 12px;
    color: #dadada
}

.form-check-label {
    font-size: 13px
}

.form-check-input {
    width: 14px;
    height: 15px;
    margin-top: 5px
}

.forgot {
    font-size: 14px;
    text-decoration: none;
    color: #4A148C
}

.mail {
    color: #4a148c;
    text-decoration: none
}

.form-check {
    cursor: pointer
}

.btn-primary {
    color: #fff;
    background-color: <?php echo $theme;?>;
    border-color: <?php echo $theme;?>
}</style>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
<script type='text/javascript' src='https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js'></script>
<script type='text/javascript'></script>
</head>
<body oncontextmenu='return false' class='snippet-body'>
<?php
$filename = "./config.lock";
if (file_exists($filename)){
?>
<form class="card" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="text-center intro"> <img src="logo.png" width="180"> </div>
	<input type="hidden" name="action" value="login">
    <div class="mt-4 text-center">
        <h4>Push Admin.</h4> <span>Login with your admin credentials</span>
        <div class="mt-3 inputbox"> <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo @$_POST["email"]; ?>"> <i class="fa fa-envelope"></i> </div>
        <div class="inputbox"> <input type="password" class="form-control" name="password" placeholder="Password"> <i class="fa fa-lock"></i> </div>
		<?php echo @$error;?>
    </div>
    <div class="d-flex justify-content-between">
        <div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"> <label class="form-check-label" for="flexCheckDefault"> Keep me Logged in </label> </div>
       
    </div>
    <div class="mt-2 mb-5"> <button class="btn btn-primary btn-block" type="submit" >Log In</button> </div>
</form>
<?php
}else{
?>
<form class="card" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="text-center intro"> <img src="logo.png" width="180"> </div>
	<input type="hidden" name="action" value="install">
    <div class="mt-4 text-center">
        <h4>Push Admin.</h4> <span>Setup your admin credentials</span>
        <div class="mt-3 inputbox"> <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo @$_POST["email"]; ?>"> <i class="fa fa-envelope"></i> </div>
        <div class="inputbox"> <input type="password" class="form-control" name="password" placeholder="Password"> <i class="fa fa-lock"></i> </div>
		<?php echo @$error;?>
    </div>
   
    <div class="mt-2 mb-5"> <button class="btn btn-primary btn-block" type="submit" >Save Now</button> </div>
</form>
<?php
}
?>
</body>
</html>