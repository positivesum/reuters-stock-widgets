<?php require_once('utilities.php') ?>
<font class="headline"><?php echo $title; ?></font>
<?php 
	global $reuters_stock_widgets;

	if ( isset( $_REQUEST['operation'] ) && ($_REQUEST['operation'] == 'chart')) {
		$instance = wp_parse_args( array( 'title' => '', 'tickercompare' => '',
								'compid' =>  $_REQUEST['compid'], 'control_time' => $_REQUEST['control_time'],
								'control_freq' => $_REQUEST['control_freq'], 'control_compidx' => $_REQUEST['control_compidx'],
								'control_type' => $_REQUEST['control_type'], 'control_uf' => $_REQUEST['control_uf']) );		
	} else {
		$instance = wp_parse_args( array( 'title' => '', 'tickercompare' => '',
								'compid' =>  $reuters_stock_widgets->compid, 'control_time' => "1yr",
								'control_freq' => '1dy', 'control_compidx' => 'aaaaa:0',
								'control_type' => '64', 'control_uf' => '0') );		
	}
	
	?>
	<table cellspacing="0" cellpadding="0" border="0">
		<form id="stock-chart">
			<input type="hidden" name="operation" value="chart">	
			<input type="hidden" value="<?php echo $reuters_stock_widgets->compid; ?>" id="compid" name="compid"/>
			<input type="hidden" value="<?php echo $reuters_stock_widgets->Ticker; ?>" id="symb" name="symb" />
		<tbody>
			<tr>
				<td class="mainTxt">
					<div id="linkFix">
						<span class="ccbnTxt">
							<table width="100%" cellspacing="1" cellpadding="3" border="0">
								<tbody>
									<tr class="ccbnBgChart">
										<td valign="top" align="center" colspan="2">
											<img id="img-stock-chart" alt="Stock chart for: <?php echo $reuters_stock_widgets->Ticker ?>" src="http://chart.corporate-ir.net/custom/ccbn-com/stockchart/chart.asp?
											<?php 
											echo 'symb=CA:DH&amp;time='.$instance['control_time'].
												 '&amp;freq='.$instance['control_freq'].
												 '&amp;compidx='.$instance['control_compidx'].
												 '&amp;uf='.$instance['control_uf'].
												 '&amp;type='.$instance['control_type'].
												 '&amp;style=457&amp;size=1&amp;ma=&amp;maval=&amp;lf=&amp;nosettings=1&amp;comp=&amp;rand=071654'; 
											
											?>">
										</td>
									</tr>
									<tr class="ccbnBgSelect">
										<td valign="top" align="right" nowrap="nowrap" class="ccbnBgLabel"><span class="ccbnLabel"><?php echo __('Symbol', 'reuters-stock-widgets'); ?></span></td>
										<td valign="top">
											<span class="ccbnSelect">
												<?php
													echo (strlen($reuters_stock_widgets->Ticker) > 0) ? __(trim($reuters_stock_widgets->Ticker)).' ' : '';
													echo '(' . (strlen($reuters_stock_widgets->Class) > 0 ? $reuters_stock_widgets->Class : '' ) . ')'
												?>
											</span>
										</td>
									</tr>
									<tr class="ccbnBgSelect">
										<td valign="top" align="right" nowrap="nowrap" class="ccbnBgLabel">
											<span class="ccbnLabel"><?php echo  __('Ticker Comparison', 'reuters-stock-widgets'); ?></span>
										</td>
										<td valign="top">
											<span class="ccbnInput">
												<input type="TEXT" value="" class="control_TickerCompare" id="control_TickerCompare" name="control_TickerCompare">
											</span>
											<span class="ccbnSubTxt"><br><small><?php echo __('Separate multiple tickers with commas(,)', 'reuters-stock-widgets'); ?></small></span>
										</td>
									</tr>
									<tr class="ccbnBgSelect">
										<td valign="top" align="right" nowrap="nowrap" class="ccbnBgLabel">
											<span class="ccbnLabel"><?php echo  __('Time Frame', 'reuters-stock-widgets'); ?></span>
										</td>
										<td valign="top"><span class="ccbnSelect">
                                            <?php
                                                $time_options = array(
                                                    '1hr'=>__('1 hour (intraday)', 'reuters-stock-widgets'),
                                                    '1dy'=>__('1 day (intraday)', 'reuters-stock-widgets'),
                                                    '2dy'=>__('2 days (intraday)', 'reuters-stock-widgets'),
                                                    '5dy'=>__('5 days (intraday)', 'reuters-stock-widgets'),
                                                    '10dy'=>__('10 days (intraday)', 'reuters-stock-widgets'),
                                                    '1mo'=>__('1 month', 'reuters-stock-widgets'),
                                                    '2mo'=>__('2 months', 'reuters-stock-widgets'),
                                                    '3mo'=>__('3 months', 'reuters-stock-widgets'),
                                                    '6mo'=>__('6 months', 'reuters-stock-widgets'),
                                                    '1yr'=>__('1 year', 'reuters-stock-widgets'),
                                                    '2yr'=>__('2 years', 'reuters-stock-widgets'),
                                                    '3yr'=>__('3 years', 'reuters-stock-widgets'),
                                                    '4yr'=>__('4 years', 'reuters-stock-widgets'),
                                                    '5yr'=>__('5 years', 'reuters-stock-widgets'),
                                                    '10yr'=>__('10 years', 'reuters-stock-widgets'),
                                                    'Ytd'=>__('Year-to-Date', 'reuters-stock-widgets'),
                                                    'All'=>__('All Data', 'reuters-stock-widgets')
                                                );
                                            echo rsw_select_html('control_time', $time_options, $instance);
                                            ?>
										</span>
										</td>
									</tr>
									<tr class="ccbnBgSelect">
										<td valign="top" align="right" nowrap="nowrap" class="ccbnBgLabel">
											<span class="ccbnLabel"><?php echo  __('Frequency', 'reuters-stock-widgets'); ?></span>
										</td>
										<td valign="top">
											<span class="ccbnSelect">
                                            <?php
                                                $freq_options = array(
                                                    '1mi'=>__('1 Minute (intraday)', 'reuters-stock-widgets'),
                                                    '5mi'=>__('5 Minute (intraday)', 'reuters-stock-widgets'),
                                                    '15mi'=>__('15 Minute (intraday)', 'reuters-stock-widgets'),
                                                    '1hr'=>__('Hourly (intraday)', 'reuters-stock-widgets'),
                                                    '1dy'=>__('Daily', 'reuters-stock-widgets'),
                                                    '1wk'=>__('Weekly', 'reuters-stock-widgets'),
                                                    '1mo'=>__('Monthly', 'reuters-stock-widgets'),
                                                    '3mo'=>__('Quarterly', 'reuters-stock-widgets'),
                                                    '1yr'=>__('Yearly', 'reuters-stock-widgets'),
                                                );
                                            echo rsw_select_html('control_freq', $freq_options, $instance);
                                            ?>
											</span>
										</td>
									</tr>
									<tr class="ccbnBgSelect">
										<td valign="top" align="right" nowrap="nowrap" class="ccbnBgLabel">
											<span class="ccbnLabel"><?php echo  __('Index Comparison', 'reuters-stock-widgets'); ?></span>
										</td>
										<td valign="top">
											<span class="ccbnSelect">
                                                    <?php
                                                    $compidx_options = array(
                                                        'aaaaa:0'=>'None',
                                                        'djia'=>'DJ Industrial Average',
                                                        'NYA'=>'NYSE Composite',
                                                        '89199000:46938'=>'89199000:46938');
                                                    echo rsw_select_html('control_compidx', $compidx_options, $instance);
                                                    ?>
											</span>
										</td>
									</tr>
									<tr class="ccbnBgSelect">
										<td valign="top" align="right" nowrap="nowrap" class="ccbnBgLabel">
											<span class="ccbnLabel"><?php echo  __('Chart Type', 'reuters-stock-widgets');?></span>
										</td>
										<td valign="top">
											<span class="ccbnSelect">
                                                <?php
                                                    $type_options = array(
                                                        '2'=>'OHLC',
                                                        '64'=>'Close',
                                                        '4'=>'Candlestick',
                                                        '128'=>'Logarithmic',
                                                        '8'=>'Mountain'
                                                    );
                                                    echo rsw_select_html('control_type', $type_options, $instance);
                                                ?>
											</span>
										</td>
									</tr>
									<tr class="ccbnBgSelect">
										<td valign="top" align="right" nowrap="nowrap" class="ccbnBgLabel">
											<span class="ccbnLabel"><?php echo  __('Events', 'reuters-stock-widgets'); ?></span>
										</td>
										<td valign="top">
											<span class="ccbnSelect">
                                                <?php
                                                    $uf_options = array(
                                                        '0'=>'None',
                                                        '1024'=>'Show Splits',
                                                        '2048'=>'Show Earnings',
                                                        '4096'=>'Show Dividends',
                                                        '7168'=>'Show All Events'
                                                    );
                                                    echo rsw_select_html('control_uf', $uf_options, $instance);
                                                ?>
											</span>
										</td>
									</tr>
									<tr class="ccbnBgButton">
										<td valign="top">
											&nbsp;
										</td>
										<td valign="top" nowrap="nowrap">
											<!-- <input onclick="stockChart();" type="button" class="ccbnButton" value="<?php echo  __('Submit', 'reuters-stock-widgets'); ?>" name="Submit" /> -->
											<input type="submit" class="ccbnButton" value="<?php echo  __('Submit', 'reuters-stock-widgets'); ?>" name="Submit" />
										</td>
									</tr>
								</tbody>											
							</table>
						</span>
					</div>
				</td>
			</tr>
		</tbody>
		</form>
	</table>			


	