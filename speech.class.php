<?php
class Speech
{
    const APP_ID = '5b3c8c7f';
    const APP_KEY_IAT = '287888edd2fc0f0ba98b4fe61d26b01a';
    const APP_KEY_TTS = '8777da4c875deda7797b4042b993133a';
    
	public function voiceIat($file_path){
	    $param = [        
	    			'engine_type' => 'sms16k',        
	    			'aue' => 'raw'
	    		];    
	    $cur_time = (string)time();    
	    $x_param = base64_encode(json_encode($param));    
	    $header_data = [  
			'X-Appid:'.self::APP_ID,        
			'X-CurTime:'.$cur_time,        
			'X-Param:'.$x_param,        
			'X-CheckSum:'.md5(self::APP_KEY_IAT.$cur_time.$x_param),        
			'Content-Type:application/x-www-form-urlencoded; charset=utf-8'
	    ];    //Body
	    $file_content = file_get_contents($file_path);    
	    $body_data = 'audio='.urlencode(base64_encode($file_content));    //Request
	    $url = "http://api.xfyun.cn/v1/service/v1/iat";    
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_POST, TRUE);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $body_data);    
	    $result = curl_exec($ch);
	    curl_close($ch);    
	    return $result;
	}

	public function voiceTts($content, $output_path)
	{
		echo $content;
	    $param = [
	        'engine_type' => 'intp65',
	        'auf' => 'audio/L16;rate=16000',
	        'aue' => 'raw',
	        'voice_name' => 'xiaoyan',
	        'speed' => '0'
	    ];
	    $cur_time = (string)time();
	    $x_param = base64_encode(json_encode($param));
	    $header_data = [
	        'X-Appid:'.self::APP_ID,
	        'X-CurTime:'.$cur_time,
	        'X-Param:'.$x_param,
	        'X-CheckSum:'.md5(self::APP_KEY_TTS.$cur_time.$x_param),
	        'Content-Type:application/x-www-form-urlencoded; charset=utf-8'
	    ];
	    //Body
	    $body_data = 'text='.urlencode($content);
	    //Request
	    $url = "http://api.xfyun.cn/v1/service/v1/tts";
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, TRUE);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_POST, TRUE);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $body_data);
	    $result = curl_exec($ch);
	    $res_header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	    $res_header = substr($result, 0, $res_header_size);
	    curl_close($ch);
	    if(stripos($res_header, 'Content-Type: audio/mpeg') === FALSE){ //合成错误
	        return substr($result, $res_header_size);
	    }else{
	    	$output_path = './tmpspeech/';
	    	$name = date('dmY_His').'.mp3';
	        $result = file_put_contents($output_path.$name, substr($result, $res_header_size));
	        var_dump($result);
	        return '语音合成成功，请查看文件！'.$output_path.$name;
	    }
	}
}    