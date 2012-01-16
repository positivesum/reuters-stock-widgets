<font class="headline"><?php echo $title; ?></font>
<?php 
	global $reuters_stock_widgets;	
	$arrData = $reuters_stock_widgets->get_stock_quote($reuters_stock_widgets->compid);
	if (!$arrData) {
		echo "error : cannot receive stock quote information";	
	} else {
		extract($arrData, EXTR_SKIP);
		extract($arrData['@attributes'], EXTR_SKIP);
		// Percent of Change = (change / (last � change )) * 100
		$PercentOfChange =  round($Change / ($Trade - $Change) * 100, 2);
	?>
	<table cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td class="mainTxt">
					<div id="linkFix" class="reuters-stock-quote">
						<span class="ccbnTxt">
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr class="ccbnOutline">
										<td valign="top">
											<table width="100%" cellspacing="1" cellpadding="3" border="0">
												<tbody>
													<tr class="ccbnBgTblTtl">
														<td colspan="2">
															<span class="ccbnTblTtl">
															 <?php echo __(trim($reuters_stock_widgets->Ticker)) . ' (' . $Class . ')' ?>
															</span>
														</td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td valign="top" nowrap="nowrap" class="ccbnBgTblLabelLeft"><span class="ccbnTblLabelLeft"><?php echo __('Exchange', 'reuters-stock-widgets'); ?></span></td>
														<td valign="top" nowrap="nowrap"><span class="ccbnTblTxt"><?php echo $Exchange; ?></span><span class="ccbnTblTxt"> (<?php echo __($Currency, 'reuters-stock-widgets'); ?>)</span></td></tr>
													<tr class="ccbnBgTblTxt">
														<td valign="top" nowrap="nowrap" class="ccbnBgTblLabelLeft"><span class="ccbnTblLabelLeft"><?php echo __('Price', 'reuters-stock-widgets'); ?></span></td>
														<td width="100%" valign="top" nowrap="nowrap" class="ccbnBgPrice"><span class="ccbnPrice"><?php echo $CurrencyLabel.$Trade.$CurrencyLabelSuffix; ?></span></td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td valign="top" nowrap="nowrap" class="ccbnBgTblLabelLeft"><span class="ccbnTblLabelLeft"><?php echo __('Change', 'reuters-stock-widgets'); ?></span><span class="ccbnTblLabelLeft"> (%)</span></td>
													<?php if ($Change > 0) { ?>
														<td nowrap="nowrap">&nbsp;<img width="9" hspace="2" height="9" alt="Stock is Up" src="http://media.corporate-ir.net/media_files/IROL/global_images/arrow_upGreen.gif">&nbsp;<span class="ccbnPos"><?php echo $Change; ?></span><span class="ccbnPos">&nbsp;(<?php echo $PercentOfChange; ?>%)</span></td>
													<?php } else { ?>
														<td nowrap="nowrap">&nbsp;<img width="9" hspace="2" height="9" alt="Stock is Down" src="http://media.corporate-ir.net/media_files/IROL/global_images/arrow_downRed.gif">&nbsp;<span class="ccbnNeg"><?php echo $Change; ?></span><span class="ccbnNeg">&nbsp;(<?php echo $PercentOfChange; ?>%)</span></td>
													<?php } ?>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td valign="top" nowrap="nowrap" class="ccbnBgTblLabelLeft"><span class="ccbnTblLabelLeft"><?php echo __('Volume', 'reuters-stock-widgets'); ?></span></td>
														<td nowrap="nowrap"><span class="ccbnTblTxt"><?php echo (get_locale() != 'fr_FR') ? number_format($Volume) : number_format($Volume) ; ?></span></td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td valign="top" nowrap="nowrap" class="ccbnBgTblLabelLeft"><span class="ccbnTblLabelLeft"><?php echo __("Today's Open", 'reuters-stock-widgets'); ?></span></td>
														<td nowrap="nowrap"><span class="ccbnTblTxt"><?php echo $CurrencyLabel.$Open.$CurrencyLabelSuffix; ?></span></td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td valign="top" nowrap="nowrap" class="ccbnBgTblLabelLeft"><span class="ccbnTblLabelLeft"><?php echo __('Previous Close', 'reuters-stock-widgets'); ?></span></td>
														<td nowrap="nowrap"><span class="ccbnTblTxt"><?php echo $CurrencyLabel.$PreviousClose.$CurrencyLabelSuffix; ?></span></td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td valign="top" nowrap="nowrap" class="ccbnBgTblLabelLeft"><span class="ccbnTblLabelLeft"><?php echo __('Intraday High', 'reuters-stock-widgets'); ?></span></td>
														<td nowrap="nowrap"><span class="ccbnTblTxt"><?php echo $CurrencyLabel.$High.$CurrencyLabelSuffix; ?></span></td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td valign="top" nowrap="nowrap" class="ccbnBgTblLabelLeft"><span class="ccbnTblLabelLeft"><?php echo __('Intraday Low', 'reuters-stock-widgets'); ?></span></td>
														<td nowrap="nowrap"><span class="ccbnTblTxt"><?php echo $CurrencyLabel.$Low.$CurrencyLabelSuffix; ?></span></td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td valign="top" nowrap="nowrap" class="ccbnBgTblLabelLeft"><span class="ccbnTblLabelLeft"><?php echo __('52 Week High', 'reuters-stock-widgets'); ?></span></td>
														<td nowrap="nowrap"><span class="ccbnTblTxt"><?php echo $CurrencyLabel.$FiftyTwoWeekHigh.$CurrencyLabelSuffix; ?></span></td>
													</tr>
													<tr class="ccbnBgTblTxt">
														<td valign="top" nowrap="nowrap" class="ccbnBgTblLabelLeft"><span class="ccbnTblLabelLeft"><?php echo __('52 Week Low', 'reuters-stock-widgets'); ?></span></td>
														<td nowrap="nowrap"><span class="ccbnTblTxt"><?php echo $CurrencyLabel.$FiftyTwoWeekLow.$CurrencyLabelSuffix; ?></span></td>
													</tr>
													<tr class="ccbnBgTblSubTxt">
														<td colspan="2">
															<span class="ccbnTblSubTxt"><?php echo __('Data as of', 'reuters-stock-widgets'); ?> <?php echo $Date; ?></span>
															<br/>
															<span class="ccbnTblSubTxt"><?php echo __('Minimum 20 minute delay', 'reuters-stock-widgets'); ?></span>
															<br/>
															<span class="ccbnTblSubTxt"><a href="#refresh" onclick="location.href=location.href; return false;"><?php echo __('Refresh quote', 'reuters-stock-widgets'); ?></a></span>
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
<?php } ?>

	