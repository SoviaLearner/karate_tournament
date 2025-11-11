// script.js - JavaScript untuk Karate Match Tracker (Validasi, Chart.js Helper, dll.)

document.addEventListener('DOMContentLoaded', function() {
    // --- Logika untuk mengisi opsi Pemenang di halaman pertandingan.php ---
    const p1Select = document.getElementById('id_peserta1');
    const p2Select = document.getElementById('id_peserta2');
    const pemenangSelect = document.getElementById('pemenang');

    if (p1Select && p2Select && pemenangSelect) {
        function updatePemenangOptions() {
            // Hapus opsi sebelumnya
            pemenangSelect.innerHTML = '<option value="">Pilih Pemenang</option>';

            const p1Value = p1Select.value;
            const p1Text = p1Select.options[p1Select.selectedIndex].text;
            const p2Value = p2Select.value;
            const p2Text = p2Select.options[p2Select.selectedIndex].text;

            // Tambahkan Peserta 1
            if (p1Value) {
                const opt1 = document.createElement('option');
                opt1.value = p1Value;
                opt1.textContent = "P1: " + p1Text;
                pemenangSelect.appendChild(opt1);
            }

            // Tambahkan Peserta 2 (jika dipilih dan bukan BYE/0)
            if (p2Value && p2Value !== '0') {
                const opt2 = document.createElement('option');
                opt2.value = p2Value;
                opt2.textContent = "P2: " + p2Text;
                pemenangSelect.appendChild(opt2);
            }
        }

        // Panggil saat halaman dimuat dan setiap kali P1 atau P2 berubah
        updatePemenangOptions();
        p1Select.addEventListener('change', updatePemenangOptions);
        p2Select.addEventListener('change', updatePemenangOptions);
    }
    
    // --- Logika umum lainnya (misal: validasi form sisi klien) ---
    // ...
});
