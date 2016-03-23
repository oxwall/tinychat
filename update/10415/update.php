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


$groupId = $authorization->findGroupIdByName('tinychat');

if( !$groupId )
{
    $group = new BOL_AuthorizationGroup();
    $group->setName('tinychat');
    $group->setModerated(true);
    BOL_AuthorizationService::getInstance()->addGroup($group, array());
    $groupId = $authorization->findGroupIdByName('tinychat');
}

$action = $authorization->findAction('tinychat', 'use_tiny_chat');

if ( !$action )
{
    $action = new BOL_AuthorizationAction();
    $action->name = 'use_tiny_chat';
    $action->groupId = $groupId;
    $action->availableForGuest = false;

    $authorization->addAction($action, array('en' => 'Use tiny chat'));
}