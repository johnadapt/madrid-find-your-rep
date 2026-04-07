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

        // Maps state key (e.g. 'st1') to array of HTML comment strings.
        // Populated while rendering rep items and passed to the module template
        // as JSON, so map.setComment() can be called after map is initialised.
        $arrMapComments = [];

        $stateKeyMap = [
            'alabama' => 'st1', 'alaska' => 'st2', 'arizona' => 'st3',
            'arkansas' => 'st4', 'california' => 'st5', 'colorado' => 'st6',
            'connecticut' => 'st7', 'delaware' => 'st8', 'washington_dc' => 'st9',
            'florida' => 'st10', 'georgia' => 'st11', 'hawaii' => 'st12',
            'idaho' => 'st13', 'illinois' => 'st14', 'indiana' => 'st15',
            'iowa' => 'st16', 'kansas' => 'st17', 'kentucky' => 'st18',
            'louisiana' => 'st19', 'maine' => 'st20', 'maryland' => 'st21',
            'massachusetts' => 'st22', 'michigan' => 'st23', 'minnesota' => 'st24',
            'mississippi' => 'st25', 'missouri' => 'st26', 'montana' => 'st27',
            'nebraska' => 'st28', 'nevada' => 'st29', 'new_hampshire' => 'st30',
            'new_jersey' => 'st31', 'new_mexico' => 'st32', 'new_york' => 'st33',
            'north_carolina' => 'st34', 'north_dakota' => 'st35', 'ohio' => 'st36',
            'oklahoma' => 'st37', 'oregon' => 'st38', 'pennsylvania' => 'st39',
            'rhode_island' => 'st40', 'south_carolina' => 'st41', 'south_dakota' => 'st42',
            'tennessee' => 'st43', 'texas' => 'st44', 'utah' => 'st45',
            'vermont' => 'st46', 'virginia' => 'st47', 'washington' => 'st48',
            'west_virginia' => 'st49', 'wisconsin' => 'st50', 'wyoming' => 'st51',
        ];

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

            // Build the tooltip HTML for each assigned state so we can call
            // map.setComment() AFTER map is initialised (via mapComments JSON).
            $repHtml  = '<div class="rep_wrap">';
            if ($objReps->region)           { $repHtml .= '<p class="territory">'   . htmlspecialchars($objReps->region)                                                  . '</p>'; }
            if ($objReps->rep_name)         { $repHtml .= '<p class="rep_name">'    . htmlspecialchars($objReps->rep_name)                                                . '</p>'; }
            if ($objReps->company_name)     { $repHtml .= '<p class="company_name">'. htmlspecialchars($objReps->company_name)                                            . '</p>'; }
            if ($objReps->address)          { $repHtml .= '<p class="address">'     . htmlspecialchars($objReps->address) . '<br>' . htmlspecialchars($objReps->city) . ', ' . htmlspecialchars($objReps->address_state) . '&nbsp;&nbsp;' . htmlspecialchars($objReps->zip) . '</p>'; }
            if ($objReps->phone_number)     { $repHtml .= '<p class="phone_number">Phone: <a href="tel:' . htmlspecialchars($objReps->phone_number) . '">' . htmlspecialchars($objReps->phone_number) . '</a></p>'; }
            if ($objReps->alt_phone_number) { $repHtml .= '<p class="alt_phone_number">Alt Phone: <a href="tel:' . htmlspecialchars($objReps->alt_phone_number) . '">' . htmlspecialchars($objReps->alt_phone_number) . '</a></p>'; }
            if ($objReps->email)            { $repHtml .= '<p class="email">Email: <a href="mailto:' . htmlspecialchars($objReps->email) . '">' . htmlspecialchars($objReps->email) . '</a></p>'; }
            if ($objReps->website)          { $repHtml .= '<p class="email">Website: <a href="' . htmlspecialchars($objReps->website) . '" target="_blank" rel="nofollow">' . htmlspecialchars($objReps->website) . '</a></p>'; }
            $repHtml .= '</div>';

            foreach ($arrLocation['state'] as $stateName) {
                $stateKey = $stateKeyMap[$stateName] ?? null;
                if ($stateKey) {
                    $arrMapComments[$stateKey][] = $repHtml;
                }
            }
        }

        $this->Template->reps        = $arrReps;
        $this->Template->empty       = '';
        $this->Template->mapComments = json_encode($arrMapComments);
    }
}
