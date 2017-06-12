<?php

class Pagination
{
	private $sys_cms;

	public function __construct()
	{
	}

	public function createLinks($table, $rows_per_page, $pag_seg_number, $urlstring, $condition = '')
	{
		$prefix = Registry :: library('db')->getPrefix();
		$this->sys_cms = Registry :: library('db')->getSys();
		$prefixed_table = $prefix . $table;
		if ($condition == '')
		{
			$sql = "SELECT COUNT(*) FROM " . $prefixed_table;
		}
		else
		{
			$sql = "SELECT COUNT(*) FROM " . $prefixed_table . " " . $condition;
		}
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$data = Registry :: library('db')->getRows();
			foreach ($data as $k => $v)
			{
				$num_rows = $v;
			}
		}
		if ($num_rows == 0)
		{
			$link_string = '';
		}
		else
		{
			$total_pages = ceil($num_rows / $rows_per_page);
			$urlSegments = Registry :: getURLSegments();
			if ((isset ($urlSegments[$pag_seg_number])) && is_numeric($urlSegments[$pag_seg_number]))
			{
				$current_page = $urlSegments[$pag_seg_number];
			}
			else
			{
				$current_page = 1;
			}
			if ($current_page > $total_pages)
			{
				$current_page = $total_pages;
			}
			if ($current_page < 1)
			{
				$current_page = 1;
			}
			$range = 3;
			$link_string = '';
// if not on page 1, don't show back links
			if ($current_page > 1)
			{
				$link_string = $link_string . ' <li class="first"><a href="' . FWURL . $urlstring . '/' . '1"><<</a></li> ';
				$prev_page = $current_page - 1;
				$link_string = $link_string . ' <li class="prev"><a href="' . FWURL . $urlstring . '/' . $prev_page . '"><</a></li> ';
			}
// loop to show links to range of pages around current page
			for ($x = ($current_page - $range); $x < (($current_page + $range) + 1); $x++)
			{
				if (($x > 0) && ($x <= $total_pages))
				{
					if ($x == $current_page)
					{
						$link_string = $link_string . ' <li><span class="current">' . $x . '</span></li> ';
					}
					else
					{
						$link_string = $link_string . ' <li><a href="' . FWURL . $urlstring . '/' . $x . '">' . $x . '</a></li> ';
					}
				}
			}
// if not on last page, show forward and last page links
			if ($current_page != $total_pages)
			{
				$next_page = $current_page + 1;
				$link_string = $link_string . ' <li class="next"><a href="' . FWURL . $urlstring . '/' . $next_page . '">></a></li> ';
				$link_string = $link_string . ' <li class="last"><a href="' . FWURL . $urlstring . '/' . $total_pages . '">>></a></li> ';
			}
			if ($link_string == ' <li><span class="current">1</span></li> ')
			{
				$link_string = '';
			}
		}
		$link_string = '<ul class="pagination">' . $link_string . '</ul>';
		return $link_string;
	}

	public function createLinksSys($table, $rows_per_page, $pag_seg_number, $urlstring, $condition = '')
	{
		$prefix = Registry :: library('db')->getPrefix();
		$this->sys_cms = Registry :: library('db')->getSys();
		$prefixed_table = $prefix . $table;
		if ($condition == '')
		{
			$sql = "SELECT COUNT(*) FROM " . $prefixed_table . " WHERE " . $table . "_sys = '" . $this->sys_cms . "'";
		}
		else
		{
			$sql = "SELECT COUNT(*) FROM " . $prefixed_table . " " . $condition . " AND " . $table . "_sys = '" . $this->sys_cms . "'";
		}
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$data = Registry :: library('db')->getRows();
			foreach ($data as $k => $v)
			{
				$num_rows = $v;
			}
		}
		if ($num_rows == 0)
		{
			$link_string = '';
		}
		else
		{
			$total_pages = ceil($num_rows / $rows_per_page);
			$urlSegments = Registry :: getURLSegments();
			if ((isset ($urlSegments[$pag_seg_number])) && is_numeric($urlSegments[$pag_seg_number]))
			{
				$current_page = $urlSegments[$pag_seg_number];
			}
			else
			{
				$current_page = 1;
			}
			if ($current_page > $total_pages)
			{
				$current_page = $total_pages;
			}
			if ($current_page < 1)
			{
				$current_page = 1;
			}
			$range = 3;
			$link_string = '';
// if not on page 1, don't show back links
			if ($current_page > 1)
			{
				$link_string = $link_string . ' <li class="first"><a href="' . FWURL . $urlstring . '/' . '1"><<</a></li> ';
				$prev_page = $current_page - 1;
				$link_string = $link_string . ' <li class="prev"><a href="' . FWURL . $urlstring . '/' . $prev_page . '"><</a></li> ';
			}
// loop to show links to range of pages around current page
			for ($x = ($current_page - $range); $x < (($current_page + $range) + 1); $x++)
			{
				if (($x > 0) && ($x <= $total_pages))
				{
					if ($x == $current_page)
					{
						$link_string = $link_string . ' <li><span class="current">' . $x . '</span></li> ';
					}
					else
					{
						$link_string = $link_string . ' <li><a href="' . FWURL . $urlstring . '/' . $x . '">' . $x . '</a></li> ';
					}
				}
			}
// if not on last page, show forward and last page links
			if ($current_page != $total_pages)
			{
				$next_page = $current_page + 1;
				$link_string = $link_string . ' <li class="next"><a href="' . FWURL . $urlstring . '/' . $next_page . '">></a></li> ';
				$link_string = $link_string . ' <li class="last"><a href="' . FWURL . $urlstring . '/' . $total_pages . '">>></a></li> ';
			}
			if ($link_string == ' <li><span class="current">1</span></li> ')
			{
				$link_string = '';
			}
		}
		$link_string = '<ul class="pagination">' . $link_string . '</ul>';
		return $link_string;
	}

}
?>