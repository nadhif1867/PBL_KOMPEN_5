describe('Upload Berita Acara Kompen', () => {
    const baseUrl = 'http://127.0.0.1:8000/mUpdateKompenSelesai';

    beforeEach(() => {
        cy.visit(baseUrl);
    });

    it('1.1 Upload berita acara dengan format sesuai', () => {
        // Klik tombol unggah pada baris pertama
        cy.get('#table_kompen tbody tr')
            .first()
            .within(() => {
                cy.get('button.btn-primary').click();
            });

        // Tunggu modal muncul
        cy.get('.modal').should('be.visible');

        // Upload file valid
        cy.get('input[type="file"]').attachFile('berita_acara.pdf');

        // Submit form
        cy.get('form').submit();

        // Pastikan notifikasi sukses muncul
        cy.get('.alert-success', { timeout: 10000 })
            .should('be.visible')
            .and('contain', 'File berhasil diunggah');

        // Verifikasi status pada tabel berubah
        cy.get('#table_kompen tbody tr')
            .first()
            .within(() => {
                cy.contains('Belum Diterima').should('be.visible');
            });
    });

    it('1.2 Upload berita acara dengan ukuran file terlalu besar', () => {
        // Klik tombol unggah pada baris pertama
        cy.get('#table_kompen tbody tr')
            .first()
            .within(() => {
                cy.get('button.btn-primary').click();
            });

        // Tunggu modal muncul
        cy.get('.modal').should('be.visible');

        // Upload file besar
        cy.get('input[type="file"]').attachFile('berita_acara_large.pdf');

        // Submit form
        cy.get('form').submit();

        // Pastikan notifikasi error muncul
        cy.get('.alert-danger', { timeout: 10000 })
            .should('be.visible')
            .and('contain', 'Ukuran file terlalu besar');

        // Verifikasi status pada tabel tetap sama
        cy.get('#table_kompen tbody tr')
            .first()
            .within(() => {
                cy.contains('Belum Unggah').should('be.visible');
            });
    });
});
