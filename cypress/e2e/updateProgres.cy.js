describe('Update Progres Tugas Kompen', () => {
    const baseUrl = 'http://127.0.0.1:8000';
    const validProgress = '75'; // Nilai valid
    const invalidProgressAbove100 = '110'; // Nilai tidak valid
    const emptyProgress = ''; // Kosong untuk validasi

    beforeEach(() => {
        cy.visit(`${baseUrl}/mUpdateProgresTugasKompen`);
    });

    it('1. Update progres dengan nilai valid', () => {
        // Klik tombol update pada tugas pertama
        cy.get('#table_user tbody tr')
            .first()
            .within(() => {
                cy.get('.edit-progress-btn').click();
            });

        // Tunggu modal muncul
        cy.get('#myModal').should('be.visible');

        // Masukkan nilai valid dan simpan
        cy.get('#progress-input').clear().type(validProgress);
        cy.get('#save-progress-btn').click();

        // Validasi pesan sukses dan kembali ke tabel
        cy.get('.swal2-html-container', { timeout: 10000 })
            .should('be.visible')
            .and('contain', 'Update Progres Tugas Kompen');

        // Klik tombol OK dan pastikan modal tertutup
        cy.get('.swal2-confirm').click();
        cy.get('#myModal').should('not.be.visible');

        // Pastikan nilai progres diperbarui di tabel
        cy.get('#table_user tbody tr')
            .first()
            .within(() => {
                cy.get('.editable-progress').should('contain', validProgress);
            });
    });

    it('2. Update progres dengan nilai di atas 100%', () => {
        // Klik tombol update pada tugas pertama
        cy.get('#table_user tbody tr')
            .first()
            .within(() => {
                cy.get('.edit-progress-btn').click();
            });

        // Tunggu modal muncul
        cy.get('#myModal').should('be.visible');

        // Masukkan nilai tidak valid (di atas 100%) dan simpan
        cy.get('#progress-input').clear().type(invalidProgressAbove100);
        cy.get('#save-progress-btn').click();

        // Validasi pesan error
        cy.get('.swal2-html-container', { timeout: 10000 })
            .should('be.visible')
            .and('contain', 'Nilai progres tidak valid, harus antara 0-100%');

        // Pastikan modal tetap terbuka
        cy.get('#myModal').should('be.visible');
    });

    it('3. Update progres tanpa mengisi data', () => {
        // Klik tombol update pada tugas pertama
        cy.get('#table_user tbody tr')
            .first()
            .within(() => {
                cy.get('.edit-progress-btn').click();
            });

        // Tunggu modal muncul
        cy.get('#myModal').should('be.visible');

        // Biarkan input kosong dan simpan
        cy.get('#progress-input').clear();
        cy.get('#save-progress-btn').click();

        // Validasi pesan error
        cy.get('.swal2-html-container', { timeout: 10000 })
            .should('be.visible')
            .and('contain', 'Progres tidak boleh kosong');

        // Pastikan modal tetap terbuka
        cy.get('#myModal').should('be.visible');
    });
});
