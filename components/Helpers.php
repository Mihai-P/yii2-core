<?php
/**
 * Helpers
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 */

namespace core\components;

/**
 * Helpers
 *
 * This class is indicative of poor software design.
 */
class Helpers
{
	/**
	 * Protects the email from bots
     *
	 * Credits to http://www.maurits.vdschee.nl/php_hide_email/
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

	/**
	 * Get the first x chars from a string. If the string is bigger it pads it with ...
	 *
	 * Credits to http://www.maurits.vdschee.nl/php_hide_email/
	 *
	 * @param string $str the string
	 * @param integer $limit the number of characters
	 * @param boolean $strip should we string tags or not
	 * @return string
	 */

	public static function summary($str, $limit=100, $strip = false) {
		$str = ($strip == true) ? strip_tags($str) : $str;
		if (strlen ($str) > $limit) {
			$str = substr ($str, 0, $limit - 3);
			return (substr ($str, 0, strrpos ($str, ' ')) . '...');
		}
		return trim($str);
	}
}