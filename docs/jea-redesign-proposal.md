# Team Jea Redesign Proposal

## 1. Sammanfattning

Nuvarande `www.jea.se` innehåller redan nästan all funktionalitet som Team Jea behöver i vardagen. Problemet är alltså inte i första hand att funktioner saknas, utan att de är svåra att hitta, svåra att söka i och svåra att använda konsekvent för både Jea och medlemmar.

Förslaget är därför att behålla nuvarande grund med PHP och jQuery-kompatibelt arbetssätt, men bygga om upplevelsen till en tydligare medlemsportal med:

- en riktig startsida
- ett tydligt videoområde
- separata sidor för `Grunder`, `Forts` och `Teori`
- tydligare boknings- och avgiftsvyer
- samtycke direkt i uppladdningsflödet
- stöd för meddelanden/chat
- bättre sök och filter där innehållet är stort

Det här dokumentet är anpassat efter den MVP/prototyp som nu finns både i PHP och som statisk HTML-version.

## 2. Vad Som Observerades

Genomgången med Playwright och endpoint-scanningen visade att live-sidan redan innehåller:

- lösenordsinloggning
- medlems- och hundkontext
- bokning av event och klasser
- videolista, videodetalj och möjlighet för Jea att skriva feedback
- träningsmatriser för `GRUNDER`, `FORTS` och `TEORI`
- hundspecifika anteckningar
- avgifts- och betalningslogik
- ett fungerande meddelande-/chatflöde som också används som blogg/aktuelltflöde

Identifierade endpoints:

- `tj/TJdog.php`
- `tj/LOGG.php`
- `tj/EVENTS.php`
- `tj/chat.php`
- `tj/handle_chat.php`
- `tj/TRANING.php`
- `tj/TRANEKI.php`
- `tj/TRANEKI2.php`
- `tj/TRANDB.php`
- `tj/AVGLIST.php`
- `tj/TJUTV.php`
- `XTJ/BOKAV.php`
- `videos/vidlst.php`
- `videos/vidshw.php`
- `videos/vidshw2.php`
- `videos/VIDSAV.php`

Viktiga iakttagelser:

- videos ligger i dag gömda bakom popup-/overlayflöden i stället för att ha en riktig videosida
- övningsinformation finns, men ligger gömd bakom klickbara popuptexter per moment
- `Aktuellt`/chatflödet fyller en viktig funktion och bör inte tas bort
- sajten har redan tillräckligt mycket riktigt innehåll för att stödja en praktisk redesign utan att man behöver hitta på nya produktområden

## 3. Funktioner Som Inte Får Försvinna

Följande måste bevaras i redesignen:

- medlemsinloggning
- Jea/adminläge
- videouppladdning och videogranskning
- Jeas feedback på videos
- bokning av event/klasser
- teori som eget innehållsområde
- hund- och medlemsspecifika anteckningar och framsteg
- betalningsuppföljning och manuell markering av betalt
- chat-/meddelandefunktion
- övningsbeskrivningar per moment

Målet är att framtida sidan ska kännas som en enkel applikation, inte som en lång och spretig infosida.

## 4. Huvudproblem I Dagens Sida

### 4.1 Informationsstruktur

Viktiga områden ligger blandade med varandra:

- videos
- träning
- teori
- klasser
- avgifter
- hundens framsteg
- meddelanden

Det gör att användaren måste förstå systemet i förväg för att kunna hitta rätt.

### 4.2 Videoupplevelsen

Videoområdet är ett av de viktigaste områdena att förbättra.

- videos bör vara ett förstaklassområde i navigationen
- feedback måste vara lätt att hitta
- Jea måste snabbt kunna se kö, status och samtycke
- medlemmar måste snabbt kunna hitta sina egna videos

### 4.3 Hittbarhet För Övningar

Själva träningsinnehållet är starkt, men svårt att överblicka.

- momentbeskrivningar är gömda bakom popupinteraktioner
- stora matriser är svåra att skanna
- det finns nästan inget stöd för att snabbt hitta en viss övning

### 4.4 Aktuellt Och Meddelanden

Nuvarande `Aktuellt`/chat-funktion verkar fylla en verklig vardagsfunktion och bör behållas.

- Jea behöver kunna lägga ut uppdateringar synligt
- medlemmar bör kunna skicka meddelanden
- meddelandeflödet bör gå att söka i eller åtminstone vara lätt att bläddra i efterhand

