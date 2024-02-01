<?php
$class           = $args['classes'] ?? null;
$title           = $args['title'] ?? null;
$url           = $args['url'] ?? null;
$target           = $args['target'] ?? null;
$wrapper         = $args['wrapper'] ? $args['wrapper'] : null;


if ( $title ) {
	echo $wrapper ? "<div class='$wrapper'>" : null;
	$title_html = sprintf( '<a href="%s" class="%s" target="%s" >%s</a>',
		$url,
		$class,
		$target,
		$title
	);
	echo $title_html;
	echo $wrapper ? "</div>" : null;
} ?>


