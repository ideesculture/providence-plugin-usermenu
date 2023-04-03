<?php
/* ----------------------------------------------------------------------
 * providencePluginUserMenuPlugin.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
 *
 * This plugin : IdéesCulture 2015-2023 www.ideesculture.com
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
				if (isset($pa_menu_bar['providencePluginUserMenu_menu'])) {
					$va_menu_items = $pa_menu_bar['providencePluginUserMenu_menu']['navigation'];
					if (!is_array($va_menu_items)) { $va_menu_items = array(); }
				} else {
					$va_menu_items = array();
				}

				$va_menu_items[Mes_preferences] = array(
						'displayName' => 'Mes préférences',
						"default" => array(
							'action' => '/system/Preferences/EditUIPrefs'
						)
					);

				$va_menu_items[Deconnexion] = array(
						'displayName' => 'Déconnexion',
						"default" => array(
							'action' => '/system/auth/logout'
						)
					);
				//this adds the CSS changing the style and content of the footer
				MetaTagManager::addLink('stylesheet', __CA_URL_ROOT__."/app/plugins/providencePluginUserMenu/css/providencePluginUserMenu.css",'text/css');
				if($this->opo_config->get('footer') == "1") {
					MetaTagManager::addLink('stylesheet', __CA_URL_ROOT__."/app/plugins/providencePluginUserMenu/css/providencePluginUserMenuFooter.css",'text/css');
				}
				
				
				
				print $va_views_images_path;

				$pa_menu_bar['providencePluginUserMenu_menu'] = array(
					'displayName' => "<img src='https://micg.ideesculture.fr/gestion/themes/default/graphics/icon-on-off.png' style='height: 14px'>",
					'navigation' => $va_menu_items
				);
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
