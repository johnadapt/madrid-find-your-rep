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

  
namespace Bcs\Module;
 
use Bcs\Model\Rep;
use Bcs\Reps; 
use Contao\System;
use Contao\FrontendTemplate;

 
class ModFindYourRep extends \Contao\Module
{
 
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_find_your_rep';
 
	protected $arrStates = array();
 
	/**
	 * Initialize the object
	 *
	 * @param \ModuleModel $objModule
	 * @param string       $strColumn
	 */
	public function __construct($objModule, $strColumn='main')
	{
		parent::__construct($objModule, $strColumn);
		$this->arrStates = $this->getStates();
	}
	
    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (System::getContainer()->getParameter('kernel.project_dir') == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
 
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['mod_find_your_rep'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;
 
            return $objTemplate->parse();
        }
 
        return parent::generate();
    }
 
 
    /**
     * Generate the module
     */
    protected function compile()
    {
        $objLocation = Rep::findBy('published', '1');

        $rand_ver = rand(1,9999);
        $GLOBALS['TL_BODY']['find_your_rep'] = '<script src="bundles/bcsmadridfindrep/js/mod_find_your_rep.js?v='.$rand_ver.'"></script>';
		$GLOBALS['TL_JAVASCRIPT']['map_js_base'] = 'bundles/bcsmadridfindrep/js/raphael.min.js';
		$GLOBALS['TL_JAVASCRIPT']['map_js_settings'] = 'bundles/bcsmadridfindrep/js/settings.js';
		$GLOBALS['TL_JAVASCRIPT']['map_js_paths'] = 'bundles/bcsmadridfindrep/js/paths.js';
		$GLOBALS['TL_JAVASCRIPT']['map_js_map'] = 'bundles/bcsmadridfindrep/js/map.js';
		$GLOBALS['TL_JAVASCRIPT']['map_js_init'] = 'bundles/bcsmadridfindrep/js/initialize.js';
        $GLOBALS['TL_CSS']['maps'] = 'bundles/bcsmadridfindrep/css/map.css';
		
  		// Return if no pending items were found
  		if (!$objLocation)
  		{
  			$this->Template->empty = 'No Locations Found';
  			return;
  		}

        // Stores all of our Reps, besides corporate
		$arrReps = array();
		$rep_id = 0;
		
		// Generate List
		while ($objLocation->next())
		{
            
            $arrLocation = array();
             
            // check if our product_line data contains corporate
            $product_line = unserialize($objLocation->product_line);
            
            
            $arrLocation['rep_name'] 			= $objLocation->rep_name;
			$arrLocation['company_name']		= $objLocation->company_name;
			$arrLocation['region']              = $objLocation->region;
			$arrLocation['address'] 			= $objLocation->address;
			$arrLocation['city']                = $objLocation->city;
			$arrLocation['address_state'] 		= $objLocation->address_state;
            $arrLocation['zip']                 = $objLocation->zip;
            $arrLocation['phone_number']        = $objLocation->phone_number;
            $arrLocation['alt_phone_number']    = $objLocation->alt_phone_number;
            $arrLocation['email']               = $objLocation->email;
            $arrLocation['website'] 			= $objLocation->website;
            $arrLocation['product_line']        = $product_line;
			$arrLocation['state']               = unserialize($objLocation->state);
			$strItemTemplate = ($this->locations_customItemTpl != '' ? $this->locations_customItemTpl : 'item_rep');
			$objTemplate = new FrontendTemplate($strItemTemplate);
			$objTemplate->setData($arrLocation);
			$arrReps[$rep_id] = $objTemplate->parse();
            $rep_id++;

		}

        $this->Template->reps = $arrReps;
		
	}

	public function generateSelectOptions($blank = TRUE) {
		$strUnitedStates = '<optgroup label="United States">';
		foreach ($this->arrStates['United States'] as $abbr => $state) {
		    $strUnitedStates .= '<option value="' .$abbr .'">' .$state .'</option>';

		}
		$strUnitedStates .= '</optgroup>';
		return ($blank ? '<option value="">Select Location...</option>' : '') .$strUnitedStates;
	}
	
	function sortByState($a, $b) {
		if ($a['Name'] == $b['Name']) {
			return 0;
		}
		return ($a['Name'] < $b['Name']) ? -1 : 1;
	}
	
	
	/** Utility function to get an array of our States */
	function getStates()
    	{		
        	return array(
			'United States' => array(
				'alabama' => 'Alabama',
				'alaska' => 'Alaska',
				'arizona' => 'Arizona',
				'arkansas' => 'Arkansas',
				'california' => 'California',
				'colorado' => 'Colorado',
				'connecticut' => 'Connecticut',
				'delaware' => 'Delaware',
				'florida' => 'Florida',
				'georgia' => 'Georgia',
				'hawaii' => 'Hawaii',
				'idaho' => 'Idaho',
				'illinois' => 'Illinois',
				'indiana' => 'Indiana',
				'iowa' => 'Iowa',
				'kansas' => 'Kansas',
				'kentucky' => 'Kentucky',
				'louisiana' => 'Louisiana',
				'maine' => 'Maine',
				'maryland' => 'Maryland',
				'massachusetts' => 'Massachusetts',
				'michigan' => 'Michigan',
				'minnesota' => 'Minnesota',
				'mississippi' => 'Mississippi',
				'missouri' => 'Missouri',
				'montana' => 'Montana',
				'nebraska' => 'Nebraska',
				'nevada' => 'Nevada',
				'new_hampshire' => 'New Hampshire',
				'new_jersey' => 'New Jersey',
				'new_mexico' => 'New Mexico',
				'new_york' => 'New York',
				'north_carolina' => 'North Carolina',
				'north_dakota' => 'North Dakota',
				'ohio' => 'Ohio',
				'oklahoma' => 'Oklahoma',
				'oregon' => 'Oregon',
				'pennsylvania' => 'Pennsylvania',
				'rhode_island' => 'Rhode Island',
				'south_carolina' => 'South Carolina',
				'south_dakota' => 'South Dakota',
				'tennessee' => 'Tennessee',
				'texas' => 'Texas',
				'utah' => 'Utah',
				'vermont' => 'Vermont',
				'virginia' => 'Virginia',
				'washington' => 'Washington',
				'west_virginia' => 'West Virginia',
				'wisconsin' => 'Wisconsin',
				'wyoming' => 'Wyoming',
                'washington_dc' => 'Washington, D.C.',
				'puerto_rico' => 'Puerto Rico'),
		);
	}

	
	
	

} 
