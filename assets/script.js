// Skrip Utama Kuesioner IKM PERUMDA Air Minum Tirta Lestari

document.addEventListener('DOMContentLoaded', () => {
    // Set tanggal hari ini secara otomatis
    const tanggalInput = document.getElementById('tanggal_survei');
    if (tanggalInput) {
        tanggalInput.valueAsDate = new Date();
    }
});

// Toggle input teks jika memilih pekerjaan Lainnya
function togglePekerjaanLain(val) {
    const wrapper = document.getElementById('wrapper_pekerjaan_lainnya');
    const inputLain = document.getElementById('pekerjaan_lainnya');
    if (!wrapper || !inputLain) return;

    if (val === 'Lainnya') {
        wrapper.classList.remove('hidden');
        inputLain.setAttribute('required', 'true');
    } else {
        wrapper.classList.add('hidden');
        inputLain.removeAttribute('required');
        inputLain.value = '';
    }
}

// Handler pengiriman form survei
function handleFormSubmit(event) {
    event.preventDefault();

    const jenisKelaminEl = document.querySelector('input[name="jenis_kelamin"]:checked');
    const jenisLayananEl = document.querySelector('input[name="jenis_layanan"]:checked');

    if (!jenisKelaminEl || !jenisLayananEl) {
        alert('Mohon lengkapi pilihan Jenis Kelamin dan Jenis Layanan.');
        return;
    }

    const formData = {
        tanggal_survei: document.getElementById('tanggal_survei').value,
        jenis_kelamin: jenisKelaminEl.value,
        usia: parseInt(document.getElementById('usia').value),
        pendidikan: document.getElementById('pendidikan').value,
        pekerjaan: document.getElementById('pekerjaan').value,
        pekerjaan_lainnya: document.getElementById('pekerjaan_lainnya').value,
        jenis_layanan: jenisLayananEl.value,
        u1: parseInt(document.querySelector('input[name="u1"]:checked').value),
        u2: parseInt(document.querySelector('input[name="u2"]:checked').value),
        u3: parseInt(document.querySelector('input[name="u3"]:checked').value),
        u4: parseInt(document.querySelector('input[name="u4"]:checked').value),
        u5: parseInt(document.querySelector('input[name="u5"]:checked').value),
        u6: parseInt(document.querySelector('input[name="u6"]:checked').value),
        u7: parseInt(document.querySelector('input[name="u7"]:checked').value),
        u8: parseInt(document.querySelector('input[name="u8"]:checked').value),
        u9: parseInt(document.querySelector('input[name="u9"]:checked').value),
        saran: document.getElementById('saran').value.trim(),
        created_at: new Date().toISOString()
    };

    /* =========================================================================
       [CATATAN INTEGRASI BACKEND / DATABASE]
       Jika nanti aplikasi ini dipindah menggunakan PHP/MySQL:
       Ganti kode penyimpanan localStorage di bawah ini dengan Fetch API ke submit.php:
       
       fetch('submit.php', {
           method: 'POST',
           headers: { 'Content-Type': 'application/json' },
           body: JSON.stringify(formData)
       })
       .then(res => res.json())
       .then(data => { window.location.href = 'terima-kasih.html'; })
       .catch(err => alert('Gagal mengirim data ke server.'));
       ========================================================================= */

    // Simpan ke LocalStorage untuk demo frontend murni
    let existingData = JSON.parse(localStorage.getItem('pdam_ikm_respondents')) || [];
    existingData.unshift(formData);
    localStorage.setItem('pdam_ikm_respondents', JSON.stringify(existingData));

    // Arahkan ke halaman terima kasih
    window.location.href = 'terima-kasih.html';
}
