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

// Front end module — registered the classic way because we extend \Contao\Module
// (not AbstractFrontendModuleController), so the #[AsFrontendModule] attribute
// approach is not applicable here.
$GLOBALS['FE_MOD']['madrid_find_your_rep']['mod_find_your_rep'] = \Bcs\MadridFindRepBundle\Controller\FrontendModule\FindYourRepController::class;

// Model
$GLOBALS['TL_MODELS']['tl_rep'] = \Bcs\MadridFindRepBundle\Model\RepModel::class;
