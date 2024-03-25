<?php

function slugify($string){
$preps = array('in', 'at', 'on', 'by', 'into', 'off', 'onto', 'from', 'to', 'with', 'a', 'an', 'the', 'using', 'for');
	$pattern = '/\b(?:' . join('|', $preps) . ')\b/i';
	$string = preg_replace($pattern, '', $string);
$string = preg_replace('~[^\\pL\d]+~u', '-', $string);
$string = trim($string, '-');
$string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
$string = strtolower($string);
$string = preg_replace('~[^-\w]+~', '', $string);
return $string;

/*makeSlug(){
	let make_slug = this.title.replace(/\s+/g,"-")
	.replace(/[^\u0E00-\u0E7F\w\-]+/g,'')            
	.replace(/\-\-+/g,'-')
	.replace(/^-+/,'')
	.toLowerCase()
   return this.slug = make_slug
}
*/
}
