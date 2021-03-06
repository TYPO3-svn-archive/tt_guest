<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addStaticFile(TT_GUEST_EXT, 'static/css_style/', 'Guestbook CSS Style');
t3lib_extMgm::addStaticFile(TT_GUEST_EXT, 'static/old_style/', '(deprecated) Guestbook Old Style');

t3lib_div::loadTCA('tt_content');
if ($TYPO3_CONF_VARS['EXTCONF'][TT_GUEST_EXT]['useFlexforms'] == 1) {
	$TCA['tt_content']['types']['list']['subtypes_excludelist']['3'] = 'layout,select_key';
	$TCA['tt_content']['types']['list']['subtypes_addlist']['3'] = 'pi_flexform';
	t3lib_extMgm::addPiFlexFormValue('3', 'FILE:EXT:' . TT_GUEST_EXT . '/flexform_ds_pi.xml');
} else {
	$TCA['tt_content']['types']['list']['subtypes_excludelist']['3'] = 'layout';
}
t3lib_extMgm::addPlugin(Array('LLL:EXT:' . TT_GUEST_EXT . '/locallang_tca.php:tt_content.list_type_pi', '3'), 'list_type');


$TCA['tt_guest'] = Array (
	'ctrl' => Array (
		'label' => 'title',
		'default_sortby' => 'ORDER BY crdate DESC',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'delete' => 'deleted',
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.php:LGL.prependAtCopy',
		'enablecolumns' => Array (
			'disabled' => 'hidden'
		),
		'title' => 'LLL:EXT:' . TT_GUEST_EXT . '/locallang_tca.php:tt_content.list_type_pi',
		'iconfile' => PATH_BE_TTGUEST_REL . 'ext_icon.gif',
		'dynamicConfigFile' => PATH_BE_TTGUEST . 'tca.php'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tt_guest');
t3lib_extMgm::addToInsertRecords('tt_guest');
if (TYPO3_MODE == 'BE') {
	$GLOBALS['TBE_MODULES_EXT']['xMOD_db_new_content_el']['addElClasses']['tx_ttguest_wizicon'] =
		PATH_BE_TTGUEST . 'class.tx_ttguest_wizicon.php';
}

t3lib_extMgm::addLLrefForTCAdescr('tt_guest', 'EXT:' . TT_GUEST_EXT . '/locallang_csh_ttguest.php');

?>