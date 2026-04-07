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

// Back end module — makes "Reps" appear under Content in the backend navigation
$GLOBALS['BE_MOD']['content']['reps'] = [
    'tables' => ['tl_rep'],
];

// Front end module category — the module type itself is registered via
// the #[AsFrontendModule] attribute on FindYourRepController, but we still
// need to declare the category label key used in that attribute.
// (No $GLOBALS['FE_MOD'] entry needed; the attribute handles registration.)

// Model
$GLOBALS['TL_MODELS']['tl_rep'] = \Bcs\MadridFindRepBundle\Model\RepModel::class;
