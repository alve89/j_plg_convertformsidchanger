<?php

defined('_JEXEC') or die;

JLoader::register('ModHrzShowSingleUserHelper', JPATH_SITE . '/modules/mod_hrz_show_single_user/helper.php');



class PlgSystemConvertformsidchanger extends JPlugin {

	public function onContentPrepare($context, &$article, &$params, $page = 0) 	{
		 //Don't run this plugin when the content is being indexed
		if ($context == 'com_finder.indexer')	{
			return true;
		}
 
		$userSet = false;
		$formSet = false;
		$user = new stdClass();

		// Check if the configured parameter key was transmitted via POST and if the given value of this key is a valid integer
		if(isset($_GET[$this->params->get('parameterName')]) && is_int(intval($_GET[$this->params->get('parameterName')]))) {
			/*
			 * TODO Check why transport method was changed from GET to POST
			 * This also refers to the PHP script within the Convert Forms component!
			 */
			$formid = $_GET[$this->params->get('parameterName')];
			$formSet = true;
		}

		if(!$formSet) {
			/*
			 * TODO Redirect to default contact address
			 */
		}


		if(isset($_GET[$this->params->get('parameterNameUserId')]) && is_int(intval($_GET[$this->params->get('parameterNameUserId')]))) {
			/*
			 * Check wwhy changed transport method from GET to POST
			 */
			$uid = $_GET[$this->params->get('parameterNameUserId')];
			$userSet = true;
			
		}



		if(!$userSet) {
			/*
			 * TODO Redirect to default contact address
			 */
		}
		else {
			// Get user details from database by given uid

			// Load custom fields for the given user (specified by 'userid' in modules configuration)
			// a = fields
			// b = fields_values

			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select(array('a.name', 'b.value'));
			$query->from($db->quoteName('#__fields', 'a'));
			$query->join('INNER', $db->quoteName('#__fields_values', 'b') . ' ON ' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.field_id'));	
			$query->where($db->quoteName('b.item_id') . '='. $db->quote(intval($_GET[$this->params->get('parameterNameUserId')])));
			$db->setQuery((string) $query);
			$userDetails = $db->loadObjectList();
			
			

			ModHrzShowSingleUserHelper::translateUserDetails($user, $userDetails);
			$user->name = $user->firstName . ' ' .  $user->lastName;

		}

    	// Search for this tag in the content
		//$regex = "#{convertforms (.*?)}#s";
		$regex = "~{convertforms (\d*)}~";
		$replace = "{convertforms $formid}";

		// Replace "old" tag by "new" one
		if($formSet) {
			$article->text = preg_replace($regex, $replace, $article->text);
		}


		// Replace default name by user specific name
		$regex = "~{recipientname}~";
		$replace = $user->name;
		//$replace = 'abc123';

		$article->text = preg_replace($regex, $replace, $article->text);
	}
}
