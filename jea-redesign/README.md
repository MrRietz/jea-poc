# Team Jea PHP-POC

Det här är PHP-versionen av Team Jea-MVP:n.

## Krav

- PHP 8 installerat
- PowerShell eller annan terminal

## Starta sidan

Gå till projektmappen:

```powershell
cd C:\repo-privat\jea-forslag
```

Starta sedan PHP:s inbyggda webbserver från POC-mappen:

```powershell
php -S 127.0.0.1:8080 -t .\poc\jea-redesign
```

Öppna sedan:

```text
http://127.0.0.1:8080
```

Om `php` inte finns i PATH kan du använda full sökväg till `php.exe`, till exempel:

```powershell
& "C:\Users\rietzr\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" -S 127.0.0.1:8080 -t .\poc\jea-redesign
```

## Viktiga sidor

- Start: `http://127.0.0.1:8080/index.php`
- Videos: `http://127.0.0.1:8080/videos.php`
- Grunder: `http://127.0.0.1:8080/ovningar.php`
- Forts: `http://127.0.0.1:8080/forts.php`
- Login: `http://127.0.0.1:8080/login.php`

## Uppdatera videodata

Om du vill hämta om videolistan från `jea.se`, kör:

```powershell
powershell -ExecutionPolicy Bypass -File .\poc\jea-redesign\scripts\refresh-live-videos.ps1
```

Det scriptet:

- hämtar videolistan
- sparar cache i `poc/jea-redesign/cache/videos-live.json`
- kör en teckenkodningsfix efteråt

## Vanliga problem

`php : The term 'php' is not recognized`

Det betyder att PHP inte ligger i PATH. Använd full sökväg till `php.exe` eller lägg till PHP i PATH.

`Not Found`

Det brukar betyda att servern startats i fel mapp eller utan `-t .\poc\jea-redesign`.

Rätt kommando är:

```powershell
php -S 127.0.0.1:8080 -t .\poc\jea-redesign
```

## Stoppa servern

Tryck `Ctrl + C` i terminalen där servern körs.
