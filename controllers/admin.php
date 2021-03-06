<?php

/**
 * This software is intended for use with Oxwall Free Community Software http://www.oxwall.org/ and is
 * licensed under The BSD license.

 * ---
 * Copyright (c) 2011, Oxwall Foundation
 * All rights reserved.

 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the
 * following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice, this list of conditions and
 *  the following disclaimer.
 *
 *  - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and
 *  the following disclaimer in the documentation and/or other materials provided with the distribution.
 *
 *  - Neither the name of the Oxwall Foundation nor the names of its contributors may be used to endorse or promote products
 *  derived from this software without specific prior written permission.

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * @author Sardar Madumarov <madumarov@gmail.com>
 * @package ow_plugins.tinychat
 * @since 1.0
 */
class TINYCHAT_CTRL_Admin extends ADMIN_CTRL_Abstract
{	
	public function __construct()
	{
        parent::__construct();
	}
    
	public function index()
	{
        $this->setPageHeading(OW::getLanguage()->text('tinychat', 'admin_index_heading'));
        $this->setPageHeadingIconClass('ow_ic_gear_wheel');

        $form = new Form('tinychat_settings');
        $element = new ColorField('color');
        $form->addElement($element);
        $submit = new Submit('submit');
        $submit->setValue(OW::getLanguage()->text('admin', 'save_btn_label'));
        $form->addElement($submit);

        if( OW::getRequest()->isPost() && $form->isValid($_POST) )
        {
            $data = $form->getValues();
            if( !empty($data['color']) && strlen(trim($data['color'])) > 0 )
            {
                $settings = (array)json_decode(OW::getConfig()->getValue('tinychat', 'setting_vars'));
                $settings['color'] = $data['color'];
                OW::getConfig()->saveConfig('tinychat', 'setting_vars', json_encode($settings));
                OW::getFeedback()->info(OW::getLanguage()->text('tinychat', 'admin_index_form_save_success_message'));
            }
            else
            {
                OW::getFeedback()->error(OW::getLanguage()->text('tinychat', 'admin_index_form_save_error_message'));
            }

            $this->redirect();
        }

        $settingsJson = OW::getConfig()->getValue('tinychat', 'setting_vars');
        $settingsArray = (array)json_decode($settingsJson);

        if ( empty($settingsArray['color']) )
        {
            $settingsArray['color'] = '#ffffff';
        }

        $element->setValue($settingsArray['color']);
        $this->addForm($form);
	}
}