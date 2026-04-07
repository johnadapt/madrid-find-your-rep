<?php

/**
 * Bright Cloud Studio's Find Your Rep
 *
 * Copyright (C) 2024 Bright Cloud Studio
 *
 * @package    bright-cloud-studio/madrid-find-your-rep
 * @link       https://www.brightcloudstudio.com/
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

// Back end module
$GLOBALS['BE_MOD']['content']['reps'] = [
    'tables' => ['tl_rep'],
];

// Model
$GLOBALS['TL_MODELS']['tl_rep'] = \Bcs\MadridFindRepBundle\Model\RepModel::class;
