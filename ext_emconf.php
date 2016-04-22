<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "xsrf_protection"
 *
 * Auto generated by Extension Builder 2016-04-20
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'XSRF Protection',
	'description' => 'This extension provides a service for generating and valitation session tokens as a protection against XSRF.',
	'category' => 'services',
	'author' => 'Benedikt Ringlein',
	'author_email' => 'benedikt.ringlein@aoe.com',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0-6.2.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);