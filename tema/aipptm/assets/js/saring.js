(function () {
	var daftar = document.querySelectorAll('.aipptm-saring');
	if (!daftar.length) {
		return;
	}

	var urutanAkreditasi = ['unggul', 'a', 'baik sekali', 'b', 'baik', 'c', 'terakreditasi'];

	function rapikan(teks) {
		return (teks || '').replace(/\s+/g, ' ').trim();
	}

	function urutkan(jurnal) {
		return function (a, b) {
			if (jurnal) {
				return (parseInt(a.replace(/\D/g, ''), 10) || 9) - (parseInt(b.replace(/\D/g, ''), 10) || 9);
			}
			var ia = urutanAkreditasi.indexOf(a.toLowerCase());
			var ib = urutanAkreditasi.indexOf(b.toLowerCase());
			return (ia < 0 ? 99 : ia) - (ib < 0 ? 99 : ib);
		};
	}

	daftar.forEach(function (grid, nomor) {
		var kartu = Array.prototype.slice.call(grid.children);
		if (kartu.length < 4) {
			return;
		}

		var jurnal = grid.classList.contains('aipptm-jurnal__grid');
		var data = kartu.map(function (el) {
			var lencana = el.querySelector('.aipptm-sinta, .aipptm-akreditasi');
			return {
				el: el,
				label: lencana ? rapikan(lencana.textContent) : '',
				teks: rapikan(el.textContent).toLowerCase()
			};
		});

		var label = [];
		data.forEach(function (d) {
			if (d.label && label.indexOf(d.label) < 0) {
				label.push(d.label);
			}
		});
		label.sort(urutkan(jurnal));

		var alat = document.createElement('div');
		alat.className = 'aipptm-saring__alat';

		var idCari = 'aipptm-cari-' + nomor;
		var labelCari = document.createElement('label');
		labelCari.className = 'screen-reader-text';
		labelCari.setAttribute('for', idCari);
		labelCari.textContent = jurnal ? 'Cari jurnal' : 'Cari perguruan tinggi';

		var cari = document.createElement('input');
		cari.type = 'search';
		cari.id = idCari;
		cari.className = 'aipptm-saring__cari';
		cari.autocomplete = 'off';
		cari.placeholder = jurnal ? 'Cari nama jurnal, penerbit, atau ISSN' : 'Cari nama perguruan tinggi';

		var pilihan = document.createElement('div');
		pilihan.className = 'aipptm-saring__pilihan';
		pilihan.setAttribute('role', 'group');
		pilihan.setAttribute('aria-label', jurnal ? 'Saring menurut peringkat SINTA' : 'Saring menurut peringkat akreditasi');

		var info = document.createElement('p');
		info.className = 'aipptm-saring__info';
		info.setAttribute('aria-live', 'polite');

		var kosong = document.createElement('p');
		kosong.className = 'aipptm-saring__kosong';
		kosong.hidden = true;
		kosong.textContent = jurnal ? 'Tidak ada jurnal yang sesuai dengan pencarian Anda.' : 'Tidak ada perguruan tinggi anggota yang sesuai dengan pencarian Anda.';

		var aktif = '';
		var tombol = [];

		function buatTombol(nilai, teks) {
			var b = document.createElement('button');
			b.type = 'button';
			b.textContent = teks;
			b.setAttribute('aria-pressed', nilai === aktif ? 'true' : 'false');
			b.addEventListener('click', function () {
				aktif = nilai;
				tombol.forEach(function (t) {
					t.btn.setAttribute('aria-pressed', t.nilai === aktif ? 'true' : 'false');
				});
				terapkan();
			});
			tombol.push({ btn: b, nilai: nilai });
			pilihan.appendChild(b);
		}

		buatTombol('', 'Semua (' + data.length + ')');
		label.forEach(function (l) {
			var jumlah = data.filter(function (d) {
				return d.label === l;
			}).length;
			buatTombol(l, l + ' (' + jumlah + ')');
		});

		function terapkan() {
			var kata = rapikan(cari.value).toLowerCase();
			var tampil = 0;
			data.forEach(function (d) {
				var cocok = (!aktif || d.label === aktif) && (!kata || d.teks.indexOf(kata) > -1);
				d.el.hidden = !cocok;
				if (cocok) {
					tampil++;
				}
			});
			info.textContent = 'Menampilkan ' + tampil + ' dari ' + data.length + (jurnal ? ' jurnal' : ' perguruan tinggi');
			kosong.hidden = tampil > 0;
		}

		cari.addEventListener('input', terapkan);

		alat.appendChild(labelCari);
		alat.appendChild(cari);
		alat.appendChild(pilihan);
		alat.appendChild(info);
		grid.parentNode.insertBefore(alat, grid);
		grid.parentNode.insertBefore(kosong, grid.nextSibling);
		terapkan();
	});
})();
