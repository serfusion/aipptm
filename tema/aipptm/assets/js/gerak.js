(function () {
	if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
		return;
	}

	var root = document.documentElement;
	root.classList.add('aipptm-gerak');

	function hitung(el) {
		var teks = el.textContent;
		var cocok = teks.match(/^(\D*)(\d[\d.]*)(.*)$/);
		if (!cocok) {
			return;
		}
		var target = parseInt(cocok[2].replace(/\./g, ''), 10);
		var durasi = 1600;
		var mulai = null;
		function langkah(waktu) {
			if (mulai === null) {
				mulai = waktu;
			}
			var t = Math.min((waktu - mulai) / durasi, 1);
			var nilai = Math.round(target * (1 - Math.pow(1 - t, 3)));
			el.textContent = cocok[1] + nilai.toLocaleString('id-ID') + cocok[3];
			if (t < 1) {
				requestAnimationFrame(langkah);
			} else {
				el.textContent = teks;
			}
		}
		el.textContent = cocok[1] + '0' + cocok[3];
		requestAnimationFrame(langkah);
	}

	function siap() {
		var bagian = document.querySelectorAll('.wp-block-post-content > .alignfull:not(.aipptm-hero), .entry-content > .alignfull:not(.aipptm-hero)');
		var angka = document.querySelectorAll('.aipptm-angka-besar');

		var pengamat = new IntersectionObserver(function (entri) {
			entri.forEach(function (e) {
				if (e.isIntersecting) {
					e.target.classList.add('aipptm-tampil');
					pengamat.unobserve(e.target);
				}
			});
		}, { rootMargin: '0px 0px -10% 0px', threshold: 0.08 });

		bagian.forEach(function (el) {
			el.classList.add('aipptm-muncul');
			pengamat.observe(el);
		});

		var pengamatAngka = new IntersectionObserver(function (entri) {
			entri.forEach(function (e) {
				if (e.isIntersecting) {
					hitung(e.target);
					pengamatAngka.unobserve(e.target);
				}
			});
		}, { threshold: 0.6 });

		angka.forEach(function (el) {
			pengamatAngka.observe(el);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', siap);
	} else {
		siap();
	}
})();
