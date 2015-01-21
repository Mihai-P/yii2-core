<?php
/**
 * StringHelper adds some additional functionality to the Yii StringHelper class
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 */

namespace core\components;

/**
 * StringHelper adds some additional functionality to the Yii StringHelper class
 *
 * This class adds some additional string functions to the Yii StringHelper
 * class, mostly aimed at displaying HTML data in particular ways.
 *
 * @see \yii\helpers\StringHelper
 */
class StringHelper extends \yii\helpers\StringHelper
{
	/**
	 * Protects the email from bots
     *
	 * @reference http://www.maurits.vdschee.nl/php_hide_email/
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
	 * @see truncate
	 * @param string $str the string
	 * @param integer $limit the number of characters
	 * @param boolean $strip should we strip tags or not
	 * @return string
	 */

	public static function summary($str, $limit=100, $strip = false) {
		$str = ($strip == true) ? strip_tags($str) : $str;
		return static::truncate($str, $limit - 3, '...');
	}
}