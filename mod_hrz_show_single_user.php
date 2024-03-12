<?php

// No direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';


	// if($params->get('useSpecialInfomation')) {
	// 	// $db = JFactory::getDBO();
	// 	// $query = $db->getQuery(true);
	// 	// $query->select($db->quoteName('#__categories.title'));
	// 	// $query->from($db->quoteName('#__categories'));
	// 	// $query->where($db->quoteName('#__categories.id') . '=' . $db->quote($id));
	// 	// $db->setQuery((string) $query);
	// 	// $category = $db->loadResult();
	// 	// $user->area = $category;
	// 	$user->department = $params->get('department');
	// 	$user->role = $params->get('role');
	// }
	// else {
	// 	$user->area = $user->get('bereich');
	// 	$user->department = $user->get('abteilung');
	// 	$user->role = $user->get('position');
	// }

	// if(!empty($user->getValue('kontaktseite'))) {
	// 	// Kontaktseite IST definiert
	// 	if(!empty($user->getValue('convert_forms_contact_id')) && !empty($params->get('parameterName'))) {
	// 		$user->kontaktadresse = $user->getValue('kontaktseite') . '?' . $params->get('parameterName') . '=' . $user->getValue('convert_forms_contact_id');
	// 	}
	// 	else {

	// 		$user->kontaktadresse = $user->getValue('kontaktseite');
	// 	}
	// }
	// else {
	// 	// Kontaktseite ist NICHT definiert
	// 	if(!empty($user->getValue('convert_forms_contact_id')) && !empty($params->get('parameterName'))) {
	// 		$user->kontaktadresse = $params->get('defaultContactAddress') . '?' . $params->get('parameterName') . '=' . $user->getValue('convert_forms_contact_id');
	// 	}
	// 	else {
	// 		$user->kontaktadresse = $params->get('defaultContactAddress');
	// 	}

	// 	if(substr($user->getValue('avatar'),0,1) != '/') {
	// 		$user->avatar = '/'.$user->getValue('avatar');
	// 	}

	// }

	// !empty(parse_url($user->kontaktadresse)['query']) ? $user->kontaktadresse .= '&' : $user->kontaktadresse .= '?';
	// $user->kontaktadresse .= 'uid='.$user->getValue('id');




	// Render output
	require JModuleHelper::getLayoutPath('mod_hrz_show_single_user');

}
