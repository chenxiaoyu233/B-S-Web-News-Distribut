<?php

class Page {
   public function genTag($tag, $content, $class, $id, $style, $indent) {
	  return $indent .'<' . $tag . ' class="' . $class . '" id="' . $id . '" style="' . $style . '">' . "\n" .
	  $indent . $content . "\n" .
	  $indent . '</' . $tag . '>' . "\n";
   }
   public function genTagFromArray($tag, $content, $prop, $indent){
	  $ret = $indent. "<$tag";
	  foreach($prop as $key => $val){
		 $ret = $ret . ' ' . $key . '="' . $val . '"';
	  }
	  $ret = $ret . ">\n";
	  $ret = $ret . $indent . $indent . $content . "\n";
	  $ret = $ret . $indent . "</$tag>\n";
	  return $ret;
   }
}

