# Testverslag EenvoudigeDatabase

## Doel
Controleren of de CRUD-app correct werkt en voldoet aan de basiscriteria.

## Testomgeving
- Datum: 18-03-2026
- OS: Windows
- Server: XAMPP (Apache + MySQL)
- Browser: Chrome

## Geteste onderdelen
1. Create
2. Read
3. Update
4. Delete
5. Zoeken/sorteren/limit
6. Basisvalidatie

## Testgevallen en resultaten

### 1. Contact toevoegen (Create)
- Stappen:
  1. Open dashboard
  2. Klik op "New Contact"
  3. Vul naam en e-mail in
  4. Klik op "Create"
- Verwacht: nieuw contact verschijnt in lijst.
- Resultaat: geslaagd.

### 2. Contact wijzigen (Update)
- Stappen:
  1. Klik op "Edit" bij een bestaand contact
  2. Wijzig naam of e-mail
  3. Klik op "Save Changes"
- Verwacht: gewijzigde gegevens zichtbaar op dashboard.
- Resultaat: geslaagd.

### 3. Contact verwijderen (Delete)
- Stappen:
  1. Klik op "Delete"
  2. Bevestig verwijderen
- Verwacht: contact verdwijnt uit lijst.
- Resultaat: geslaagd.

### 4. Hergebruik van ID na verwijderen
- Stappen:
  1. Voeg 2 contacten toe (ID 1 en 2)
  2. Verwijder contact met ID 2
  3. Voeg nieuw contact toe
- Verwacht: nieuw contact krijgt ID 2.
- Resultaat: geslaagd.

### 5. Zoeken (LIKE)
- Stappen:
  1. Vul zoekterm in op dashboard
  2. Klik op "Apply"
- Verwacht: alleen contacten met overeenkomst in naam/e-mail.
- Resultaat: geslaagd.

### 6. Sorteren (ORDER BY)
- Stappen:
  1. Kies sorteeroptie (ID/Name/Email/Date)
  2. Kies volgorde (ASC/DESC)
  3. Klik op "Apply"
- Verwacht: lijst wordt correct gesorteerd.
- Resultaat: geslaagd.

### 7. Limiet (LIMIT)
- Stappen:
  1. Kies 10 / 25 / 50 / 100 rows
  2. Klik op "Apply"
- Verwacht: maximaal gekozen aantal rijen zichtbaar.
- Resultaat: geslaagd.

### 8. Ongeldige invoer
- Stappen:
  1. Laat naam leeg of vul ongeldige e-mail in
  2. Verstuur formulier
- Verwacht: foutmelding en niet opslaan.
- Resultaat: geslaagd.

## Conclusie
De applicatie werkt correct voor alle basis-CRUD-functies. Daarnaast zijn zoek-, sorteer- en limietfuncties aanwezig en functioneel. Basisbeveiliging met prepared statements en server-side validatie is toegepast. Voor een schoolproject is dit voldoende en logisch opgebouwd.
