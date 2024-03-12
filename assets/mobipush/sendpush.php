<?php
session_start();
if(empty($_SESSION["pushadmin"])){
header('Location: ./index.php');
exit;    
}
if(@$_GET["action"] == "logout"){
unset($_SESSION["pushadmin"]);
header('Location: ./index.php');
exit;    
}
if(!empty($_POST)){
 include "pushtoken.php";   
if(!isset($_POST["title"]) || !isset($_POST["summary"])){
     echo "Can't Send and empty push!!!";
      exit;
}else{
function mid($length = 4) {
    return substr(str_shuffle(str_repeat($x='1234567890', ceil($length/strlen($x)) )),1,$length);
}   
if(empty($_POST['image'])){
$icon = "./logo.png";
}else{
$icon = $_POST['image'];    
}
  $server_key = 'AAAASTKDNE8:APA91bE-i0krnnVt_rW-jfLU-mBi8oxDg7xdV4CQ3VMYIw0M9GhbbBdhnHs53dOev0no_6bYFM8EWtR0MWCnAJbDgHWANFU0XhiJglDDJAaHcPk8JaDLrhIKY5rOUyVoh6ZvVwzz1uT_';
    
$payload = array(
          'to'=>'/topics/'.$push_token,
          'priority'=>'high',
          "mutable_content"=>true,
          "notification"=>array(
                      "title"=> $_POST['title'],
                      "body"=> $_POST['summary'],
                      "icon"=> $icon,
                      "click_action"=> @$_POST['url']
          ),
          'data'=>array(
                'action'=>'models',
                'model_id'=>mid(),
              )
        );
    $headers = array(
      'Authorization:key='.$server_key,
      'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $payload ) );
    $result = curl_exec($ch );
    curl_close( $ch );
    }
    
}
?>

<!doctype html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Mobipush - Sending Push Notification</title>
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
    background-color: <?php echo @$theme;?>;
    border-color: <?php echo @$theme;?>
}
.logout {
  position: absolute;
  top: 30px;
  right: 25px;
}

.my-logout-icon {
  background-color: #000000;
  color: #fff;
}
</style>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
<script type='text/javascript' src='https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js'></script>
<script type='text/javascript'></script>
</head>
<body  class='snippet-body'>

    <div class="text-right mb-2 logout" style="float: right; cursor: pointer; position: fixed; left: 87%; z-index:10000; text-align: right">
        <a href="./sendpush.php?action=logout" class="my-logout-icon fas p-2 rounded-circle" style="float: right; cursor: pointer;"><i class="fa fa-power-off cart-img p-2"></i></a>

      </div>   
<form class="card" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="text-center intro"> <img src="logo.png" width="180"> </div>
	<input type="hidden" name="action" value="login">
    <div class="mt-4 text-center">
        <h4>Send Push.</h4> <span>Enter your push information</span>
        <div class="mt-3 inputbox"> <input type="text" class="form-control" name="title" placeholder="Push title" value="<?php echo @$_POST["title"]; ?>"> </div>
        <div class="inputbox"> <input type="text" class="form-control" name="image" placeholder="Push image"> </div>
        <div class="inputbox"> <input type="text" class="form-control" name="url" placeholder="Url to open on click"> </div>
        <div class="inputbox"><textarea class="form-control" name="summary" placeholder="Your push summary content"></textarea>  </div>
		<?php echo @$result;?>
    </div>
    
    <div class="mt-2 mb-5"> <button class="btn btn-primary btn-block" type="submit" >Send Push</button> </div>
</form>

</body>
</html>