<?php
   require_once("speech.class.php");
   error_reporting(E_ALL);
   $instance = new Speech();
   if(isset($_FILES)){
	   	$audioData = $_FILES['audioData'];
	    $filesName = $_FILES['audioData']['name'];  
	    $filesTmpName = $_FILES['audioData']['tmp_name']; 
	    $output_path = './tmpspeech/';
	    $name = date('dmY_His').'.mp3';
	    $saveStatus = move_uploaded_file($_FILES['audioData']['tmp_name'], $output_path.$name);
	    $result = $instance->voiceIat($output_path.$name);
	    $data = json_decode($result);
	    $status = $data->desc;
	    $content = $data->data;
	    var_dump($data);
	    exit();
   }else{
   		echo '非法操作';
   		exit();
   }
   

   //$instance->voiceIat();
   //$result = $instance->voiceTts('张亚丽女儿叫早早');
   //$result = $instance->voiceIat('./tmpspeech/11072018_013455.mp3');
   //var_dump($result);