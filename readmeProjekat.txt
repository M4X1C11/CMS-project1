Laravel Advanced CMS

Ovo je Content Management System (CMS) napravljen u Laravelu koji omogućava upravljanje sadržajem sajta kroz administrativni panel. Sistem je namenjen administratorima i editorima za kreiranje, uređivanje i brisanje postova, uz podršku za kategorije, tagove, komentare i SEO-friendly URL-ove.

Funkcionalnosti

Autentifikacija korisnika

Registracija i prijava korisnika

Uloge: admin i editor

Kontrola pristupa preko Policies i Gate

Postovi

CRUD operacije (create, read, update, delete)

Povezivanje postova sa kategorijama i tagovima

Automatsko generisanje slug-a iz naslova

SEO-friendly URL-ovi sa 301 redirect-om pri promeni sluga

Kategorije i Tagovi

Poseban CRUD za kategorije i tagove

Many-to-many veza između postova i tagova

Komentari

Registrovani korisnici mogu da ostavljaju komentare

Brisanje komentara dozvoljeno autoru ili adminu

Autorizacija preko CommentPolicy

Rich Text Editor

Integrisan WYSIWYG editor (TinyMCE) za uređivanje sadržaja postova

Pretraga i paginacija

Pretraga postova po naslovu

Paginacija rezultata

Tehnologije

Laravel 10+

PHP 8.2

Blade templating

MySQL

Bootstrap 5

TinyMCE

Napomena

Projekat je napravljen sa fokusom na:

čistu strukturu koda

pravilno korišćenje Eloquent relacija

Laravel best practices (Form Requests, Policies, Gate, eager loading)