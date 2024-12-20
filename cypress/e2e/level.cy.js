describe('Test Case: Detail Level', () => {
    const baseUrl = 'https://sikomti.cloud'; // Ganti dengan URL backend Anda jika berbeda

    beforeEach(() => {
      // Mengunjungi halaman level
      cy.visit(baseUrl + '/aLevel'); // Halaman Daftar Level
      cy.intercept('POST', '/aLevel/list').as('getLevels'); // Pantau permintaan AJAX ke DataTables
      cy.wait('@getLevels'); // Tunggu respons AJAX selesai
    });

    it('Cek kesesuaian detail data level dengan database', () => {
      // Pastikan tabel DataTables ada
      cy.get('#table_level')
        .should('exist') // Tabel ada
        .and('be.visible'); // Tabel terlihat

      // Pastikan tabel memiliki data
      cy.get('#table_level tbody tr')
        .should('have.length.greaterThan', 0); // Tabel tidak kosong

      // Klik tombol detail pada level pertama
      cy.get('#table_level tbody tr')
        .first()
        .find('button.btn-info') // Tombol detail dengan kelas btn-info
        .click();

      // Tunggu modal muncul
      cy.get('#myModal')
        .should('be.visible') // Modal terlihat
        .within(() => {
          // Validasi data dalam modal
          cy.get('table')
            .should('exist')
            .within(() => {
              cy.get('tr').eq(0).find('th').contains('ID').should('exist');
              cy.get('tr').eq(0).find('td').should('not.be.empty');

              cy.get('tr').eq(1).find('th').contains('Level Kode').should('exist');
              cy.get('tr').eq(1).find('td').should('not.be.empty');

              cy.get('tr').eq(2).find('th').contains('Level Nama').should('exist');
              cy.get('tr').eq(2).find('td').should('not.be.empty');
            });
        });
    });

    it("Cek tombol 'Kembali' di halaman detail level", () => {
      // Klik tombol detail pada level pertama
      cy.get('#table_level tbody tr')
        .first()
        .find('button.btn-info') // Tombol detail dengan kelas btn-info
        .click();

      // Tunggu modal muncul
      cy.get('#myModal')
        .should('be.visible') // Modal terlihat
        .within(() => {
          // Klik tombol kembali di modal
          cy.get('button.btn-warning').click(); // Tombol Kembali
        });

      // Tambahkan waktu tunggu untuk animasi modal selesai
      cy.wait(500);

      // Pastikan modal tidak terlihat atau dihapus dari DOM
      cy.get('#myModal').should('not.exist'); // Modal sudah tidak ada
    });
  });
