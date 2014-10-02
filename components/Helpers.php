<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace core\components;

/**
 * Helpers
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 */
class Helpers
{
	/**
	 * Protects the email from bots
     *
	 * I have copied and modified this http://www.maurits.vdschee.nl/php_hide_email/
	 *
	 * @param string $email the email address
	 * @return string 
	 */	
	
    public static function hideEmail($email) { 
    	$character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
		$key = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);
  		for ($i=0;$i<strlen($email);$i+=1) $cipher_text.= $key[strpos($character_set,$email[$i])];
  		
  		$script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
		$script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
		$script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';
		$script = "eval(\"".str_replace(["\\",'"'],["\\\\",'\"'], $script)."\")"; 
		$script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';

		return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
	}
}