### 4.5 Tydlighet Kring Avgifter

Nuvarande avgiftslogik verkar användbar internt, men medlemmar behöver tydligare se:

- vad som ska betalas
- vad som redan är betalt
- vad varje post gäller

## 5. Rekommenderad Struktur

Föreslagen toppnavigation:

1. Start
2. Aktuellt
3. Videos
4. Grunder
5. Forts
6. Teori
7. Klasser
8. Avgift
9. Login/Admin

Det här stämmer bättre med hur innehållet faktiskt ser ut än mer abstrakta menyer.

## 6. Rekommenderad Sök- Och Filterstrategi

Alla sidor behöver inte sök direkt från dag ett. Prioriteringen bör vara:

### Hög Prioritet

- `Videos`
- `Grunder`
- `Forts`

### Medelprioritet

- `Aktuellt`
- `Teori`

### Lägre Prioritet / Filter Räcker Troligen

- `Klasser`
- `Avgift`

Rekommenderad sök- och filterfunktion:

- `Videos`: hund, medlem, övning, momentkod, datum, status, samtycke
- `Videos`: årsfilter bör vara centralt så att sidan inte visar hela historiken i en enda lång lista
- `Grunder/Forts`: övningsnamn, övningstext, kategori
- `Aktuellt`: rubrik, meddelandetext, avsändare, målgrupp
- `Klasser`: filter på datum, plats och bokningsstatus
- `Avgift`: filter på datum och posttyp

Nuvarande MVP-prioritering:

- redan implementerat: `Videos`, `Grunder`, `Forts`
- nästa naturliga steg: `Aktuellt`
- senare vid behov: `Teori`, `Klasser`, `Avgift`

## 7. Rekommenderade Innehållsmönster

### Videos

Varje video bör visa:

- hund
- medlem
- datum
- övning
- momentkod
- Jeas feedback
- status
- samtycke för visning på hemsidan
- separat samtycke för bok/QR-användning

### Övningar

Varje övning bör visa:

- övningsnamn
- kort sammanfattning
- status
- om video finns kopplad
- expanderbar full beskrivning

MVP:n använder nu expanderbar information direkt i sidan i stället för popup, vilket passar bättre både på mobil och desktop.

### Aktuellt / Chat

Systemet bör stödja både:

- Jeas egna informationsinlägg
- snabba medlemsmeddelanden till Jea eller gruppen

Samma backend kan initialt driva både informationsflöde och meddelandeflöde.

## 8. Rekommenderade Flöden

### Flöde A: Medlem Skickar In En Video

1. Medlem öppnar `Skicka video`
2. Väljer hund
3. Väljer övning eller ämne
4. Skriver en kort kommentar
5. Godkänner obligatoriskt samtycke för lagring och visning på sajten
6. Kan valfritt godkänna användning i bok/QR-material
7. Laddar upp videon
8. Videon dyker upp under `Videos`
9. Jea granskar och skriver feedback
10. Medlemmen ser statusändring och feedback

### Flöde B: Jea Granskar Videos

1. Jea öppnar `Videos`
2. Filtrerar på år, status eller sökning
3. Öppnar rätt video
4. Ser övning, feedbackläge och samtycke
5. Skriver eller uppdaterar feedback
6. Uppdaterar momentkod och status

### Flöde C: Medlem Använder Övningssidorna

1. Medlem öppnar `Grunder` eller `Forts`
2. Söker eller bläddrar efter rätt kategori
3. Expanderar övningsinformationen
4. Tittar på kopplade videos vid behov
5. Tränar och skickar sedan in egen video

### Flöde D: Meddelande / Chat

1. Jea eller medlem öppnar `Aktuellt`
2. Skriver ett meddelande
3. Väljer målgrupp vid behov
4. Skickar
5. Meddelandet blir en del av det synliga flödet

### Flöde E: Avgiftshantering

1. En avgiftspost är synlig för medlemmen
2. Medlemmen betalar
3. Jea markerar betalningen
4. Balansen uppdateras
5. Medlemmen ser vad som är nollat och vad som återstår

## 9. GDPR Och Samtycke

Detta är inte juridisk rådgivning, men ur produkt- och UX-perspektiv är den säkraste modellen:

