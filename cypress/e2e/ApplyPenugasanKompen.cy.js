describe('Test Case: Apply Penugasan Kompen', () => {
    const baseUrl = 'http://127.0.0.1:8000';
    // const baseUrl = 'https://sikomti.cloud';
    beforeEach(() => {
      // Navigasi langsung ke halaman tanpa login
      cy.visit(baseUrl + '/mLihatPilihKompen'); // Halaman Lihat dan Pilih Kompen
    });

    // it('Klik apply pada tugas kompen yang masih tersedia', () => {
    //   // Tunggu data dimuat
    //   cy.get('#table_user tbody', { timeout: 10000 }).should('exist'); // Pastikan tabel ada

    //   // Cari baris mana pun dengan tombol Apply yang tersedia
    //   cy.get('#table_user tbody tr').each((row, index) => {
    //     cy.wrap(row).within(() => {
    //       cy.get('a.btn-primary.btn-sm').then((btn) => {
    //         if (btn.length > 0) {
    //           // Jika tombol Apply ditemukan, klik tombol tersebut
    //           cy.wrap(btn).click();

    //           // Validasi notifikasi berhasil
    //           cy.get('.alert-success')
    //             .should('be.visible') // Notifikasi terlihat
    //             .and('contain', 'Permintaan tugas admin berhasil diajukan'); // Pesan notifikasi

    //           // Validasi status berubah menjadi "Berhasil Apply"
    //           cy.wrap(row).within(() => {
    //             cy.get('button.btn-secondary.btn-sm').should('contain', 'Berhasil Apply');
    //           });

    //           return false; // Hentikan iterasi setelah menemukan dan mengklik tombol Apply
    //         }
    //       });
    //     });
      //});
      it('Klik apply pada tugas kompen yang masih tersedia', () => {
        // Tunggu data dimuat
        cy.get('#table_user tbody', { timeout: 10000 }).should('exist'); // Pastikan tabel ada

        // Klik tombol Apply pada tugas pertama
        cy.get('#table_user tbody tr')
          .first()
          .within(() => {
            cy.get('a.btn-primary.btn-sm').click(); // Klik tombol Apply
          });

        // Tunggu hingga alert success muncul
        cy.get('.alert-success', { timeout: 10000 }) // Tunggu hingga 10 detik
          .should('be.visible') // Notifikasi terlihat
          .and('contain', 'Permintaan tugas admin berhasil diajukan'); // Pesan notifikasi
      });


    });

