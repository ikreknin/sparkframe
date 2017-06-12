<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Latest_products_plus_widget
{

	function __construct()
	{
	}

	public function index($number_of_products = 3, $message_length = 100, $min_words = 3)
	{
		$prefix = Registry :: library('db')->getPrefix();
		$sys_cms = Registry :: library('db')->getSys();
		$settings_shop0 = Registry :: setting('settings_shop0');
		$latest_products_text = Registry :: library('lang')->line('latest_products_text');
		$result = '';
		$sql = 'SELECT *
    	FROM ' . $prefix . 'shop_products
    	WHERE t_product_visible = "yes"
    	AND shop_products_sys = "' . $sys_cms . '"
    	ORDER BY t_product_id DESC
    	LIMIT ' . $number_of_products;
		$cache = Registry :: library('db')->cacheQuery($sql);
		$num = Registry :: library('db')->numRowsFromCache($cache);
		if ($num != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			$result .= '<h3>' . $latest_products_text . '</h3>';
			$result .= '<ul class="uli">';
			foreach ($data as $k => $v)
			{
				$sub = '';
				$len = 0;
				foreach (explode(' ', $v["t_body"]) as $word)
				{
					$part = (($sub != '') ? ' ' : '') . $word;
					$sub .= $part;
					$len += strlen($part);
					if (strlen($word) > $min_words && strlen($sub) >= $message_length)
					{
						break;
					}
				}
				$result .= '<li>
				<h4><a href="' . FWURL . $settings_shop0 . '/viewproduct/' . $v["t_product_id"] . '">' . $v["t_title"] . '</a></h4>
				' . $sub . (($len < strlen($v["t_body"])) ? '...' : '') . '<br />
					<p>USD ' . $v["t_price"] . '</p><br />
				</li>';
			}
			$result .= '</ul>';
		}
		$bbcode_w = array("/\[youtube\](.*?)\[\/youtube\]/is" => "<object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/$1\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><param name=\"wmode>\" value=\"transparent\"></param><embed src=\"http://www.youtube.com/v/$1\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"142\" height=\"115\"></embed></object>");
		$result = preg_replace(array_keys($bbcode_w), array_values($bbcode_w), $result);
		return $result;
	}

}
?>