- obligatoriskt samtycke för lagring och visning på Team Jea-sajten
- separat frivilligt samtycke för användning i bokmaterial och QR-länkat material
- tydlig text i direkt anslutning till uppladdningen
- samtyckesstatus synlig på varje sparad video

Det är tydligare och starkare än att bara ha en allmän formulering om ägande.

## 10. Förslag På Svensk Samtyckestext

### Obligatoriskt Samtycke

> När du skickar in video till Team Jea bekräftar du att du har rätt att dela materialet och att Team Jea får lagra, bearbeta och visa videon på hemsidan som en del av träningen och återkopplingen. Inskickat material kan vara synligt för andra medlemmar beroende på hur tjänsten är upplagd.

### Frivilligt Utökat Samtycke

> Jag godkänner även att Team Jea får använda min inskickade video eller stillbilder från videon i utbildningsmaterial, bokmaterial, digitalt material och material som nås via QR-kod.

### Föreslagna Kryssrutor

- `Jag godkänner lagring och visning på hemsidan.`
- `Jag godkänner även användning i bokmaterial och QR-länkar.`
- `Jag har rätt att dela materialet och har informerat eventuella personer som syns i videon.`

## 11. Teknisk Rekommendation

Den mest riskfria vägen framåt är fortfarande:

- behåll PHP för rendering och backend
- behåll jQuery där lättviktiga interaktioner behövs
- förbättra mallar, layout, navigation och datapresentation
- återanvänd nuvarande endpoints innan en större omskrivning övervägs

Föreslagna faser:

### Fas 1

- tydligare struktur
- riktig startsida
- riktig videosida
- separata träningssidor
- integrerat samtycke
- synlig sök på de största innehållsytorna
- tydligare avgiftsvy
- synligt meddelandeflöde

### Fas 2

- utökad sök och filter på resterande sidor
- datastädning för videos, medlemmar, avgifter och övningar
- tydligare rollhantering

### Fas 3

- adminförbättringar
- loggning / audit trail
- djupare normalisering av data

## 12. Kopplingskarta: Vad Behöver Kopplas Till Vad

Det här är den praktiska kartan över hur MVP:n kan kopplas mot nuvarande backend på `jea.se`.

### Start

- sida: `index.php`
- läser från:
  - `tj/chat.php` för aktuelltinlägg
  - `videos/vidlst.php` för senaste videoaktivitet
  - `tj/EVENTS.php` för nästa klass eller aktivitet
  - `tj/AVGLIST.php` för balans och avgiftssammanfattning

### Aktuellt

- sida: `aktuellt.php`
- läser från:
  - `tj/chat.php`
- skriver till:
  - `tj/handle_chat.php`
- kommentar:
  - bör stödja både Jeas informationsinlägg och medlemsmeddelanden
  - sök är användbart här, men inte lika kritiskt som på videosidorna och övningssidorna

### Videos

- sida: `videos.php`
- läser från:
  - `videos/vidlst.php` för videolistan
  - `videos/vidshw.php` för detaljvisning
  - `videos/vidshw2.php` för Jeas redigeringsläge
- skriver till:
  - `videos/VIDSAV.php`
- kommentar:
  - sök bör finnas på hund, medlem, övning, moment och feedback
  - årsfilter bör finnas för att undvika jättelånga listor
  - samtycke för hemsida och bok/QR bör sparas på själva videon
  - i den lokala PHP-prototypen läses livevideos just nu via cachefilen `poc/jea-redesign/cache/videos-live.json`
  - den cachen uppdateras med `poc/jea-redesign/scripts/refresh-live-videos.ps1`

### Grunder

- sida: `ovningar.php`
- läser från:
  - `tj/TRANING.php`
  - `tj/TRANEKI.php`
  - `tj/TRANEKI2.php`
  - `tj/TRANDB.php`
- skriver till:
  - ingen huvudskrivning i MVP:n, utan länkar främst vidare till video- och uppföljningsflödet
- kommentar:
  - övningstext bör visas expanderbart direkt i sidan
  - sök bör matcha kategori, övningsnamn och full beskrivning

### Forts

- sida: `forts.php`
- läser från:
  - `tj/TRANING.php`
  - `tj/TRANEKI.php`
  - `tj/TRANEKI2.php`
  - `tj/TRANDB.php`
