# EenvoudigeDatabase

EenvoudigeDatabase is een eenvoudige PHP + MySQL CRUD-applicatie voor het beheren van studenten.

## Functionaliteit
- Create: nieuwe student toevoegen.
- Read: overzicht van studenten tonen.
- Update: bestaande student wijzigen.
- Delete: student verwijderen met bevestiging.
- Extra SQL-filters op dashboard:
	- zoeken via `LIKE` (naam/e-mail)
	- sorteren via `ORDER BY`
	- maximum aantal resultaten via `LIMIT`

## Projectstructuur
```
public/
	index.php              # router
src/
	config/
		database.php         # db instellingen
	models/
		Database.php         # PDO connectie
	controllers/
		CRUDController.php   # query-logica
	views/
		dashboard.php
		create.php
		edit.php
		delete.php
setup.sql
README.md
```

## Installatie (XAMPP)
1. Zet de map in `c:\xampp\htdocs\websites\EenvoudigeDatabase`.
2. Start Apache en MySQL in XAMPP.
3. Maak database en tabel aan met `setup.sql`.
4. Controleer db-login in `src/config/database.php`.
5. Open in browser:
	 - `http://localhost/websites/EenvoudigeDatabase/public/index.php`

## Technische keuzes
- Gebruik van PDO met prepared statements voor veilige queries.
- Simpele MVC-opbouw: model, controller, views.
- Server-side validatie op naam en e-mail.
- Output wordt ge-escaped met `htmlspecialchars`.
- Bootstrap gebruikt voor overzichtelijke tabellen en formulieren.

## AVG / basisbeveiliging
- Alleen noodzakelijke gegevens voor studentenadministratie.
- Inputvalidatie op server-side.
- Bescherming tegen SQL-injectie via prepared statements.
- Geen gevoelige extra persoonsgegevens opgeslagen.

## Bekende beperkingen
- Dit is een schoolproject en bewust eenvoudig gehouden.
- Geen login-systeem of rollenbeheer.
- Geen geautomatiseerde unit tests.

## Testen
Zie `TESTVERSLAG.md` voor handmatige testgevallen en resultaten in het Nederlands.