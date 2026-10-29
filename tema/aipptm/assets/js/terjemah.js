(function () {
	var nav = document.querySelector('.aipptm-bahasa--otomatis');
	if (!nav) {
		return;
	}

	var cocok = document.cookie.match(/(?:^|;\s*)googtrans=\/id\/([^;]+)/);
	var aktif = cocok ? decodeURIComponent(cocok[1]) : 'id';

	nav.querySelectorAll('a[data-terjemah]').forEach(function (a) {
		a.classList.toggle('is-aktif', a.getAttribute('data-terjemah') === aktif);
		if (a.getAttribute('data-terjemah') === aktif) {
			a.setAttribute('aria-current', 'true');
		}
		a.addEventListener('click', function (e) {
			e.preventDefault();
			var kode = a.getAttribute('data-terjemah');
			var host = location.hostname.replace(/^www\./, '');
			var kedaluwarsa = kode === 'id' ? '; expires=Thu, 01 Jan 1970 00:00:00 GMT' : '';
			var nilai = kode === 'id' ? '' : '/id/' + kode;
			document.cookie = 'googtrans=' + nilai + '; path=/' + kedaluwarsa;
			document.cookie = 'googtrans=' + nilai + '; path=/; domain=.' + host + kedaluwarsa;
			location.reload();
		});
	});

	if (aktif === 'id') {
		return;
	}

	window.aipptmTerjemah = function () {
		new window.google.translate.TranslateElement({ pageLanguage: 'id', includedLanguages: 'en,ar,zh-CN', autoDisplay: false }, 'aipptm-gt');
	};
	var s = document.createElement('script');
	s.src = 'https://translate.google.com/translate_a/element.js?cb=aipptmTerjemah';
	s.async = true;
	document.head.appendChild(s);
})();