- skriver till:
  - främst via kopplade video- och adminflöden
- kommentar:
  - samma interaktionsmodell som `Grunder`
  - sökbar momenttext är viktig även här

### Teori

- sida: `teori.php`
- läser från:
  - `tj/TJUTV.php`
- kommentar:
  - sök är inte lika brådskande i fas 1 om teoriinnehållet är relativt begränsat

### Klasser

- sida: `klasser.php`
- läser från:
  - `tj/EVENTS.php`
  - `XTJ/BOKAV.php`
- skriver till:
  - `XTJ/BOKAV.php`
- kommentar:
  - filter på datum, plats och bokningsstatus är viktigare än fri textsökning i början

### Avgift

- sida: `betalningar.php`
- läser från:
  - `tj/AVGLIST.php`
- skriver till:
  - nuvarande betalnings-/nollningsflöde som Jea redan använder
- kommentar:
  - här räcker sannolikt filter på år eller betalt/obetalt i ett första steg

### Login / Medlemskontext

- sida: `login.php`
- läser/skriver via:
  - `tj/TJdog.php`
  - nuvarande sessions- och loginhantering på sajten
- kommentar:
  - redesignen bör inte skapa en ny inloggningsmodell
  - nuvarande medlems-, hund- och adminkontext bör behållas och få ett tydligare gränssnitt ovanpå sig

### Statisk HTML-Demo

- mapp: `poc/jea-redesign-html/`
- syfte:
  - demo för genomgång
  - enkel publicering på GitHub / GitHub Pages
- begränsningar:
  - ingen liveinloggning
  - inga liveuppdateringar
  - ingen direktkoppling till livevideos
- kommentar:
  - HTML-versionen bör hållas visuellt synkad med PHP-MVP:n
  - PHP-versionen är den riktiga integrationsvägen

## 13. Teknisk Integrationsspec

Det här avsnittet kompletterar kopplingskartan ovan och beskriver vad som faktiskt behöver kopplas för att redesignen ska fungera mot nuvarande backend.

### 13.1 Övergripande Princip

- behåll nuvarande sessionsmodell och medlemskontext
- rendera gärna sidorna i PHP även i redesignen
- använd samma backend-endpoints som i nuvarande sajt i första läget
- flytta förbättringen till struktur, presentation, sök, filter och tydligare flöden

Det betyder i praktiken att redesignen inte först ska ersätta backend, utan lägga ett tydligare gränssnitt ovanpå nuvarande logik.

### 13.2 Obligatorisk Grundkontext

För att flera av nuvarande anrop ska fungera behövs befintlig medlems- och sessionskontext. Den verkar kretsa kring värden som:

- `Xsgn`
- `Xhid`
- `Xhnm`
- `Xeki`
- ibland även hund- eller eventrelaterade nycklar

Det här måste därför bevaras:

- nuvarande loginflöde
- nuvarande session/cookie-hantering
- nuvarande sätt att avgöra medlem kontra Jea/admin

### 13.3 Sida För Sida: Exakt Vad Som Behöver Kopplas

### Start (`index.php`)

- läser från:
  - `tj/TJdog.php`
  - `tj/chat.php`
  - `tj/EVENTS.php`
  - `tj/AVGLIST.php`
  - `videos/vidlst.php`
- måste mappa:
  - medlemsnamn
  - hundnamn
  - nästa aktivitet
  - saldo
  - senaste videoaktivitet

### Aktuellt (`aktuellt.php`)

- läser från:
  - `tj/chat.php`
- skriver till:
  - `tj/handle_chat.php`
- måste bevara:
  - sessiondata som `Xsgn`, `Xhid`, `Xeki`
  - fetch/send-logik
- måste mappa:
  - avsändare
  - tid
  - målgrupp
  - meddelandetext

### Videos (`videos.php`)

- läser från:
  - `videos/vidlst.php`
  - `videos/vidshw.php`
  - `videos/vidshw2.php`
- skriver till:
  - `videos/vidshw2.php`
  - `videos/VIDSAV.php`
- måste bevara:
  - `actvid=0`
  - `vidid`
  - `Xsgn`
  - momentkodssparning
  - feedbacksparning
- måste mappa:
  - video-id
  - titel
  - datum
  - medlem
  - hund
  - momentkod
  - feedback
  - video-url
  - status i nya UI:t
  - samtycke för hemsida
  - samtycke för bok/QR
