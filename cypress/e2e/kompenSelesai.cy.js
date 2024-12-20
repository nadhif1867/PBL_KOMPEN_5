describe('Validasi Tugas Kompen', () => {
    beforeEach(() => {
        cy.visit('http://127.0.0.1:8000/aUpdateKompenSelesai');
    });

    it('Validasi tugas selesai dengan data valid', () => {
        cy.get('table tbody tr')
            .first()
            .within(() => {
                // Klik tombol Tugas Selesai
                cy.get('button.btn-success').click();
            });

        // Pastikan alert sukses muncul
        cy.get('.alert-success', { timeout: 10000 })
            .should('be.visible')
            .and('contain', 'Status progres berhasil diubah menjadi selesai.');

        // Pastikan tombol "Tugas Selesai" tidak ada
        cy.get('table tbody tr')
            .first()
            .within(() => {
                cy.get('button.btn-success').should('exist');
                cy.contains('Selesai').should('be.visible');
            });
    });

    it('Memastikan tombol Kompen Diterima berfungsi dengan baik', () => {
        cy.get('table tbody tr')
            .first()
            .within(() => {
                // Periksa apakah tombol Kompen Diterima ada
                cy.get('button.btn-primary').should('be.visible').and('not.be.disabled');

                // Klik tombol Kompen Diterima
                cy.get('button.btn-primary').click();
            });

        // Pastikan alert sukses muncul
        cy.get('.alert-success', { timeout: 10000 })
            .should('be.visible')
            .and('contain', 'Kompen berhasil diterima dan jumlah alpha dikurangi.');

        // Verifikasi status diterima
        cy.get('table tbody tr')
            .first()
            .within(() => {
                cy.contains('Diterima').should('be.visible');
                cy.get('button.btn-primary').should('be.disabled');
            });
    });
});
