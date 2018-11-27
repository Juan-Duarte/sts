function changeOrderType()
{
	var list = document.getElementById('order_type');
	var type = list.options[list.selectedIndex].value;
	var limit = document.getElementById('limit');
	
	if ( type === 'market' )
		limit.disabled = true;
	else
		limit.disabled = false;
}

function changeTradeType()
{
	var list = document.getElementById('trade_type');
	var type = list.options[list.selectedIndex].value;
	var stop_loss = document.getElementById('stop_loss');
	
	if ( type === 'buy' )
	{
		stop_loss.disabled = true;
		document.getElementById('order_type').selectedIndex = 0;
		document.getElementById('limit').disabled = true;
	}
	else
		stop_loss.disabled = false;
}

function getTotalPrice()
{
	var price = 0;
	var total = 0;
	var text = '';
	if(document.getElementById('price').innerHTML != null)
	{
		var priceString = document.getElementById('price').innerHTML;
		var tokenArray = priceString.split(" ");
		price = tokenArray[1];
		
	}

	var shares = document.getElementById('shares').value;
	
	if(price === 'Price not available')
	{
		total = 0;
		text = 'Total: '+total;
	}
	else
	{
		total = shares * price;
		text = 'Total: '+total;
	}
	document.getElementById('total').innerHTML = text;

}
function getStockPrice()
{
	var stock = document.getElementById('stock').value;
	var url = 'http://'+location.hostname+'/index.php?c=trade&e=price&s='+stock;
	
	var http = new XMLHttpRequest();
	http.open('GET', url, true);
	http.send();
	http.onreadystatechange = function()
	{
		if ( http.readyState == 4 && http.status == 200 )
		{
			var res = http.responseText;
			var text = '';
			if ( res !== '0.00' )
				text = 'Price: '+res;
			else
				text = 'Price not available';
			document.getElementById('price').innerHTML = text;
		}
	}
}

function confirmTrade()
{
	var trade_type, stock, shares, order_type;
	
	trade = document.getElementById('trade_type').value;
	stock = document.getElementById('stock').value;
	shares = document.getElementById('shares').value;
	
	var e = document.getElementById('order_type');
	
	if ( e.value === 'stop' )
		order_type = 'stop loss';
	else
		order_type = e.value;
	
	var str = "Confirmation:\nYou are "+trade+"ing "+shares+" shares of "+stock+" in a "+order_type+" trade.";
	return confirm(str);
}
