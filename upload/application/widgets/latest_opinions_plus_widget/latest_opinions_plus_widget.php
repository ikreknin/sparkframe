<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Latest_opinions_plus_widget
{

	function __construct()
	{
	}

	public function index($number_of_opinions = 5, $message_length = 100, $min_words = 3)
	{
		$prefix = Registry :: library('db')->getPrefix();
		$sys_cms = Registry :: library('db')->getSys();
		$settings_shop0 = Registry :: setting('settings_shop0');
		$latest_opinions_text = Registry :: library('lang')->line('latest_opinions_text');
		$result = '';
		$sql = 'SELECT *
    	FROM ' . $prefix . 'shop_opinions
    		LEFT JOIN ' . $prefix . 'users ON p_user_id = users_id
    		LEFT JOIN ' . $prefix . 'shop_products ON p_product_id = t_product_id
    	WHERE p_opinion_visible = "yes"
    	AND shop_opinions_sys = "' . $sys_cms . '"
    	ORDER BY p_opinion_id DESC
    	LIMIT ' . $number_of_opinions;
		$cache = Registry :: library('db')->cacheQuery($sql);
		$num = Registry :: library('db')->numRowsFromCache($cache);
		if ($num != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			$result .= '<h3>' . $latest_opinions_text . '</h3>';
			$result .= '<ul class="uli">';
			foreach ($data as $k => $v)
			{
				$sub = '';
				$len = 0;
				foreach (explode(' ', $v["p_body"]) as $word)
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
				<h4><a href="' . FWURL . $settings_shop0 . '/viewproduct/' . $v["p_product_id"] . '">' . $v["p_opinion_date"] . '</a></h4>
				' . $v["username"] . '<br />
				' . $sub . (($len < strlen($v["p_body"])) ? '...' : '') . '<br /><br />
				</li>';
			}
			$result .= '</ul>';
		}
		return $result;
	}

}
?>