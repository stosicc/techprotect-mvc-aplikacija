
TechProtect – Sistem za prijavu i praćenje servisiranja elektronskih uređaja

TechProtect je web aplikacija izrađena kao završni projekat, sa ciljem da omogući korisnicima jednostavnu i efikasnu prijavu problema sa uređajima, kao i pregled statusa servisiranja u realnom vremenu. Aplikaciju mogu koristiti i obični korisnici i administratori.

---

Namena aplikacije

Aplikacija je namenjena:

- fizičkim i pravnim licima koji žele da prijave kvar na elektronskom uređaju
- servisnom centru koji upravlja prijavama i vodi evidenciju o statusima servisa

Omogućava praćenje svih faza popravke, dodavanje komentara servisera, kao i čuvanje slike oštećenog uređaja.

---

Tipovi korisnika

Aplikacija razlikuje dve uloge korisnika:

1. Korisnik (klijent) – može da:
   - Registruje se i prijavi
   - Prijavi kvar na uređaju
   - Doda opis i sliku
   - Vidi sve svoje prijavljene servise i njihove statuse

2. Administrator (serviser) – može da:
   - Vidi sve prijave svih korisnika
   - Filtrira prijave po statusu i tipu sistema
   - Menja status servisa (npr. u obradi, završeno)
   - Unosi komentar servisera
   - Dodaje datum završetka

---

Funkcionalnosti

Korisnički deo
 Registracija i prijava korisnika (sigurno sa hashovanjem lozinke)
 Prikaz imena korisnika nakon prijave
 Prijava novog kvara preko formulara
 Upload slike uređaja (slika se snima u `uploads/`)
 Pregled svih prethodnih prijava

Admin deo
 Pregled svih prijava korisnika
 Mogućnost filtriranja po **statusu** i **tipu uređaja**
 Uređivanje statusa i dodavanje komentara
 Automatsko evidentiranje datuma završetka ako je status "Završeno"
 Statistički prikaz broja servisa po statusu i tipu

---

Struktura projekta

```
config/
    └── db.php

controllers/
    └── ServisiController.php
    └── DeviceController.php
    └── HomeController.php
    └── AuthController.php
models/
    ├── Servis.php
    └── User.php 
    └── Device.php
views/
    ├── home.php
    ├── layout.php
    ├── register.php
    ├── login.php
    └── servisi/
        ├── add.php
        ├── moji-servisi.php
        ├── statistika.php
        ├── list.php
        └── edit.php

uploads/
    └── (slike uređaja)
public/
    ├── css/
    └── js/

index.php
routes.php

```

---

Tehnička specifikacija

- PHP 
- MySQL baza podataka
- Sigurna autentifikacija (hash lozinke + sesije)
- Pristup po ulogama (`admin` vs `klijent`)

---

Baza podataka (osnovne tabele)

- `st_klijenti` – korisnici aplikacije (ime, email, lozinka, tip)
- `st_servisi` – sve prijave (tip, opis, datum, status, komentar, slika)
- `st_tipovi_sistema` – tipovi uređaja (alarm, kamera, laptop...)

---
Login podaci:

Korisnik: 
email: test1@gmail.com
password: 123

Admin:
email: admin@gmail.com
password: 123

Link aplikacije: https://usp2022.epizy.com/sup25/st/index.php

Autor

Projekat izradio: Stanislav Tošić
Fakultet: ALFA BK
Godina: 2025
