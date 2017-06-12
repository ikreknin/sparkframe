<?php

class Page
{
	private $css = array();
	private $js = array();
	private $bodyTag = '';
	private $bodyTagInsert = '';
	private $tags = array();
	private $postParseTags = array();
	private $segments = array();
	private $content = "";

	function __construct()
	{
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function addTag($key, $data)
	{
		$data = str_replace('--', '&mdash;', $data);
		$this->tags[$key] = $data;
	}

	public function getTags()
	{
		return $this->tags;
	}

	public function addPPTag($key, $data)
	{
		$this->postParseTags[$key] = $data;
	}

	public function getPPTags()
	{
		return $this->postParseTags;
	}

	public function addTemplateSegment($tag, $segment)
	{
		$this->segments[$tag] = $segment;
	}

	public function getSegments()
	{
		return $this->segments;
	}

	public function getBlock($tag)
	{
		preg_match('#<!-- START ' . $tag . ' -->(.+?)<!-- END ' . $tag . ' -->#si', $this->content, $tor);
		$tor = str_replace('<!-- START ' . $tag . ' -->', "", $tor[0]);
		$tor = str_replace('<!-- END ' . $tag . ' -->', "", $tor);
		return $tor;
	}

	public function content()
	{
		return $this->content;
	}

}
?>