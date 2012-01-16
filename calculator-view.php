<p><font class="headline"><?php echo $title; ?></font></p>
<?php 
	global $reuters_stock_widgets;

	if ( isset( $_REQUEST['operation'] ) && ($_REQUEST['operation'] == 'calcinvestment')) {
		$reqdate = $_REQUEST['reqdate'];
		$amountinvested = $_REQUEST['amountinvested'];
		$numberofsharespurchased = $_REQUEST['numberofsharespurchased'];
		$arg = array (
			'compid' => $_REQUEST['compid'],				 
			'reqdate' => $reqdate,
			'symb' => $_REQUEST['symb'],
			'amountinvested' => $amountinvested,
			'numberofsharespurchased' => $numberofsharespurchased,						
		);		
		$arrData = $reuters_stock_widgets->calc_investment($arg);
	} else {
		$reqdate = date("m/d/Y", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
		$amountinvested = 1000;
		$numberofsharespurchased = '';
		$defaults = array(
			'compid' => $reuters_stock_widgets->compid,
			'reqdate' => $reqdate,
			'amountinvested' => $amountinvested,
			'numberofsharespurchased' => $numberofsharespurchased,
			'symb' => $reuters_stock_widgets->Ticker,
		);
		if (false == ($arrData = $reuters_stock_widgets->calc_investment($defaults))) {
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
	<input type="hidden" name="operation" value="calcinvestment">
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tbody>
			<tr>
				<td class="mainTxt">
					<div id="linkFix">
						<span class="ccbnTxt calc">
							<table class="form" width="100%" cellspacing="1" cellpadding="3" border="0">
									<tbody>
									<tr class="ccbnBgLabel">
										<td colspan="3">
											<span class="ccbnLabel"><b>Symbol</b><br/><?php echo __(trim($reuters_stock_widgets->Ticker)) . ' (' . $reuters_stock_widgets->Class . ')' ?></span>
										</td>
									</tr>
									<tr class="ccbnBgInput">
										<td valign="top" colspan="3">
											<span class="ccbnInput">
												<input type="hidden" value="<?php echo $reuters_stock_widgets->compid; ?>" name="compid" id="calculator-compid">
												<input type="hidden" value="<?php echo $reuters_stock_widgets->Ticker?>" name="symb" id="calculator-symb">
											</span>
										</td>
									</tr>
									<tr class="ccbnBgLabel">
										<td colspan="3">
											<span class="ccbnLabel">Investment Date</span>
										</td>
									</tr>
									<tr class="ccbnBgSelect">
										<td valign="bottom" nowrap="nowrap" colspan="3">
											<input name="reqdate" id="calculator-reqdate" value="<?php echo $reqdate; ?>" type="text"/>	
										</td>
									</tr>
									<tr class="ccbnBgLabel">
										<td>
											<span class="ccbnLabel">Amount Invested (<?php echo $reuters_stock_widgets->CurrencyLabel.$reuters_stock_widgets->CurrencyLabelSuffix; ?>)</span>
										</td>
										<td>
											<span class="ccbnLabel">or</span>
										</td>
										<td>
											<span class="ccbnLabel"># Shares Purchased</span></td>
									</tr>
									<tr class="ccbnBgInput">
										<td nowrap="nowrap">
											<span class="ccbnInput">
												<input type="TEXT" id="amountinvested" value="<?php echo $amountinvested; ?>" name="amountinvested">
											</span>
										</td>
										<td valign="top"></td>
										<td width="100%">
											<span class="ccbnInput">
												<input type="TEXT" id="numberofsharespurchased" value="<?php echo $numberofsharespurchased; ?>" name="numberofsharespurchased">
											</span>
										</td>
									</tr>
									<tr class="ccbnBgButton">
										<td colspan="3">
											<!-- <input type="button" onclick="calcInvestment();" class="ccbnButton" value="Calculate" name="Submit"> -->
											<input type="submit" class="ccbnButton" value="Calculate" name="Submit">
											
										</td>
									</tr>
								</tbody>
							</table>
							<table class="result label" width="100%" cellspacing="1" cellpadding="3" border="0">
								<tbody>
									<tr class="ccbnBgTtl">
										<td valign="top">
											<span class="ccbnTtl">Results</span>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="result table" width="100%" cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr class="ccbnOutline">
										<td valign="top">
											<table width="100%" cellspacing="1" cellpadding="3" border="0">
												<tbody>
													<tr class="ccbnBgTblTxt">
														<td width="70%" align="right" nowrap="nowrap" class="ccbnBgTblLabelLeft">
															<span class="ccbnTblLabelLeft">Date Requested</span>
														</td>
														<td width="100%" nowrap="nowrap">
															<span id="calculator-date-requested" class="ccbnTblTxt"><?php echo $reqdate; ?></span>
														</td>
													</tr>
													<tr class="ccbnBgPrice">
														<td align="right" nowrap="nowrap" class="ccbnBgTblLabelLeft">
															<span class="ccbnTblLabelLeft">Closing Price</span>
														</td>
														<td width="100%" nowrap="nowrap">
															<span class="ccbnPrice"><?php echo $reuters_stock_widgets->CurrencyLabel; ?></span>
															<span id="calculator-closing-price" class="ccbnPrice"><?php echo $historicalclosingprice; ?></span>
															<span class="ccbnPrice"><?php echo $reuters_stock_widgets->CurrencyLabelSuffix; ?></span>															
														</td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td align="right" nowrap="nowrap" class="ccbnBgTblLabelLeft">
															<span class="ccbnTblLabelLeft">Shares Today</span>
														</td>
														<td width="100%" nowrap="nowrap">
															<span id="calculator-shares-today" class="ccbnTblTxt"><?php echo $sharesownedtoday; ?></span>
														</td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td align="right" nowrap="nowrap" class="ccbnBgTblLabelLeft">
															<span class="ccbnTblLabelLeft">Investment Value</span>
														</td>
														<td width="100%" nowrap="nowrap">
															<span class="ccbnTblTxt"><?php echo $reuters_stock_widgets->CurrencyLabel; ?></span>
															<span id="calculator-investment-value" class="ccbnTblTxt"><?php echo $investmentvaluetoday; ?></span>
															<span class="ccbnPrice"><?php echo $reuters_stock_widgets->CurrencyLabelSuffix; ?></span>															
														</td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td align="right" nowrap="nowrap" class="ccbnBgTblLabelLeft">
															<span class="ccbnTblLabelLeft">Percent Change</span>
														</td>
														<td width="100%" nowrap="nowrap">
															<span id="calculator-percent-change" class="ccbnTblTxt"><?php echo $percentchange; ?></span>
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
		jQuery( "#calculator-reqdate" ).datepicker();
	});
</script>
<?php  ?>