<?php
return array(

	'user/register' => 'user/register',
	'user/login' => 'user/login',
	'user/logout' => 'user/logout',

	'cabinet/edit' => 'cabinet/edit',
	'cabinet/upload' => 'cabinet/upload',
	'cabinet/list' => 'cabinet/list',
	'cabinet/delete/([0-9]+)' => 'cabinet/delete/$1',
	'cabinet/download/([0-9]+)' => 'cabinet/download/$1',
	'cabinet' => 'cabinet/index',

	'' => 'site/index',
);