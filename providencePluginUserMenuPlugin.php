<?php
/* ----------------------------------------------------------------------
 * mediaImportPlugin.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This source code is free and modifiable under the terms of
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */

	class providencePluginUserMenuPlugin extends BaseApplicationPlugin {
		# -------------------------------------------------------
		protected $description = 'Plugin for CollectiveAccess moving the content of the downside bar to a button';
		# -------------------------------------------------------
			private $opo_config;
			private $ops_plugin_path;
		# -------------------------------------------------------
		public function __construct($ps_plugin_path) {
			$this->ops_plugin_path = $ps_plugin_path;
			$this->description = _t('Deletes the black bar and adds a button on top of the screen to log out and more.');
			parent::__construct();
			$this->opo_config = Configuration::load($ps_plugin_path.'/conf/providencePluginUserMenu.conf');
		}
		# -------------------------------------------------------
		/**
		 * Override checkStatus() to return true - the providencePluginUserMenuPlugin always initializes ok... (part to complete)
		 */
		public function checkStatus() {
			return array(
				'description' => $this->getDescription(),
				'errors' => array(),
				'warnings' => array(),
				'available' => ((bool)$this->opo_config->get('enabled'))
			);
		}
		# -------------------------------------------------------
		/**
		 * Insert activity menu
		 */
		public function hookRenderMenuBar($pa_menu_bar) {
			if ($o_req = $this->getRequest()) {

                //we define the content of a new main menu item
				$va_menu_items = $pa_menu_bar['manage']['navigation'];

				$va_menu_items[Deconnexion] = array(
						'displayName' => 'Déconnexion',
						"default" => array(
							'action' => '/system/auth/logout'
						)
					);

                //this adds the CSS changing the style and content of the footer
                MetaTagManager::addLink('stylesheet', __CA_URL_ROOT__."/app/plugins/providencePluginUserMenu/css/providencePluginUserMenu.css",'text/css');

				$pa_menu_bar['manage']['navigation'] = $va_menu_items;
			}

			return $pa_menu_bar;
		}
		# -------------------------------------------------------
		/**
		 * Add plugin user actions
		 */
		static function getRoleActionList() {
			return array(
				'can_use_providencePluginUserMenu_plugin' => array(
						'label' => _t('Can use'),
						'description' => _t('User can use the plugin.')
					)
			);
		}

	}
?>
