# Kompiuterių komponentų elektroninė parduotuvė

Šis projektas skirtas sukurti specializuotą elektroninę parduotuvę, skirtą tik kompiuterių komponentų pardavimui.

## Išskirtinės funkcijos

- Vartotojas gauna pranešimą, jei krepšelyje esantys produktai yra suderinami

## Kaip paleisti per Windows platforma?

1. Nusikopijuoti Kodą
```bash
$ git clone https://github.com/AugustasPauzas/BD1
```

2. Parsisiųsti ir Įsirašyti Composer
https://getcomposer.org/download/

3. Parsisiųsti ir Įsirašyti PHP (naudojama 8.3.10 versija)
https://www.php.net/downloads

4. Pridėti PHP į Windows PATH 
https://www.youtube.com/watch?v=n04w2SzGr_U

5. Parsisiųsti ir Įsirašyti MySQL Tai galima padaryti su XAMPP.
https://www.apachefriends.org/download.html
https://www.youtube.com/watch?v=co-xyHRdHRg

6. Migruoti Duomenų Bazę
```bash
$ php artisan migrate
```  

7. Paleisti Serverį
    7.1 1 Būdas
        Į konsolę rašome
```bash
$ php artisan serve
``` 

    7.2 2 Būdas
        Paleidžiamas run.bat failas esantis BD1 aplanke
    


## Naudojamos technologijos

- Laravel
- Bootstrap
- CSS
- JavaScript
- MySQL


