<font class="headline"><?php echo $title; ?></font>
<?php 
	global $reuters_stock_widgets;
	$reqdate = '';
	if ( isset( $_REQUEST['operation'] ) && ($_REQUEST['operation'] == 'lookup')) {
		$reqdate = $_REQUEST['reqdate'];
		$arg = array (
			'compid' => $_REQUEST['compid'],				 
			'reqdate' => $reqdate,
			'symb' => $_REQUEST['symb'],
		);		
		$arrData = $reuters_stock_widgets->get_historical_price_lookup($arg);
	} else {
		$reqdate = date("m/d/Y", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
		$defaults = array(
			'compid' => $reuters_stock_widgets->compid,
			'reqdate' => $reqdate, // date("m/d/Y")
			'symb' => $reuters_stock_widgets->Ticker,
		);

		if (false == ($arrData = $reuters_stock_widgets->get_historical_price_lookup($defaults))) {
			$arrData = array();
		}
	}

	if (!$arrData && isset($_REQUEST['operation'])) {
		echo "<div id='error'>error : cannot receive stock quote information</div>";
	} else {
		extract($arrData, EXTR_SKIP);
	}
	?>
	<form method="POST">
	<input type="hidden" name="operation" value="lookup">
	<table cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td class="mainTxt">
					<div id="linkFix">
						<span class="ccbnTxt">
							<table width="100%" cellspacing="1" cellpadding="3" border="0">
								<tbody>
									<tr class="ccbnBgLabel">
										<td>
											<span class="ccbnLabel">Symbol</span>
										</td>
									</tr>
									<tr class="ccbnBgInput">
										<td valign="top">
											<span class="ccbnInput">
												<input type="hidden" value="<?php echo $reuters_stock_widgets->compid; ?>" name="compid" id="compid">
												<input type="hidden" value="<?php echo $reuters_stock_widgets->Ticker?>" name="symb" id="symb">
												<?php echo __(trim($reuters_stock_widgets->Ticker)) . ' (' . __($reuters_stock_widgets->Class). ')' ?>
											</span>
										</td>
									</tr>
									<tr class="ccbnBgLabel">
										<td>
											<span class="ccbnLabel">Lookup Date</span>
										</td>
									</tr>
									<tr class="ccbnBgSelect">
										<td valign="bottom" nowrap="nowrap">
											<input name="reqdate" id="reqdate" value="<?php echo $reqdate; ?>" type="text"/>									
										</td>
									</tr>
									<tr class="ccbnBgButton">
										<td>
											<!-- <input type="button" class="ccbnButton" onclick="lookUp();" value="Look Up" alt="Look Up"/> -->
											<input type="submit" class="ccbnButton" value="Look Up" alt="Look Up"/>
										</td>
									</tr>
								</tbody>
							</table>
							<table width="100%" cellspacing="1" cellpadding="3" border="0">
								<tbody>
									<tr class="ccbnBgTtl">
										<td valign="top">
											<span class="ccbnTtl">Results</span>
										</td>
									</tr>
								</tbody>
							</table>
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr class="ccbnOutline">
										<td valign="top">
											<table width="100%" cellspacing="1" cellpadding="3" border="0">
												<tbody>
													<tr class="ccbnBgTblTxt">
														<td align="right" nowrap="nowrap" class="ccbnBgTblLabelLeft">
															<span class="ccbnTblLabelLeft">Date Requested</span>
														</td>
														<td width="100%" nowrap="nowrap">
															<span id="date-requested" class="ccbnTblTxt"><?php echo $reqdate; ?></span>
														</td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td align="right" nowrap="nowrap" class="ccbnBgTblLabelLeft">
															<span class="ccbnTblLabelLeft">Closing Price</span>
														</td>
														<td width="100%" nowrap="nowrap" class="ccbnBgPrice">
															<span class="ccbnPrice"><?php echo $reuters_stock_widgets->CurrencyLabel; ?></span>
															<span id="closing-price" class="ccbnPrice"><?php echo $Last; ?></span>
															<span class="ccbnPrice"><?php echo $reuters_stock_widgets->CurrencyLabelSuffix; ?></span>
														</td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td align="right" nowrap="nowrap" class="ccbnBgTblLabelLeft">
															<span class="ccbnTblLabelLeft">Volume</span>
														</td>
														<td width="100%" nowrap="nowrap">
															<span id="volume" class="ccbnTblTxt"><?php echo number_format($Volume); ?></span>
														</td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td align="right" nowrap="nowrap" class="ccbnBgTblLabelLeft">
															<span class="ccbnTblLabelLeft">Split Adjustment Factor</span>
														</td>
														<td width="100%" nowrap="nowrap">
															<span id="split-adjustment-factor" class="ccbnTblTxt"><?php echo $AdjustmentFactor; ?></span>
														</td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td align="right" nowrap="nowrap" class="ccbnBgTblLabelLeft">
															<span class="ccbnTblLabelLeft">Open</span>
														</td>
														<td width="100%" nowrap="nowrap">
															<span class="ccbnTblTxt"><?php echo $reuters_stock_widgets->CurrencyLabel; ?></span>
															<span id="open" class="ccbnTblTxt"><?php echo $Open; ?></span>
															<span class="ccbnPrice"><?php echo $reuters_stock_widgets->CurrencyLabelSuffix; ?></span>																	
														</td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td align="right" nowrap="nowrap" class="ccbnBgTblLabelLeft">
															<span class="ccbnTblLabelLeft">Day's High</span>
														</td>
														<td width="100%" nowrap="nowrap">
															<span class="ccbnTblTxt"><?php echo $reuters_stock_widgets->CurrencyLabel; ?></span>
															<span id="high" class="ccbnTblTxt"><?php echo $High; ?></span>
															<span class="ccbnPrice"><?php echo $reuters_stock_widgets->CurrencyLabelSuffix; ?></span>
														</td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td align="right" nowrap="nowrap" class="ccbnBgTblLabelLeft">
															<span class="ccbnTblLabelLeft">Day's Low</span>
														</td>
														<td width="100%" nowrap="nowrap">
															<span class="ccbnTblTxt"><?php echo $reuters_stock_widgets->CurrencyLabel; ?></span>
															<span id="low" class="ccbnTblTxt"><?php echo $Low; ?></span>
															<span class="ccbnPrice"><?php echo $reuters_stock_widgets->CurrencyLabelSuffix; ?></span>
														</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
						</span>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	</form>
<script>
	jQuery(function() {
		jQuery( "#reqdate" ).datepicker();
	});
</script>
<?php  ?>
