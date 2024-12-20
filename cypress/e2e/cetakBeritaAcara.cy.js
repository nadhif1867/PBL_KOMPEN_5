describe('Cetak Berita Acara Kompen', () => {
    const baseUrl = 'http://127.0.0.1:8000';

    beforeEach(() => {
        cy.visit(`${baseUrl}/mUpdateProgresTugasKompen`);
    });

    it('1.1 Cetak berita acara dengan data valid', () => {
        cy.get('#table_user tbody tr')
            .first()
            .within(() => {
                cy.get('a.btn-primary') // Pastikan tombol cetak memiliki class ini
                    .should('have.attr', 'href') // Pastikan atribut href ada
                    .then((href) => {
                        // Validasi URL cetak berita acara
                        expect(href).to.match(/\/cetak-berita-acara\/[0-9]+$/);

                        // Kunjungi URL cetak berita acara
                        cy.visit(href);
                    });
            });

        // Pastikan PDF berhasil di-load
        cy.url().should('include', '/cetak-berita-acara/');
        cy.get('embed') // Jika PDF di-load menggunakan tag embed
            .should('have.attr', 'type', 'application/pdf');
    });
});
