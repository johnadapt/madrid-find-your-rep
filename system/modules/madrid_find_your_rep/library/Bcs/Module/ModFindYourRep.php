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

        $rand_ver = rand(1,9999);
        $GLOBALS['TL_BODY']['isotope_spec_sheet_pdf'] = '<script src="system/modules/madrid_find_your_rep/assets/js/mod_find_your_rep.js?v='.$rand_ver.'"></script>';
		
  		// Return if no pending items were found
  		if (!$objLocation)
  		{
  			$this->Template->empty = 'No Locations Found';
  			return;
  		}

        // Stores all of our Reps, besides corporate
		$arrReps = array();
		$rep_id = 0;
		
		// Stores all corporate Reps
		$arrRepsCorporate = array();
        $corp_rep_id = 0;
		
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
            $arrLocation['zip']                 = $objLocation->zip;
            $arrLocation['phone_number']        = $objLocation->phone_number;
            $arrLocation['alt_phone_number']    = $objLocation->alt_phone_number;
            $arrLocation['email']               = $objLocation->email;
            $arrLocation['website'] 			= $objLocation->website;
            $arrLocation['product_line']        = $product_line;
			$arrLocation['state']               = unserialize($objLocation->state);
            
            if(str_contains($objLocation->product_line, 'corporate')) {
                
    			$strItemTemplate = ($this->locations_customItemTpl != '' ? $this->locations_customItemTpl : 'item_rep');
    			$objTemplate = new \FrontendTemplate($strItemTemplate);
    			$objTemplate->setData($arrLocation);
    			$arrRepsCorporate[$corp_rep_id] = $objTemplate->parse();
                $corp_rep_id++;
                
            } else {
    
    			$strItemTemplate = ($this->locations_customItemTpl != '' ? $this->locations_customItemTpl : 'item_rep');
    			$objTemplate = new \FrontendTemplate($strItemTemplate);
    			$objTemplate->setData($arrLocation);
    			$arrReps[$rep_id] = $objTemplate->parse();
                $rep_id++;
                    
            }

		}

        $this->Template->reps_corporate = $arrRepsCorporate;
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
			'Canada' => array(
				'alberta' => 'Alberta',
				'british_columbia' => 'British Columbia',
                'manitoba' => 'Manitoba',
				'new_brunswick' => 'New Brunswick',
                'newfoundland' => 'Newfoundland',
				'nova_scotia' => 'Nova Scotia',
                'ontario' => 'Ontario',
                'prince_edward_island' => 'Prince Edward Island',
				'quebec' => 'Quebec',
				'saskatchewan' => 'Saskatchewan'),
		);
	}

	
	
	

} 
