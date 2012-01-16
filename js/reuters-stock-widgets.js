function lookUp() {
	var compid = jQuery('#compid').val();
	var reqdate = jQuery('#reqdate').val();
	var symb = jQuery('#symb').val();
	
	jQuery.ajax({
	   type: "POST",
	   //url: "/wp-admin/admin-ajax.php",
	   url: "/wp-content/plugins/reuters-stock-widgets/ajax.php",
	   data: 'action=widget_stockquotes&operation=lookup' + 
			 '&compid='	+ compid +			 			 
			 '&reqtype=histquote' +			 			 			 
			 '&reqdate='	+ reqdate +			 			 			 
			 '&symb='	+ symb,		
       dataType: 'json',	   
	   success: function(data){
			if (data.result) {
				jQuery('#date-requested').text(jQuery('#reqdate').val());
				jQuery('#closing-price').text(data.result.Last);
				jQuery('#volume').text(data.result.Volume);
				jQuery('#split-adjustment-factor').text(data.result.AdjustmentFactor);					
				jQuery('#open').text(data.result.Open);
				jQuery('#high').text(data.result.High);
				jQuery('#low').text(data.result.Low);
				jQuery('#error').html('');
			} else {
				jQuery('#error').html('error : cannot receive stock quote information');
			}
			
	   },
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert(textStatus);		
		}	   
	 });			
}

function stockChart() {
	var params = jQuery('#stock-chart').serializeArray();
	var src = "http://chart.corporate-ir.net/custom/ccbn-com/stockchart/chart.asp?symb=CA:DH" +
				"&time=" + params[3]['value'] +
				"&freq=" + params[4]['value'] + 
				"&compidx=" + params[5]['value'] + 
				"&uf=" + params[7]['value'] + 
				"&type=" +  params[6]['value'] + 
				"&style=457&size=1&ma=&maval=&lf=&nosettings=1&comp=&rand=071654"	
	jQuery('#img-stock-chart').attr('src', src);	
}

function calcInvestment() {
	var compid = jQuery('#calculator-compid').val();
	var reqdate = jQuery('#calculator-reqdate').val();
	var symb = jQuery('#calculator-symb').val();
	var amountinvested = jQuery('#amountinvested').val();
	var numberofsharespurchased = jQuery('#numberofsharespurchased').val();	
	jQuery.ajax({
	   type: "POST",
//	   url: "/wp-admin/admin-ajax.php",
	   url: "/wp-content/plugins/reuters-stock-widgets/ajax.php",
	   data: 'action=widget_stockquotes&operation=calcinvestment' + 
			 '&compid='	+ compid +			 			 
			 '&reqtype=histquote' +			 			 			 
			 '&reqdate='	+ reqdate +			 			 			 
			 '&symb='	+ symb +
			 '&amountinvested='	+ amountinvested +
			 '&numberofsharespurchased=' + numberofsharespurchased,			 
       dataType: 'json',	   
	   success: function(data){
			if (data.result) {
				jQuery('#calculator-date-requested').text(data.result.reqdate);
				jQuery('#calculator-closing-price').text(data.result.historicalclosingprice);
				jQuery('#calculator-shares-today').text(data.result.sharesownedtoday);
				jQuery('#calculator-investment-value').text(data.result.investmentvaluetoday);					
				jQuery('#calculator-percent-change').text(data.result.percentchange);
				jQuery('#error').html('');
			} else {
				jQuery('#error').html('error : cannot receive stock quote information');
			}
	   },
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert(textStatus);		
		}	   
	 });			
	
}

function watchCountdown(periods) { 
	window.location.href = window.location.href;
/*
	jQuery.ajax({
	   type: "POST",
//	   url: "/wp-admin/admin-ajax.php",
	   url: "/wp-content/plugins/reuters-stock-widgets/ajax.php",
	   data: 'action=widget_stockquotes&operation=ticker',		
       dataType: 'json',	   
	   success: function(data){
			if (data.result) {
				jQuery('#ticker-company').text(data.result['@attributes'].Company+':'+data.result['@attributes'].Ticker);
				if (data.result.Change > 0) {
					jQuery('#ticker-trade').html('<img width="9" hspace="2" height="9" alt="Stock is Up" src="/wp-content/plugins/reuters-stock-widgets/css/images/arrow_upGreen.gif">' + data.result['@attributes'].CurrencyLabel+data.result.Trade+ data.result['@attributes'].CurrencyLabelSuffix);
				} else {
					jQuery('#ticker-trade').html('<img width="9" hspace="2" height="9" alt="Stock is Down" src="/wp-content/plugins/reuters-stock-widgets/css/images/arrow_downRed.gif">' + data.result['@attributes'].CurrencyLabel+data.result.Trade+ data.result['@attributes'].CurrencyLabelSuffix);
				}
				jQuery('#ticker-date').text(data.result.Date);
			}
	   },
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert(textStatus);		
		}	   
	 });
*/	 
}