- verifiera:
  - exakt var samtyckesfälten ska sparas i nuvarande backend

### Grunder (`ovningar.php`)

- läser från:
  - `tj/TRANING.php`
  - `tj/TRANEKI.php`
  - `tj/TRANEKI2.php`
  - `tj/TRANDB.php`
- måste mappa:
  - kategori
  - momentnamn
  - full beskrivning
  - status/färg
  - hundspecifika noteringar
- viktigt:
  - popuptexterna från live-sidan behöver lyftas ut till inline-expansion

### Forts (`forts.php`)

- läser från:
  - `tj/TRANING.php`
  - `tj/TRANEKI.php`
  - `tj/TRANEKI2.php`
  - `tj/TRANDB.php`
- måste mappa:
  - samma fält som i `Grunder`
  - tydliga block för fortsättningsmoment

### Teori (`teori.php`)

- läser från:
  - `tj/TRANING.php`
  - `tj/TJUTV.php`
- måste mappa:
  - rubrik
  - teoritext
  - kategori
- verifiera:
  - om teoriinnehållet faktiskt kommer från en eller flera källor

### Klasser (`klasser.php`)

- läser från:
  - `tj/EVENTS.php`
  - `tj/TJUTV.php`
- skriver till:
  - `XTJ/BOKAV.php`
- måste mappa:
  - datum
  - tid
  - plats
  - deltagare
  - bokningsstatus
  - önskemål
- verifiera:
  - vilket anrop som bokar klass, inte bara avbokar

### Avgift (`betalningar.php`)

- läser från:
  - `tj/AVGLIST.php`
- måste mappa:
  - radtyp
  - datum
  - belopp
  - saldo
  - betalt/obetalt
- viktigt:
  - Jeas nollning av betalningar får inte tappas bort

### Login (`login.php`)

- läser/skriver via:
  - `tj/TJdog.php`
  - nuvarande sessionsflöde
- måste bevara:
  - enkel lösenordsinloggning i MVP-läget
  - medlems-, hund- och adminkontext

### 13.4 Det Som Måste Verifieras Innan Livekoppling

- exakt responsformat från varje endpoint
- exakt vilka parametrar som är obligatoriska
- om alla endpoints kräver aktiv session
- var samtycke ska sparas
- vilket anrop som bokar klass
- vilka videofält som är Jea-specifika respektive medlemssynliga
- om `TRANEKI2.php` används för både läsning och skrivning

### 13.5 Slutsats

- ja, redesignen innehåller nu en konkret integrationskarta
- PHP-MVP:n är rätt spår för verklig inkoppling
- HTML-versionen är bara demo
- nästa steg är en faktisk inkopplingsfas sida för sida

## 14. Hostingbedömning

Det observerade teknikupplägget ser enkelt och pragmatiskt ut:

- Apache
- PHP 7.4
- jQuery-drivna AJAX-fragment
- statiska mediafiler i sajtmappar

Det betyder att en praktisk modernisering ovanpå nuvarande driftmodell är realistisk.

## 15. Vad Som Ingår I Nuvarande Leverans

Arbetet innehåller nu:

- en PHP-MVP i `poc/jea-redesign/`
- en statisk HTML-demo i `poc/jea-redesign-html/`
- expanderbara övningsbeskrivningar baserade på live-texter
- visning av samtycke på videonivå
- sök på `Videos`, `Grunder` och `Forts`
- årsfilter på `Videos`
- separata sidor för `Aktuellt`, `Videos`, `Grunder`, `Forts`, `Teori`, `Klasser`, `Avgift` och `Login`

Viktig notering:

- HTML-versionen fungerar bra som visningsdemo
- PHP-versionen behövs för verklig integration mot nuvarande backend

## 16. Rekommenderat Nästa Steg

Använd den uppdaterade MVP:n som diskussionsunderlag med Jea och besluta sedan om nästa steg ska vara:

1. en visuell uppfräschning ovanpå nuvarande backend
2. en omstrukturering av nuvarande backend på plats
3. en större ombyggnad senare när innehåll och struktur har stabiliserats

Den starkaste rekommendationen just nu är fortfarande alternativ 2: förbättra och strukturera om det befintliga systemet utan att kasta bort den affärslogik som redan fungerar.
