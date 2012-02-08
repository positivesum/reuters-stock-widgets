<?php
/*
Plugin Name: Reuters Stock Widgets WordPress plugin
Plugin URI: http://positivesum.ca/
Description: This WordPress plugin would provide 4 Reuters Stock Widgets that can be added to pages via the Carrington Build interface.
Version: 0.1
Author: Alexander Yachmenev
Author URI: http://www.odesk.com/users/~~94ca72c849152a57
*/

function divNumbers($a, $b) {
	$result = 0;
	if ($b != 0){
		$result = $a / $b;
	}
	return $result;
}

if ( !class_exists( 'The_Reuters_Stock_Widgets' ) ) {
	class The_Reuters_Stock_Widgets {
		public $pluginUrl = null;
		public $compid = null;
		public $StockSymbol = null;
		public $Company = null;
		public $Class = null;
		public $Ticker  = null;
		public $CurrencyLabel = null;			
		public $CurrencyLabelSuffix = null;
		public $Exchange = null;
		public $Trade = null;
		public $Change = null;
		public $PercentOfChange = null;						
		public $Volume = null;
		public $Open = null;
		public $PreviousClose = null;			
		public $High = null;	
		public $Low = null;	
		public $FiftyTwoWeekHigh = null;	
		public $FiftyTwoWeekLow = null;	
		public $Date = null;	
				
		function __construct( ){
			$this->pluginDir		= basename(dirname(__FILE__));
			$this->pluginPath		= WP_PLUGIN_DIR . '/' . $this->pluginDir;
			$this->pluginUrl 		= WP_PLUGIN_URL.'/'.$this->pluginDir;
			$this->compid 			= get_option('compid');
			$this->StockSymbol 			= get_option('stock_symbol');
			$arrData = $this->get_stock_quote($this->compid);
			if ($arrData) {
				extract($arrData, EXTR_SKIP);
				extract($arrData['@attributes'], EXTR_SKIP);
				
				// Percent of Change = (change / (last � change )) * 100
				$PercentOfChange =  round(divNumbers($Change, ($Trade - $Change)) * 100, 2);		
			
				$this->Company = $Company;
				$this->Class = $Class;
				// $this->Ticker = $Ticker;
				$this->Ticker = $DataProviderInfo->DataProvider->Key;
//				$this->Ticker = 'TRI';
				
				$this->CurrencyLabel = $CurrencyLabel;			
				$this->CurrencyLabelSuffix = $CurrencyLabelSuffix;
				$this->Exchange = $Exchange;
				$this->Trade = $Trade;
				$this->Change = $Change;
				$this->PercentOfChange = $PercentOfChange;						
				$this->Volume = $Volume;
				$this->Open = $Open;
				$this->PreviousClose = $PreviousClose;			
				$this->High = $High;	
				$this->Low = $Low;	
				$this->FiftyTwoWeekHigh = $FiftyTwoWeekHigh;	
				$this->FiftyTwoWeekLow = $FiftyTwoWeekLow;	
				$this->Date = $Date;	
			}

			### Function: Init StockQuotes Widget
			add_action('widgets_init', array(&$this, 'widget_stockquotes_init'));
			add_action('cfct-modules-loaded',  array(&$this, 'widget_stockquotes_load'));

		}

		function widget_stockquotes_load() {
			require_once($this->pluginPath . "/stockquote.php");
			require_once($this->pluginPath . "/stockchart.php");
			require_once($this->pluginPath . "/pricelookup.php");
			require_once($this->pluginPath . "/calculator.php");
			require_once($this->pluginPath . "/ticker.php");							
		}	
		
		function widget_stockquotes_init() {
			add_action('template_redirect', array(&$this, 'widget_stockquotes_template_redirect'));		
			add_action('wp_ajax_widget_stockquotes', array(&$this, 'widget_stockquotes_ajax'));	
			add_action('wp_ajax_nopriv_widget_stockquotes', array(&$this, 'widget_stockquotes_ajax')); // 
			
			add_action('admin_menu', array(&$this, 'widget_stockquotes_options_menu'));

			### Internationalizing
			$plugin_dir = basename(dirname(__FILE__));
			load_plugin_textdomain('reuters-stock-widgets', null, $plugin_dir.'/languages');

		}

		function set_option ($option_name, $newvalue) {
			if ( get_option($option_name)  != $newvalue) {
				update_option($option_name, $newvalue);
			} else {
				$deprecated=' ';
				$autoload='no';
				add_option($option_name, $newvalue);
			}		
		} 		
		
		function widget_stockquotes_options_menu() {
			if ( ! current_user_can('manage_options') )
				return;
			/* adds our admin panel */
			$page = add_options_page('Reuters Stock', 'Reuters Stock', 'manage_options', 'widget-stockquotes-options',  array(&$this, 'widget_stockquotes_plugin_options'));

			if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'widget-stockquotes-options') {
				check_admin_referer('widget-stockquotes-options');
				$this->set_option('compid', $_REQUEST['compid']);
				$this->set_option('stock_symbol', $_REQUEST['stock_symbol']);
			}	
		}		

		function widget_stockquotes_plugin_options() {
			if ( ! current_user_can( 'manage_options' ) )
				wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
			?>		
			<div class="wrap">
			<?php screen_icon(); ?>
			<h2>Reuters Stock Settings</h2>
			<?php if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'widget-stockquotes-options')  { ?>
				<div id="message" class="updated"><p>Reuters Stock Settings are updated</p></div>
			<?php }	?>		
			
			<form method="post" action="">		
			<input type="hidden" name="action" value="widget-stockquotes-options" />		
			<?php wp_nonce_field('widget-stockquotes-options'); ?>		
			<table class="form-table">
			<tr valign="top">
			<th scope="row">The company ID, which will be assigned to company by Thomson Reuters</th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span>The company ID, which will be assigned to company by Thomson Reuters</span></legend>
					<label for="compid"><?php _e('The company ID:'); ?></label>
					<input id="compid" name="compid" type="text" value="<?php echo get_option('compid'); ?>" size="6" />
				</fieldset>
			</td>
			</tr>
			<tr valign="top">
			<th scope="row">The stock symbol to provide information for</th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span>The stock symbol to provide information for</span></legend>
					<label for="stock_symbol"><?php _e('Stock symbol:'); ?></label>
					<input id="stock_symbol" name="stock_symbol" type="text" value="<?php echo get_option('stock_symbol'); ?>" size="6" />
				</fieldset>
			</td>			
			</tr>
			</table>	
				<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
				</p>
			</form>	
			</div>
			<?php	
		}
		
		function widget_stockquotes_template_redirect() {
			if(is_admin()) return;
			wp_enqueue_style('reuters-stock-widgets', $this->pluginUrl . '/css/reuters-stock-widgets.css' );	
			wp_enqueue_style('jquery-ui-datepicker', $this->pluginUrl . '/css/ui.datepicker.css' );	
			// wp_enqueue_style('jquery.countdown', $this->pluginUrl . '/css/jquery.countdown.css' );	
			wp_enqueue_script('jquery-ui-datepicker', $this->pluginUrl . '/js/ui.datepicker.min.js', array('jquery', 'jquery-ui-core'), '1.0');	
			wp_enqueue_script('jquery.countdown', $this->pluginUrl . '/js/jquery.countdown.js', array('jquery'), '1.0');	
			wp_enqueue_script('reuters-stock-widgets', $this->pluginUrl . '/js/reuters-stock-widgets.js');	
		}

		function widget_stockquotes_ajax() {
			$response = array();
			$action = isset( $_REQUEST['operation'] ) ? $_REQUEST['operation'] : 'lookup';

			switch ( $action ) {
				case 'lookup':
					$arg = array (
						'compid' => $_REQUEST['compid'],				 
						'reqdate' => $_REQUEST['reqdate'],
						'symb' => $_REQUEST['symb'],
					);		
					$result = $this->get_historical_price_lookup($arg);
				break;
				case 'calcinvestment':
					$arg = array (
						'compid' => $_REQUEST['compid'],				 
						'reqdate' => $_REQUEST['reqdate'],
						'symb' => $_REQUEST['symb'],
						'amountinvested' => $_REQUEST['amountinvested'],
						'numberofsharespurchased' => $_REQUEST['numberofsharespurchased'],						
					);		
					$result = $this->calc_investment($arg);
				break;
				case 'ticker':
					$arrData = $this->get_stock_quote($this->compid);
					if (!$arrData) {
						$response['error'] = 'cannot receive stock quote information';
						$result = '';
					} else {
						$result = $arrData;
					}
				break;				
			}
			$response['result'] = $result;
			echo (json_encode($response));
			die();				
		}		

		function get_stock_quote($compid) {
			$url = sprintf("http://xml.corporate-ir.net/irxmlclient.asp?compid=%s&reqtype=quotes", $compid);
			$ch = curl_init();
			$timeout = 10;
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_URL, $url);
			$fp = curl_exec($ch);
			curl_close($ch);
			if (strpos($fp, 'CorpMasterID') === false) {
				return false;
			} else {
				$xmlObj = simplexml_load_string($fp);
				$arrData = get_object_vars($xmlObj->StockQuotes->Stock_Quote);
				return $arrData;
			}			
		}

		function get_stock_chart($compid) {
			$url = sprintf("http://xml.corporate-ir.net/irxmlclient.asp?compid=%s&reqtype=quotes", $compid);
			$ch = curl_init();
			$timeout = 10;
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_URL, $url);
			$fp = curl_exec($ch);
			curl_close($ch);

			if(strpos($fp, 'CorpMasterID') === false) {
				return false;
			}
			else {
				$xmlObj = simplexml_load_string($fp);
				$arrData = get_object_vars($xmlObj->StockQuotes->Stock_Quote);
				return $arrData;
			}
		}
		
		function get_historical_price_lookup($args = '') {
			$yesterday = date("m/d/Y", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));	
			
			$defaults = array(
				'compid' => $this->compid,
				'reqdate' => $yesterday, // date("m/d/Y")
				'symb' => $this->Ticker,
			);
			
			$r = wp_parse_args( $args, $defaults );
			extract( $r, EXTR_SKIP );
			$url = sprintf("http://xml.corporate-ir.net/irxmlclient.asp?compid=%s&reqtype=histquote&reqdate=%s&symb=%s", $compid, $reqdate, $symb);
			$ch = curl_init();
			$timeout = 10;
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_URL, $url);
			$fp = curl_exec($ch);
			curl_close($ch);

			$xmlObj = simplexml_load_string($fp);
			$arrData = get_object_vars($xmlObj->HistoricalQuotes->HistoricalQuote);
			
			if($xmlObj->HistoricalQuotes->HistoricalQuote->Comment == "No Data Returned") {
				return false;
			}
			else {
				return $arrData;
			}
		}
		
		function calc_investment($args = '') {
			$yesterday = date("m/d/Y", mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));	
			$defaults = array(
				'compid' => $this->compid,
				'reqdate' => $yesterday,
				'amountinvested' => 0,
				'numberofsharespurchased' => '',
				'symb' => $this->Ticker,
			);

			$args = wp_parse_args( $args, $defaults );
			extract( $args, EXTR_SKIP );
			$timestamp = strtotime(str_replace($format, '-', $reqdate));
			if ($timestamp > time()) {
				$args['reqdate'] = $yesterday;
			}
			
			$arrDataLast = $this->get_historical_price_lookup($args);
			if ($arrDataLast) {
				extract($arrDataLast, EXTR_SKIP);
				$HistoricalClosingPrice = $Last;
				$SplitAdjustmentFactor = $AdjustmentFactor;
				$arrData = $this->get_stock_quote($this->compid);
				if ($arrData) {
					extract($arrData, EXTR_SKIP);
					extract($arrData['@attributes'], EXTR_SKIP);

					$CurrentStockPrice = $Trade;
					
					// Purchase Price (Nominal)	= Historical closing price * Split Adjustment Factor
					$PurchasePrice = $HistoricalClosingPrice * $SplitAdjustmentFactor;
					if (empty($numberofsharespurchased)) {
						// Num Shares purchased = Amount Invested / Purchase Price (nominal)
						$numberofsharespurchased = divNumbers($amountinvested, $PurchasePrice);
						// Shares Owned Today (split adjusted)	= Number of shares purchased * Split Adjustment Factor
						$SharesOwnedToday = $numberofsharespurchased * $SplitAdjustmentFactor;
						// Investment Value Today	= shares owned today * current stock price
						$InvestmentValueToday = $SharesOwnedToday * $CurrentStockPrice;
						// Percent Change	= ((Investment Value today � Amount Invested) / Amount Invested) * 100
						$PercentChange = divNumbers(($InvestmentValueToday - $amountinvested), $amountinvested) * 100;
					} else {
						// Amount Invested = Num Shares purchased * Purchase Price (nominal)
						$amountinvested  = $numberofsharespurchased * $PurchasePrice;
						// Shares Owned Today (split adjusted)	= Number of shares purchased * Split Adjustment Factor
						$SharesOwnedToday = $numberofsharespurchased * $SplitAdjustmentFactor;
						// Investment Value Today	= shares owned today * current stock price
						$InvestmentValueToday = $SharesOwnedToday * $CurrentStockPrice;
						// Percent Change	= ((Investment Value today � Amount Invested) / Amount Invested) * 100
						$PercentChange = divNumbers(($InvestmentValueToday - $amountinvested), $amountinvested) * 100;
					}
				
					$result = array('reqdate' => $args['reqdate'],
									'historicalclosingprice' => $HistoricalClosingPrice,
									'amountinvested' => round($amountinvested, 2),
									'sharesownedtoday' => round($SharesOwnedToday, 2),
									'investmentvaluetoday' => round($InvestmentValueToday, 2),
									'percentchange' => round($PercentChange, 2));
					return $result;
				
				}
			}
			return false;
		
		}

	}


	global $reuters_stock_widgets;
	$reuters_stock_widgets = new The_Reuters_Stock_Widgets();	
	
}

