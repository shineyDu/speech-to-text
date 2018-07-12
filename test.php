<?php
require_once("speech.class.php");
error_reporting(E_ALL);
$instance = new Speech();
$instance->voiceIat();
//$result = $instance->voiceTts('测试语音转文字接口');
$result = $instance->voiceIat('./tmpspeech/11072018_032657.mp3');
var_dump($result);