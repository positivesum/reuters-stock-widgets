<?php
if (!class_exists('cfct_module_investmentcalculator')) {
	class cfct_module_investmentcalculator extends cfct_build_module {
		/**
		 * Set up the module
		 */
		 
		public function __construct() {
			$this->pluginDir		= basename(dirname(__FILE__));
			$this->pluginPath		= WP_PLUGIN_DIR . '/' . $this->pluginDir;
			$this->pluginUrl 		= WP_PLUGIN_URL.'/'.$this->pluginDir;	
			
			$opts = array(
				'url' => $this->pluginUrl, 
				'view' => 'reuters-stock-widgets/calculator-view.php',				
				'description' => __('Allows to calculate stock performance based on investment amount or number of owned shares.', 'carrington-build'),
				'icon' => 'reuters-stock-widgets/calculator-icon.png'
			);
			
			// use if this module is to have no user configurable options
			// Will suppress the module edit button in the admin module display
			# $this->editable = false 
			
			parent::__construct('cfct-investmentcalculator', __('Investment Calculator', 'carrington-build'), $opts);
		}

		/**
		 * Display the module content in the Post-Content
		 * 
		 * @param array $data - saved module data
		 * @return array string HTML
		 */
		public function display($data) {
			global $cfct_build;			
			$title = esc_html($data[$this->get_field_id('content')]);
			if (empty($title)) {
				$title = 'Investment Calculator';
			}
		
			$cfct_build->loaded_modules[$this->basename] = $this->pluginPath;
			$cfct_build->module_paths[$this->basename] = $this->pluginPath;
			$cfct_build->module_urls[$this->basename] = $this->pluginUrl;

			return $this->load_view($data, compact('title'));		
		}
	
		/**
		 * Build the admin form
		 * 
		 * @param array $data - saved module data
		 * @return string HTML
		 */
		public function admin_form($data) {
			$output = '<div>
							<label for="'.$this->get_field_id('content').'">'.__('Title', 'carrington-build').'</label>
							<input type="text" name="'.$this->get_field_name('content').'" id="'.$this->get_field_id('content').'" value="'.(!empty($data[$this->get_field_id('content')]) ? esc_attr($data[$this->get_field_id('content')]) : '').'" />
						</div>';
			return $output;
		}

		/**
		 * Return a textual representation of this module.
		 *
		 * @param array $data - saved module data
		 * @return string text
		 */
		public function text($data) {
			return strip_tags($data[$this->get_field_id('content')]);
		}

		/**
		 * Add custom css to the post/page admin
		 * OPTIONAL: omit this method if you're not using it
		 *
		 * @return string CSS
		 */
		public function admin_css() {
			return '';
		}		
	}
	
	// register the module with Carrington Build
	cfct_build_register_module('cfct-module-investmentcalculator', 'cfct_module_investmentcalculator');
}

?>