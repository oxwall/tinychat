<?php

/**
 * Copyright (c) 2012, Skalfa LLC
 * All rights reserved.

 * ATTENTION: This commercial software is intended for use with Oxwall Free Community Software http://www.oxwall.org/
 * and is licensed under Oxwall Store Commercial License.
 * Full text of this license can be found at http://www.oxwall.org/store/oscl
 */


Updater::getLanguageService()->importPrefixFromZip(dirname(__FILE__).DS.'langs.zip', 'tinychat');

$authorization = Updater::getAuthorizationService();
$logger = Updater::getLogger();

try
{
    $groupId = $authorization->findGroupIdByName('tinychat');

    if ( $groupId )
    {
        $action = new BOL_AuthorizationAction();
        $action->name = 'use_tiny_chat';
        $action->groupId = $groupId;
        $action->availableForGuest = false;

        $authorization->addAction($action, array('en' => 'Use tiny chat'));
    }
}
catch ( Exception $e )
{
    $logger->addEntry($e->getMessage());
}

