<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    madrid-find-your-rep
 * @license    LGPL-3.0+
 * @see        https://github.com/johnadapt/madrid-find-your-rep
 */

namespace Bcs\MadridFindRepBundle\Controller\FrontendModule;

use Bcs\MadridFindRepBundle\Model\RepModel;
use Contao\FrontendTemplate;
use Contao\Module;
use Contao\ModuleModel;
use Contao\StringUtil;
use Contao\System;

class FindYourRepController extends Module
{
    /**
     * Template name
     * @var string
     */
    protected $strTemplate = 'mod_find_your_rep';

    /**
     * Display a wildcard in the back end
     */
    public function generate(): string
    {
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();
        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            $objTemplate = new \Contao\BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### FIND YOUR REP ###';
            $objTemplate->title    = $this->headline;
            $objTemplate->id       = $this->id;
            $objTemplate->link     = $this->name;
            $objTemplate->href     = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;
            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate the module output
     */
    protected function compile(): void
    {
        // All scripts go into TL_BODY as plain synchronous script tags.
        // Contao 5.x adds 'defer' to TL_JAVASCRIPT entries. Deferred scripts run
        // after HTML parsing completes, but TL_BODY inline tags run as the body
        // is parsed — meaning a mix of deferred + inline tags has unpredictable
        // execution order. Putting everything in TL_BODY as raw tags guarantees
        // sequential synchronous loading in exactly the order listed below.
        $GLOBALS['TL_BODY']['map_js_raphael']  = '<script src="bundles/bcsmadridfindrep/js/raphael.min.js"></script>';
        $GLOBALS['TL_BODY']['map_js_settings'] = '<script src="bundles/bcsmadridfindrep/js/settings.js"></script>';
        $GLOBALS['TL_BODY']['map_js_paths']    = '<script src="bundles/bcsmadridfindrep/js/paths.js"></script>';
        $GLOBALS['TL_BODY']['map_js_map']      = '<script src="bundles/bcsmadridfindrep/js/map.js"></script>';
        $GLOBALS['TL_BODY']['map_js_init']     = '<script src="bundles/bcsmadridfindrep/js/initialize.js"></script>';
        $GLOBALS['TL_BODY']['find_your_rep']   = '<script src="bundles/bcsmadridfindrep/js/mod_find_your_rep.js"></script>';
        $GLOBALS['TL_CSS']['maps']             = 'bundles/bcsmadridfindrep/css/map.css';

        $objReps = RepModel::findBy('published', '1');

        if (!$objReps) {
            $this->Template->empty = 'No Locations Found';
            $this->Template->reps  = [];
            return;
        }

        $arrReps = [];

        while ($objReps->next()) {
            $arrLocation = [];

            $arrLocation['rep_name']         = $objReps->rep_name;
            $arrLocation['company_name']     = $objReps->company_name;
            $arrLocation['region']           = $objReps->region;
            $arrLocation['address']          = $objReps->address;
            $arrLocation['city']             = $objReps->city;
            $arrLocation['address_state']    = $objReps->address_state;
            $arrLocation['zip']              = $objReps->zip;
            $arrLocation['phone_number']     = $objReps->phone_number;
            $arrLocation['alt_phone_number'] = $objReps->alt_phone_number;
            $arrLocation['email']            = $objReps->email;
            $arrLocation['website']          = $objReps->website;
            // product_line is plain text — do NOT deserialize
            $arrLocation['product_line']     = $objReps->product_line;
            // state IS serialized (multi-checkbox)
            $arrLocation['state']            = StringUtil::deserialize($objReps->state, true);

            $strItemTemplate = 'item_rep';
            $objTemplate = new FrontendTemplate($strItemTemplate);
            $objTemplate->setData($arrLocation);
            $arrReps[] = $objTemplate->parse();
        }

        $this->Template->reps  = $arrReps;
        $this->Template->empty = '';
    }
}