function show_rsw_ticker($id, $title = '', $tickInterval = 1200) {
	global $reuters_stock_widgets;	

	echo $title;
	$arrData = $reuters_stock_widgets->get_stock_quote($reuters_stock_widgets->compid);

	if (!$arrData) {
		echo "error : cannot receive stock quote information";	
	} else {
		extract($arrData, EXTR_SKIP);
		extract($arrData['@attributes'], EXTR_SKIP);
	?>
	<div id="<?php echo $id; ?>">
		<?php
			// May be not very cool solution
			$_Ticker = $DisplayTicker;
		?>
		<span id="ticker-company"><?php echo __($Company) . ':&nbsp;' . $_Ticker ?></span>&nbsp;
		<span id="ticker-trade" style="padding:0px 30px">
			<?php if ($Change > 0) { ?>
				<img width="9" hspace="2" height="9" alt="Stock is Up" src="<?php echo $reuters_stock_widgets->pluginUrl; ?>/css/images/arrow_upGreen.gif">
			<?php } else { ?>
				<img width="9" hspace="2" height="9" alt="Stock is Down" src="<?php echo $reuters_stock_widgets->pluginUrl; ?>/css/images/arrow_downRed.gif">
			<?php } ?>
			<?php
				// Maybe not very cool solution
				$_CurrencyLabel = str_replace('Can', '', $CurrencyLabel);
			?>
			<?php echo $_CurrencyLabel.$Trade.$CurrencyLabelSuffix; ?>
		</span>
		<span id="ticker-date">
			<?php $time = strtotime($Date); ?>
			<?php
				$date = date('m/d/y', $time) . ' at '. date('h:i a', $time);
				if (get_locale() == 'fr_FR') {
					$date = date('d/m/y', $time) . ' à '. date('h:i a', $time);
				}
			?>
			<?php echo $date;
			?>
		</span>
		<span id="countdown-<?php echo $id; ?>"></span>
	</div>
<?php } ?>
<script type="text/javascript">
jQuery(function () {
	var austDay = new Date();
	austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
	jQuery('#countdown-<?php echo $id; ?>').countdown({
		until: austDay,
		tickInterval: <?php echo $tickInterval; ?>,
		onTick: watchCountdown,
		layout:'<?php echo (get_locale() == 'fr_FR') ? strtolower(__('Minimum 20 minute delay', 'reuters-stock-widgets')) : strtolower(__('20 min delay', 'reuters-stock-widgets')); ?>'
	});
});	
</script>
<?php
}