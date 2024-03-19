<?php

defined('_JEXEC') or die;


class PlgSystemConvertformsidchanger extends JPlugin {

	public function onContentPrepare($context, &$article, &$params, $page = 0) 	{
		 //Don't run this plugin when the content is being indexed
		if ($context == 'com_finder.indexer')	{
			return true;
		}


		// Check if the configured parameter key was transmitted via POST and if the given value of this key is a valid integer
		if(isset($_POST[$this->params->get('parameterName')]) && is_int(intval($_POST[$this->params->get('parameterName')]))) {
			$formid = $_POST[$this->params->get('parameterName')];
		}
		else {
			/*
			 * TODO Change behaviour from formid=0 to redirect to default address
			 */
			$formid = 0;
			
		}

		if(isset($_POST['uid']) && is_int(intval($_POST['uid']))) {
			// Parameter uid is set and it's a valid value
			$uid = $_POST['uid'];

			// Get user details from database by given uid

			// Get a db connection.
			$db = JFactory::getDbo();

			// Create a new query object.
			$query = $db->getQuery(true);

			// Select all records from the user profile table where key begins with "custom.".
			// Order it by the ordering field.
			$query->select($db->quoteName(array('firstname', 'lastname', 'telefonnummer')));
			$query->from($db->quoteName('#__jsn_users'));
			$query->where($db->quoteName('id') . ' = ' . $db->quote($uid));
			$query->order('lastname ASC');

			// Reset the query using our newly populated query object.
			$db->setQuery($query);

			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			$results = $db->loadObjectList();
		}
		else {
			$results = NULL;
		}

    	// Search for this tag in the content
		//$regex = "#{convertforms (.*?)}#s";
		$regex = "~{convertforms (\d*)}~";
		$replace = "{convertforms $formid}";

		// Replace "old" tag by "new" one
		if(!empty($formid)) {
			$article->text = preg_replace($regex, $replace, $article->text);
		}

		// Check if uid and formid are set and get user specific name
		if(!is_null($results)) {
			if(count($results) == 1 && !empty($formid) && $formid >> 0) {
				$name = $results[0]->firstname . ' ' . $results[0]->lastname;
			}
		}
		else {
			$name = $this->params->get('defaultRecipientName');
		}

		// Replace default name by user specific name
		$regex = "~{recipientname}~";
		$replace = $name;
		//$replace = 'abc123';

		$article->text = preg_replace($regex, $replace, $article->text);
	}
}
