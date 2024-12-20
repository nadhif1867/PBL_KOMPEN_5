describe('Approve Mahasiswa dengan Data Valid', () => {
    const baseUrl = 'http://127.0.0.1:8000';

    beforeEach(() => {
      cy.visit(`${baseUrl}/aDikerjakanOleh`);
    });

    it('Approve mahasiswa dan hilangkan data dari daftar', () => {
      cy.get('#tabel_kompen tbody', { timeout: 10000 }).should('exist'); // Pastikan tabel ada

      cy.get('#tabel_kompen tbody tr')
        .its('length')
        .then((initialRowCount) => {
          cy.get('#tabel_kompen tbody tr')
            .first()
            .within(() => {
              cy.get('button.btn-success.btn-sm')
                .should('contain', 'Diterima')
                .click();
            });

          cy.get('#alert-container .alert-success', { timeout: 10000 })
            .should('be.visible')
            .and('contain', 'Progres dan Riwayat berhasil dibuat.');

          cy.get('#tabel_kompen tbody tr', { timeout: 10000 }).should(
            'have.length.lessThan',
            initialRowCount
          );
        });
    });
  });
