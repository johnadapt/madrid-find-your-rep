<?php

/**
 * Bright Cloud Studio's Find Your Rep
 *
 * Copyright (C) 2023 Bright Cloud Studio
 *
 * @package    bright-cloud-studio/frasch-find-your-rep
 * @link       https://www.brightcloudstudio.com/
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

/* Register the classes */
ClassLoader::addClasses(array
(
      'Bcs\Module\ModFindYourRep' 		=> 'system/modules/frasch_find_your_rep/library/Bcs/Module/ModFindYourRep.php',
      'Bcs\Backend\Reps' 		=> 'system/modules/frasch_find_your_rep/library/Bcs/Backend/Reps.php',
      'Bcs\Model\Rep' 			=> 'system/modules/frasch_find_your_rep/library/Bcs/Model/Rep.php',
      'Bcs\Reps'		 		=> 'system/modules/frasch_find_your_rep/library/Bcs/Reps.php'
));

/* Register the templates */
TemplateLoader::addFiles(array
(
      'mod_find_your_rep' 		=> 'system/modules/frasch_find_your_rep/templates/modules',
      'item_rep' 		=> 'system/modules/frasch_find_your_rep/templates/items',
));
