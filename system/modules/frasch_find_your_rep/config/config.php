<?php

/**
 * Bright Cloud Studio's Find Your Rep
 *
 * Copyright (C) 2023 Bright Cloud Studio
 *
 * @package    bright-cloud-studio/madrid-find-your-rep
 * @link       https://www.brightcloudstudio.com/
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

/* Back end modules */
$GLOBALS['BE_MOD']['content']['reps'] = array(
	'tables' => array('tl_rep')
);

/* Front end modules */
$GLOBALS['FE_MOD']['madrid_find_your_rep']['mod_find_your_rep'] 	= 'Bcs\Module\ModFindYourRep';

/* Models */
$GLOBALS['TL_MODELS']['tl_rep'] = 'Bcs\Model\Rep';
