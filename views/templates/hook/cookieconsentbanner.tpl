<style type="text/css">
	.cookie-consent-banner {
		position: fixed;
		bottom: 0;
		left: 0;
		display: flex !important;
		justify-content: center;
		align-items: center;
		width: 100% !important;
		height: 50px !important;
		z-index: 100 !important;
		background-color: {$ccbbc};
	}
	.cookie-consent-banner p {
		margin: 0 !important;
		padding: 0 !important;
		color: {$ccbtc} !important;
	}
	.cookie-consent-banner button {
		margin-left: 10px;
		border: none;
		border-radius: 5px;
		padding: 5px;
		background-color: {$ccbbbc};
		border-color: {$ccbbbc};
		color: {$ccbbtc};
		cursor: pointer;
		outline: none;
	}
	.cookie-consent-banner button:hover {
		background-color: {$ccbbhbc};
		border-color: {$ccbbhbc};
	}
</style>

<div class="cookie-consent-banner">
	<p>{$ccbtext nofilter}</p>
	<button onclick="cookieConsent(true)">{$ccbbuttontext nofilter}</button>
</div>

<script>
	function setCookie(name, value, days) {
		var expires = "";
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toUTCString();
		}
		document.cookie = name + "=" + (value || "") + expires + "; path=/";
	}
	function getCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
		}
		return null;
	}
	function cookieConsent(bool) {
		var banner = document.querySelector('.cookie-consent-banner');
		if (bool == true) {
			setCookie('cookie-consent-banner', 'true', 30);
			banner.setAttribute('style', 'visibility: none !important');
		}
	}
	if (getCookie('cookie-consent-banner') !== 'true') {
		var banner = document.querySelector('.cookie-consent-banner');
		banner.setAttribute('style', 'visibility: visible !important');
	}
</script>