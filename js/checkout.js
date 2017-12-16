window.onload = function() {
				document.getElementById('ifCash').style.display = 'none';
				document.getElementById('ifCredit').style.display = 'none';
				document.getElementById('ifBank').style.display = 'none';
			}
			function yesnoCheck() {
				if (document.getElementById('cashCheck').checked) {
					document.getElementById('ifCash').style.display = 'block';
					document.getElementById('ifCredit').style.display = 'none';
					document.getElementById('ifBank').style.display = 'none';
					document.getElementById('method').value = 'cash';
				} 
				else if(document.getElementById('creditCheck').checked) {
					document.getElementById('ifCash').style.display = 'none';
					document.getElementById('ifCredit').style.display = 'block';
					document.getElementById('ifBank').style.display = 'none';
					document.getElementById('method').value = 'credit';
			   }
			   else if(document.getElementById('bankCheck').checked) {
					document.getElementById('ifCash').style.display = 'none';
					document.getElementById('ifCredit').style.display = 'none';
					document.getElementById('ifBank').style.display = 'block';
					document.getElementById('method').value = 'bank';
			   }
			}
			