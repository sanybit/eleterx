<?php
// Маршруты
return array (
	'^$' => 'portfolio/index', // пустая строка
	'eleterx/login' => 'eleterx/login',
	'eleterx/edit' => 'eleterx/edit',
	'eleterx' => 'eleterx/index',
	'(.*)' => '404', // любая строка
);
?>
