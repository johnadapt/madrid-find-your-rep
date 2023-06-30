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

  
namespace Bcs\Module;
 
use Bcs\Model\Rep;
use Bcs\Reps; 
 
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
        if (TL_MODE == 'BE')
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

        if (!in_array('system/modules/frasch_find_your_rep/assets/js/mod_find_your_rep.js', $GLOBALS['TL_JAVASCRIPT'])) { 
            $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/frasch_find_your_rep/assets/js/mod_find_your_rep.js';
        }
		

		
  		// Return if no pending items were found
  		if (!$objLocation)
  		{
  			$this->Template->empty = 'No Locations Found';
  			return;
  		}

		$arrReps = array();
        $rep_id = 0;
		
		// Generate List
		while ($objLocation->next())
		{
            
			$arrLocation['rep_name'] 			= $objLocation->rep_name;
			$arrLocation['company_name']		= $objLocation->company_name;
			$arrLocation['region']              = $objLocation->region;
			$arrLocation['address'] 			= $objLocation->address;
			$arrLocation['city']                = $objLocation->city;
            $arrLocation['zip']                 = $objLocation->zip;
            $arrLocation['phone_number']        = $objLocation->phone_number;
            $arrLocation['alt_phone_number']    = $objLocation->alt_phone_number;
            $arrLocation['email']               = $objLocation->email;
            $arrLocation['website'] 			= $objLocation->website;
			
			$arrLocation['state']               = unserialize($objLocation->state);
			

			$strItemTemplate = ($this->locations_customItemTpl != '' ? $this->locations_customItemTpl : 'item_rep');
			$objTemplate = new \FrontendTemplate($strItemTemplate);
			$objTemplate->setData($arrLocation);
			$arrReps[$rep_id] = $objTemplate->parse();
            $rep_id++;
		}

        $this->Template->reps = $arrReps;
		
	}

	public function generateSelectOptions($blank = TRUE) {
		$strUnitedStates = '<optgroup label="United States">';
		$strCanada = '<optgroup label="Canada"><option value="CAN">All Provinces</option></optgroup>';
		foreach ($this->arrStates['United States'] as $abbr => $state) {
			if (!in_array($objLocation->state, array('AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT'))) {
				$strUnitedStates .= '<option value="' .$abbr .'">' .$state .'</option>';
			}
		}
		$strUnitedStates .= '</optgroup>';
		return ($blank ? '<option value="">Select Location...</option>' : '') .$strUnitedStates .$strCanada;
	}
	
	function sortByState($a, $b) {
		if ($a['Name'] == $b['Name']) {
			return 0;
		}
		return ($a['Name'] < $b['Name']) ? -1 : 1;
	}
	
	
	
	
	
	
	function getStates()
    	{		
        	return array(
			"United States" => array(
				'AL' => 'Alabama',
				'AK' => 'Alaska',
				'AZ' => 'Arizona',
				'AR' => 'Arkansas',
				'CA' => 'California',
				'CO' => 'Colorado',
				'CT' => 'Connecticut',
				'DE' => 'Delaware',
				'FL' => 'Florida',
				'GA' => 'Georgia',
				'HI' => 'Hawaii',
				'ID' => 'Idaho',
				'IL' => 'Illinois',
				'IN' => 'Indiana',
				'IA' => 'Iowa',
				'KS' => 'Kansas',
				'KY' => 'Kentucky',
				'LA' => 'Louisiana',
				'ME' => 'Maine',
				'MD' => 'Maryland',
				'MA' => 'Massachusetts',
				'MI' => 'Michigan',
				'MN' => 'Minnesota',
				'MS' => 'Mississippi',
				'MO' => 'Missouri',
				'MT' => 'Montana',
				'NE' => 'Nebraska',
				'NV' => 'Nevada',
				'NH' => 'New Hampshire',
				'NJ' => 'New Jersey',
				'NM' => 'New Mexico',
				'NY' => 'New York',
				'NC' => 'North Carolina',
				'ND' => 'North Dakota',
				'OH' => 'Ohio',
				'OK' => 'Oklahoma',
				'OR' => 'Oregon',
				'PA' => 'Pennsylvania',
				'RI' => 'Rhode Island',
				'SC' => 'South Carolina',
				'SD' => 'South Dakota',
				'TN' => 'Tennessee',
				'TX' => 'Texas',
				'UT' => 'Utah',
				'VT' => 'Vermont',
				'VA' => 'Virginia',
				'WA' => 'Washington',
				'WV' => 'West Virginia',
				'WI' => 'Wisconsin',
				'WY' => 'Wyoming',
				'AS' => 'American Samoa',
				'DC' => 'District of Columbia',
				'FM' => 'Federated States of Micronesia',
				'GU' => 'Guam',
				'MH' => 'Marshall Islands',
				'MP' => 'Northern Mariana Islands',
				'PW' => 'Palau',
				'PR' => 'Puerto Rico',
				'VI' => 'Virgin Islands'),
			"Canada" => array(
				"CAN" => "All Provinces")
		);
	}

	
	
	

} 
