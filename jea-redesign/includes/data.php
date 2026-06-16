<?php

$momentDetails = require __DIR__ . '/moment-details.php';
require_once __DIR__ . '/live-videos.php';

$member = [
    'name' => 'Hedvig',
    'displayName' => 'Hedvig och Wilma',
    'dog' => 'Wilma',
    'balance' => 250,
    'nextClass' => 'Söndag 22 juni, 10:00 i Vröd',
    'unreadFeedback' => 1,
    'dogNote' => 'Wilma behöver lugnare starter i fotgående och kortare pass när tempot går upp.',
];

$dogs = [
    [
        'name' => 'Wilma',
        'focus' => 'Fotgående och handtarget',
        'progress' => '4 blå, 2 gröna, 1 ny video',
        'coach_note' => 'Bra att filma korta pass när ni tränar ingångar.',
    ],
    [
        'name' => 'Lexie',
        'focus' => 'Stanna kvar',
        'progress' => '2 gröna, 3 vita',
        'coach_note' => 'Nästa steg är att lägga på lite mer avstånd.',
    ],
];

$announcements = [
    [
        'title' => 'Lystring och hyfs inför störningsträning',
        'author' => 'Jea/Ozzy',
        'time' => '09:59',
        'audience' => 'Alla medlemmar',
        'body' => 'Varje störningsträning startar med lystring, koppelhyfs, stanna kvar och visitation. Efteråt markerar du själv momenten gröna eller röda.',
    ],
    [
        'title' => 'GRUNDER kompletteras med FORTS',
        'author' => 'Jea/Ozzy',
        'time' => '10:01',
        'audience' => 'Alla medlemmar',
        'body' => 'Grunder och fortsättning hör ihop. Börja i grunderna och fortsätt sedan vidare med momenten på nästa nivå när basen sitter.',
    ],
    [
        'title' => 'Aktuellt-flödet fungerar som blogg',
        'author' => 'Jea/Ozzy',
        'time' => '14:50',
        'audience' => 'Alla medlemmar',
        'body' => 'Här kommer nyheter, korta instruktioner och viktiga meddelanden till medlemmarna. Titta gärna in här ofta.',
    ],
];

$videos = [
    [
        'id' => 676,
        'title' => 'Wilma i ingång höger',
        'dog' => 'Wilma',
        'member' => 'Hedvig',
        'exercise' => 'Footwork position',
        'moment_code' => 'FFO-12',
        'status' => 'Behöver uppföljning',
        'date' => '2026-06-13',
        'coach_note' => 'Belöna från vänster och invänta sittet innan du flyttar dig. Fyra riktigt bra repetitioner räcker.',
        'consent_site' => true,
        'consent_book' => true,
        'live_endpoint' => 'videos/vidshw.php?vidid=676&Xsgn=Eliza',
        'save_endpoint' => 'videos/vidshw2.php',
        'video_url' => 'https://www.jea.se/videos/uploads/Messenger_creation_1669219287524126.mp4',
        'summary' => [
            'Belöna från vänster för rakare position.',
            'Invänta fullt sitt innan nästa repetition.',
            'Avsluta medan Wilma fortfarande erbjuder rätt beteende.',
        ],
    ],
    [
        'id' => 677,
        'title' => 'Wilma i handtarget',
        'dog' => 'Wilma',
        'member' => 'Hedvig',
        'exercise' => 'Handtarget',
        'moment_code' => 'HND-03',
        'status' => 'Feedback klar',
        'date' => '2026-06-11',
        'coach_note' => 'Bra värde i handen. Fortsätt belöna direkt i target innan du ökar störningen.',
        'consent_site' => true,
        'consent_book' => false,
        'live_endpoint' => 'videos/vidshw.php?vidid=677&Xsgn=Eliza',
        'save_endpoint' => 'videos/vidshw2.php',
        'video_url' => 'https://www.jea.se/videos/uploads/VID-20260613-WA0001(1).mp4',
        'summary' => [
            'Håll kriteriet enkelt när tempot blir högre.',
            'Bra moment att koppla ihop med fotposition.',
            'Kan markeras klar men är bra att återkomma till.',
        ],
    ],
    [
        'id' => 675,
        'title' => 'Wilma i stanna kvar',
        'dog' => 'Wilma',
        'member' => 'Hedvig',
        'exercise' => 'Stanna kvar',
        'moment_code' => 'STK-08',
        'status' => 'Ny',
        'date' => '2026-06-13',
        'coach_note' => 'Ny video i kön. Jea behöver skriva feedback och välja nästa momentkod.',
        'consent_site' => true,
        'consent_book' => false,
        'live_endpoint' => 'videos/vidshw.php?vidid=675&Xsgn=Eliza',
        'save_endpoint' => 'videos/vidshw2.php',
        'video_url' => 'https://www.jea.se/videos/uploads/Messenger_creation_1669219287524126.mp4',
        'summary' => [
            'Visar tydligt varför video behöver egen sida.',
            'Bra kandidat för nästa steg-ruta.',
            'Skulle i live läsas från samma videolista som idag.',
        ],
    ],
];

$liveVideos = jea_fetch_live_videos();
if ($liveVideos !== []) {
    $videos = $liveVideos;
}

$featuredVideo = $videos[0];

$videoAdminQueue = [
    [
        'title' => 'Ny video väntar på feedback',
        'video_id' => 675,
        'member' => 'Hedvig',
        'dog' => 'Wilma',
        'consent_site' => 'Ja',
        'consent_book' => 'Nej',
        'action' => 'Skriv feedback, välj momentkod och markera som klar.',
    ],
    [
        'title' => 'Momentkod behöver justeras',
        'video_id' => 676,
        'member' => 'Hedvig',
        'dog' => 'Wilma',
        'consent_site' => 'Ja',
        'consent_book' => 'Ja',
        'action' => 'Spara via VIDSAV när momentet ska kopplas om.',
    ],
];

if ($liveVideos !== []) {
    $videoAdminQueue = [];
    foreach (array_slice($videos, 0, 6) as $video) {
        $videoAdminQueue[] = [
            'title' => $video['status'] === 'Ny' ? 'Ny video väntar på feedback' : 'Video att följa upp',
            'video_id' => $video['id'],
            'member' => $video['member'],
            'dog' => $video['dog'],
            'consent_site' => $video['consent_site'] ? 'Ja' : 'Nej',
            'consent_book' => $video['consent_book'] ? 'Ja' : 'Nej',
            'action' => $video['status'] === 'Ny'
                ? 'Skriv feedback och koppla rätt momentkod.'
                : 'Gå igenom feedback, titel och momentkod.',
        ];
    }
}

$grunderGroups = [
    [
        'title' => 'Lystring',
        'description' => 'Bas för kontakt, lek och miljöstabilitet innan svårare övningar.',
        'items' => [
            ['name' => 'Jobba', 'description' => 'Startsignal för att kunna gå in i träning med fokus.', 'detail_html' => '<p><strong>Jobbläge</strong> är enligt live-texten det första hunden ska lära sig, så grundligt att det blir en reflex.</p><p>Jea beskriver flera sätt att nöta in det: vid handmatning, ute på promenad och i miljöer med andra hundar. Tanken är att frågan om hunden vill jobba ska bli ett tydligt mentalt påslag utan att hunden alltid direkt måste prestera ett moment.</p>', 'status' => 'Grön', 'video_linked' => true],
            ['name' => 'Leka', 'description' => 'Bygger engagemang och värde i samarbete med föraren.', 'detail_html' => '<p>På live-sajten beskrivs <strong>Skavileka?</strong> som en fråga, inte ett kommando. Målet är att hunden ska uppfatta röstläge, kroppsspråk och förväntan som start för lek.</p><p>Jea lyfter särskilt dragkamp, dold leksak bakom ryggen och att man väntar in hundens nyfikna fokus innan leken startas.</p>', 'status' => 'Blå', 'video_linked' => true],
            ['name' => 'Namn', 'description' => 'Snabb respons på tilltal och kontakt tillbaka till föraren.', 'detail_html' => '<p>Syftet är att hunden verkligen lär sig sitt namn för inkallning och fokus i skarpa lägen.</p><p>Jeas popup beskriver att hunden först ska vara i jobbläge, att man säger namnet när hunden fokuserar på något annat, väntar ut ögonkontakt och markerar direkt när kontakten kommer.</p>', 'status' => 'Grön', 'video_linked' => false],
            ['name' => 'Handklapp', 'description' => 'Enkel fokusväxling och start på följsamhet.', 'detail_html' => '<p>Handklapp beskrivs som ett tydligt, konsekvent ljud som skär igenom mycket av omgivningen och fungerar som belöning i sig.</p><p>Live-texten använder det främst i inkallning och andra moment där hunden ska komma till föraren, och betonar att det måste nötas till reflexnivå.</p>', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Ett-Två-Tre', 'description' => 'Rytmisk övning för fokus, väntan och trygghet.', 'status' => 'Blå', 'video_linked' => true],
            ['name' => 'Sniff', 'description' => 'Kontrollerad nosanvändning som avlastning och belöning.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Prassel', 'description' => 'Miljö- och störningsträning med ljud och rörelse.', 'status' => 'Vit', 'video_linked' => false],
        ],
    ],
    [
        'title' => 'Position och fokus',
        'description' => 'Verktyg som används överallt i Team Jeas fortsatta träning.',
        'items' => [
            ['name' => 'Inklickning', 'description' => 'Tydlig markörträning som skapar förståelse för rätt beteende.', 'status' => 'Grön', 'video_linked' => false],
            ['name' => 'Fokus', 'description' => 'Hunden lär sig stanna kvar mentalt i uppgiften.', 'status' => 'Blå', 'video_linked' => false],
            ['name' => 'Handtarget', 'description' => 'Styrning, motivation och precision i ett enkelt verktyg.', 'detail_html' => '<p>Jea beskriver handtarget som mycket användbart för att positionera hunden, bland annat i footwork.</p><p>Det börjar med öppen handflata framför nosen och snabb markering när hunden väljer att nudda. Sedan kan övningen flyttas, vinklas och användas som byggsten i andra moment.</p>', 'status' => 'Grön', 'video_linked' => true],
            ['name' => 'Tasstarget', 'description' => 'Kontroll över framtassar och kroppsmedvetenhet.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Target nudd', 'description' => 'Kort och tydlig targetkontakt för precision.', 'status' => 'Grön', 'video_linked' => true],
            ['name' => 'Target följ', 'description' => 'Följa target i rörelse utan att tappa fokus.', 'status' => 'Blå', 'video_linked' => false],
            ['name' => 'Target sänd', 'description' => 'Skickas mot target med självständighet.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Target överföring', 'description' => 'Flyttar förståelsen från hjälpen till det riktiga momentet.', 'status' => 'Vit', 'video_linked' => false],
        ],
    ],
    [
        'title' => 'Berikning och självförtroende',
        'description' => 'Lekfulla övningar som bygger mod, initiativ och kroppskontroll.',
        'items' => [
            ['name' => 'Vilken hand?', 'description' => 'Nosarbete, problemlösning och lugnt fokus.', 'status' => 'Grön', 'video_linked' => false],
            ['name' => 'Ta lyra', 'description' => 'Greppa, våga testa och interagera med föremål.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Äventyr', 'description' => 'Miljöträning med utforskande och tryggt samarbete.', 'status' => 'Blå', 'video_linked' => false],
            ['name' => 'Dragkamp', 'description' => 'Lek som belöning och relationsbyggare.', 'status' => 'Grön', 'video_linked' => false],
            ['name' => 'Jaga boll', 'description' => 'Motivation, fart och kontroll i belöning.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => '1-2-3', 'description' => 'Enkel struktur för väntan och belöningsförväntan.', 'status' => 'Blå', 'video_linked' => false],
            ['name' => 'Runtom', 'description' => 'Kroppsmedvetenhet och riktning runt förare eller objekt.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Gångmatta', 'description' => 'Underlagsvana och trygghet i rörelse.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Liggmatta', 'description' => 'Lugn stationering och av/på-reglering.', 'status' => 'Grön', 'video_linked' => false],
        ],
    ],
    [
        'title' => 'Initiativ och hantering',
        'description' => 'Delar från live-sidan som blandar problemlösning med vardagshantering.',
        'items' => [
            ['name' => 'Gör nåt / inlärning', 'description' => 'Hunden testar beteenden och lär sig erbjuda.', 'status' => 'Blå', 'video_linked' => false],
            ['name' => 'Gör nåt / test', 'description' => 'Avstämning av initiativförmåga och förståelse.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Lyfta och bära', 'description' => 'Trygg hantering i vardag och träning.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Visitation', 'description' => 'Förberedelse för kontroll, tävling och vardagshantering.', 'detail_html' => '<p>Popuptexten för visitation går igenom bett, tänder, ögon, öron och allmän hantering. Fokus är att hunden ska kunna kontrolleras lugnt och tryggt utan konflikt.</p><p>Det gör övningen viktig både för vardag, tävling och allmän trygghet kring kroppskontakt.</p>', 'status' => 'Grön', 'video_linked' => false],
            ['name' => 'Betthantering', 'description' => 'Mjuk hantering av mun och tänder.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Ögonhantering', 'description' => 'Trygghet vid undersökning och kontakt nära ansiktet.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Öronhantering', 'description' => 'Förbereder hunden för vård och kontroll.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Klohantering', 'description' => 'Minskar stress kring kloklippning.', 'status' => 'Röd', 'video_linked' => false],
            ['name' => 'Munkorg', 'description' => 'Vänj in tryggt och utan konflikt.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Massage', 'description' => 'Lugn, beröring och återhämtning.', 'status' => 'Blå', 'video_linked' => false],
        ],
    ],
    [
        'title' => 'Hyfs och tentor',
        'description' => 'Vardagskontroll plus de tentor som verkar användas som avstämningar i systemet.',
        'items' => [
            ['name' => 'Koppelhyfs', 'description' => 'Gå fint och kunna vänta utan att dra.', 'status' => 'Blå', 'video_linked' => false],
            ['name' => 'Stanna kvar', 'description' => 'Stadga och trygg väntan i korta steg.', 'detail_html' => '<p>På live-sidan är målet att hunden ska kunna stanna kvar när föraren springer några meter bort, framåt och runt hunden.</p><p>Jea betonar att hundens uppgift här är att inte göra något, vilket ändå kräver inlärning eftersom det naturliga ofta är att följa efter föraren.</p>', 'status' => 'Vit', 'video_linked' => true],
            ['name' => 'Låt bli / Vänta', 'description' => 'Impulskontroll med tydliga kriterier.', 'status' => 'Blå', 'video_linked' => false],
            ['name' => 'Inkallning', 'description' => 'Komma in snabbt och tryggt från störning.', 'detail_html' => '<p>Inkallningen bygger enligt Jeas text vidare på handklapp, namn och motivationsövningar.</p><p>Målet i grunderna är att hunden ska kunna komma in från störning, med tydlig belöning när den väljer föraren och stor vikt vid att göra det roligt att vara nära igen.</p>', 'status' => 'Grön', 'video_linked' => true],
            ['name' => 'Gå bakom', 'description' => 'Positionsbyte och följsamhet runt föraren.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Tenta lystring', 'description' => 'Avstämning av uppmärksamhet och samarbete.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Tenta lek', 'description' => 'Avstämning av lekmotivation och engagemang.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Tenta hantering', 'description' => 'Avstämning av trygghet i kroppshantering.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Tenta hyfs', 'description' => 'Avstämning av vardagskontroll.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Tenta footwork 1', 'description' => 'Första kontroll på fotgåendegrunderna.', 'status' => 'Vit', 'video_linked' => true],
        ],
    ],
];

$fortsGroups = [
    [
        'title' => 'Grundövningar',
        'description' => 'Fortsättningens grundmoment hämtade direkt från live-sidan.',
        'items' => [
            ['name' => 'Utgångsläge', 'description' => 'Startposition inför mer precisa moment.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Ingång höger', 'description' => 'Positionsarbete från andra sidan för kroppskontroll.', 'detail_html' => '<p>Live-texten säger att hunden först bör vara säker på att nudda target, att föraren inte ska klicka förrän utförandet verkligen känns rätt och att övningen gärna ska filmas.</p><p>Det här är alltså ett mer precist tekniskt moment än bara en vanlig positionsövning.</p>', 'status' => 'Blå', 'video_linked' => true],
            ['name' => 'Inkallning', 'description' => 'Mer precision och kontroll än i grunderna.', 'detail_html' => '<p>I fortsättningsdelen skrivs inkallningen som mer formell och tävlingsmässig. Jea kopplar den till tidigare byggstenar som inklickning, kamplek, sitt framför och namn.</p><p>Tanken är att hunden redan ska tycka att tillvaron hos föraren är så värdefull att själva signalen blir lätt att förstärka.</p>', 'status' => 'Vit', 'video_linked' => true],
            ['name' => 'Läggande', 'description' => 'Snabbt och tydligt läggande under arbete.', 'detail_html' => '<p>Live-popupen för läggande beskriver stegvis inlärning med underlag, träning hemma först och sedan gradvis ökade störningar.</p><p>Det gör momentet väldigt konkret och lämpar sig bra för att visas i en egen beskrivningsruta i MVP:n.</p>', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Sitta kvar', 'description' => 'Stadga på nästa nivå med längre krav.', 'detail_html' => '<p>Beskrivningen på jea.se förklarar att hunden ska kunna stanna kvar sittande eller liggande när föraren lämnar den.</p><p>Proceduren är konsekvent: hunden i utgångsläge, kommendering, föraren lämnar och återvänder under tydliga kriterier.</p>', 'status' => 'Vit', 'video_linked' => false],
        ],
    ],
    [
        'title' => 'Footwork',
        'description' => 'Egen grupp i live-systemet med tydlig koppling till tävlingsfotgående.',
        'items' => [
            ['name' => 'Footwork position', 'description' => 'Säker grundposition vid sidan.', 'detail_html' => '<p>Jeas popuptext för footwork position utgår från att hunden redan kan target följa. Föraren ska ha pinnen i höger hand så spetsen syns utanför vänster sida i noshöjd.</p><p>Det är alltså en detaljerad teknisk övning för att bygga exakt position innan marsch, starter och vändningar.</p>', 'status' => 'Blå', 'video_linked' => true],
            ['name' => 'Footwork marsch', 'description' => 'Rörelse i fotposition med bibehållen precision.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Footwork start', 'description' => 'Själva igångsättandet av rörelsen.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Footwork förflyttning', 'description' => 'Korta förflyttningar och kontroll i position.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Footwork vändning', 'description' => 'Svängar utan att tappa linje eller fokus.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Footwork tempo', 'description' => 'Växla tempo utan att tappa kvalitet.', 'status' => 'Vit', 'video_linked' => false],
        ],
    ],
    [
        'title' => 'Lydklass',
        'description' => 'Moment som pekar mot lydnadsklass och programträning.',
        'items' => [
            ['name' => 'Footwork', 'description' => 'Fotgående i tävlingsform.', 'detail_html' => '<p>Live-beskrivningen anger kommandot <strong>Fot</strong> och beskriver hur hunden villigt ska följa vid förarens vänstra sida med huvudet eller bogen i jämnhöjd med förarens ben.</p><p>Den tar också upp högersväng, vänstersväng, språngmarsch och halt, vilket gör den mer lik en regel- eller tävlingsbeskrivning.</p>', 'status' => 'Vit', 'video_linked' => true],
            ['name' => 'Inkallning', 'description' => 'Tävlingsmässig inkallning.', 'status' => 'Vit', 'video_linked' => true],
            ['name' => 'Sitt under marsch', 'description' => 'Stadga och förarkontroll under rörelse.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Apportering', 'description' => 'Hålla, hämta och avlämna med rätt känsla.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Fjärrdirigering', 'description' => 'Skiften på avstånd med precision.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Hopp', 'description' => 'Hoppmoment med kontroll och trygghet.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Programmet', 'description' => 'Sätta ihop flera moment i en helhet.', 'status' => 'Vit', 'video_linked' => false],
        ],
    ],
    [
        'title' => 'Rallylydnad',
        'description' => 'Skyltar och följsamhet i rallylydnadsflöde.',
        'items' => [
            ['name' => 'Helvarv höger', 'description' => 'Hel sväng åt höger med bibehållet samarbete.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Helvarv vänster', 'description' => 'Hel sväng åt vänster med position kvar.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Sitt ligg', 'description' => 'Positionsväxling enligt skylt.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Sitt stå', 'description' => 'Positioner i följd med kontroll.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Sitt framför', 'description' => 'Frontposition och snabb återgång.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Sitt gå runt', 'description' => 'Stadga när föraren rör sig runt hunden.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Åttan', 'description' => 'Rörelsemönster runt koner med fokus kvar.', 'status' => 'Vit', 'video_linked' => false],
            ['name' => 'Skyltar', 'description' => 'Helhetsträning med flera rallymoment i följd.', 'status' => 'Vit', 'video_linked' => false],
        ],
    ],
];

$momentCodeByName = [
    'Grundövningar::Inkallning' => '3708',
    'Lydklass::Footwork' => '4301',
    'Lydklass::Inkallning' => '4302',
    'Hyfs och tentor::Inkallning' => '3605',
    'Jobba' => '2802',
    'Leka' => '2803',
    'Namn' => '2804',
    'Handklapp' => '2806',
    'Ett-Två-Tre' => '2808',
    'Sniff' => '2809',
    'Prassel' => '2810',
    'Inklickning' => '3004',
    'Fokus' => '3016',
    'Handtarget' => '3020',
    'Tasstarget' => '3021',
    'Target nudd' => '3022',
    'Target följ' => '3024',
    'Target sänd' => '3026',
    'Target överföring' => '3028',
    'Vilken hand?' => '3101',
    'Ta lyra' => '3102',
    'Äventyr' => '3103',
    'Dragkamp' => '3105',
    'Jaga boll' => '3106',
    '1-2-3' => '3108',
    'Runtom' => '3110',
    'Gångmatta' => '3112',
    'Liggmatta' => '3114',
    'Gör nåt / inlärning' => '3202',
    'Gör nåt / test' => '3204',
    'Lyfta och bära' => '3401',
    'Visitation' => '3402',
    'Betthantering' => '3403',
    'Ögonhantering' => '3404',
    'Öronhantering' => '3405',
    'Klohantering' => '3406',
    'Munkorg' => '3407',
    'Massage' => '3408',
    'Koppelhyfs' => '3601',
    'Stanna kvar' => '3602',
    'Låt bli / Vänta' => '3603',
    'Gå bakom' => '3607',
    'Tenta lystring' => '3902',
    'Tenta lek' => '3903',
    'Tenta hantering' => '3906',
    'Tenta hyfs' => '3909',
    'Tenta footwork 1' => '3912',
    'Utgångsläge' => '3705',
    'Ingång höger' => '3706',
    'Läggande' => '3709',
    'Sitta kvar' => '3710',
    'Footwork position' => '3801',
    'Footwork marsch' => '3802',
    'Footwork start' => '3803',
    'Footwork förflyttning' => '3805',
    'Footwork vändning' => '3807',
    'Footwork tempo' => '3808',
    'Sitt under marsch' => '4303',
    'Apportering' => '4304',
    'Fjärrdirigering' => '4305',
    'Hopp' => '4306',
    'Programmet' => '4307',
    'Helvarv höger' => '4401',
    'Helvarv vänster' => '4402',
    'Sitt ligg' => '4403',
    'Sitt stå' => '4404',
    'Sitt framför' => '4408',
    'Sitt gå runt' => '4410',
    'Åttan' => '4412',
    'Skyltar' => '4418',
];

function enrich_moment_groups(array &$groups, array $codeByName, array $detailMap): void
{
    foreach ($groups as &$group) {
        foreach ($group['items'] as &$item) {
            $lookupKey = $group['title'] . '::' . $item['name'];
            $resolvedCode = $codeByName[$lookupKey] ?? $codeByName[$item['name']] ?? null;

            if ($resolvedCode === null) {
                continue;
            }

            $item['code'] = $resolvedCode;

            if (isset($detailMap[$item['code']])) {
                $item['detail_html'] = $detailMap[$item['code']];
            }
        }
    }
}

enrich_moment_groups($grunderGroups, $momentCodeByName, $momentDetails);
enrich_moment_groups($fortsGroups, $momentCodeByName, $momentDetails);

$theory = [
    [
        'title' => 'Belöningstiming',
        'summary' => 'När markeringen ska komma och hur du undviker att hunden blir sned i position.',
    ],
    [
        'title' => 'Korta pass',
        'summary' => 'Fyra riktigt bra repetitioner ger ofta bättre utveckling än tio halvdana.',
    ],
    [
        'title' => 'Så läser du färgerna i matrisen',
        'summary' => 'Vit betyder nytt eller ej startat, blå pågående, grön klart och röd behöver backas eller göras om.',
    ],
];

$events = [
    [
        'date' => '2026-06-22',
        'time' => '10:00',
        'place' => 'Vröd',
        'status' => 'Bokad',
        'attendees' => ['Hedvig/Wilma', 'Esther', 'Molly'],
        'note' => 'Önskemål kan lämnas vid bokning, precis som i liveflödet.',
        'request_state' => 'Avboka',
    ],
    [
        'date' => '2026-06-29',
        'time' => '17:00',
        'place' => 'Lund',
        'status' => 'Öppen',
        'attendees' => ['Peach', 'Lexie'],
        'note' => 'Två platser kvar. Visa deltagare direkt i kortet.',
        'request_state' => 'Boka',
    ],
    [
        'date' => '2026-07-03',
        'time' => '10:00',
        'place' => 'THIF',
        'status' => 'Få platser kvar',
        'attendees' => ['Hedvig/Wilma'],
        'note' => 'Detaljvy kan senare kopplas mot TJUTV och BOKAV.',
        'request_state' => 'Visa detaljer',
    ],
];

$payments = [
    ['label' => 'Månadsavgift', 'date' => '2026-06-01', 'amount' => 100],
    ['label' => 'Träning Vröd', 'date' => '2026-06-14', 'amount' => 100],
    ['label' => 'Inbetalning', 'date' => '2026-06-15', 'amount' => -200],
    ['label' => 'Utestående', 'date' => 'Idag', 'amount' => 250],
];

$apiMap = [
    ['method' => 'POST', 'path' => 'tj/TJdog.php', 'purpose' => 'Laddar hund- och medlemskontext efter inloggning.', 'payload' => 'Xpsw=hedvig123'],
    ['method' => 'POST', 'path' => 'tj/LOGG.php', 'purpose' => 'Skapar logg/session efter sidbesök.', 'payload' => 'funk=VISIT&script=start&Xsgn=Eliza&Xhid=846'],
    ['method' => 'POST', 'path' => 'tj/EVENTS.php', 'purpose' => 'Hämtar event, bokningar och deltagare.', 'payload' => 'Xevkod=*&Xsgn=Eliza&Xhid=846&Xhnm=Hedvig'],
    ['method' => 'POST', 'path' => 'tj/chat.php', 'purpose' => 'Laddar aktuellt-/bloggflödet.', 'payload' => 'sessiondata med Xsgn, Xhid och Xeki'],
    ['method' => 'POST', 'path' => 'tj/handle_chat.php', 'purpose' => 'Skickar, hämtar och raderar inlägg.', 'payload' => 'action=fetch eller action=send'],
    ['method' => 'POST', 'path' => 'videos/vidlst.php', 'purpose' => 'Hämtar videolistan.', 'payload' => 'actvid=0&Xsgn=Eliza'],
    ['method' => 'GET', 'path' => 'videos/vidshw.php', 'purpose' => 'Hämtar specifik video och feedback.', 'payload' => 'vidid=676&Xsgn=Eliza'],
    ['method' => 'POST', 'path' => 'videos/vidshw2.php', 'purpose' => 'Sparar feedback, titel och kodning.', 'payload' => 'nyfre=<html>&mokod=0&nytit=&vidid=676'],
    ['method' => 'POST', 'path' => 'videos/VIDSAV.php', 'purpose' => 'Sparar momentkod i videolistan.', 'payload' => 'vidid=676&vidmom=FFO-12'],
    ['method' => 'POST', 'path' => 'tj/TRANING.php', 'purpose' => 'Hämtar GRUNDER, FORTS och TEORI.', 'payload' => 'TRANTAVL=TRAN eller TAVL eller TEORI'],
    ['method' => 'POST', 'path' => 'tj/TRANEKI.php', 'purpose' => 'Hämtar hundspecifika träningsanteckningar.', 'payload' => 'mhid=846'],
    ['method' => 'POST', 'path' => 'tj/TRANEKI2.php', 'purpose' => 'Sparar Jeas eller medlemmens noteringar.', 'payload' => 'textdata för vald hund'],
    ['method' => 'POST', 'path' => 'tj/AVGLIST.php', 'purpose' => 'Hämtar saldo och avgiftsrader.', 'payload' => 'Xsign=Eliza&Xhid=846&Xsku=0++'],
    ['method' => 'POST', 'path' => 'tj/TRANDB.php', 'purpose' => 'Sparar momenttext, kommentarer och status.', 'payload' => 'momentrelaterad postdata'],
    ['method' => 'POST', 'path' => 'XTJ/BOKAV.php', 'purpose' => 'Bokar av klass/event.', 'payload' => 'utvidnr=<id>'],
    ['method' => 'POST', 'path' => 'tj/TJUTV.php', 'purpose' => 'Visar detaljer för träningstillfälle.', 'payload' => 'thisevent=<kod>&acthid=846&Ehnm=Hedvig'],
];

$exercises = [
    ['title' => 'Lystring', 'level' => 'Grund', 'summary' => 'Bygg snabb uppmärksamhet och tydlig respons på signal.'],
    ['title' => 'Footwork position', 'level' => 'Grund', 'summary' => 'Forma säker vänstersida med mindre hjälp från händer och kropp.'],
    ['title' => 'Stanna kvar', 'level' => 'Grund', 'summary' => 'Korta, trygga stadgor med tydlig frikommendering.'],
    ['title' => 'Handtarget', 'level' => 'Grund', 'summary' => 'Enkel övning som går att återanvända i många kedjor.'],
    ['title' => 'Störningsträning', 'level' => 'Forts', 'summary' => 'Lägg på miljö, människor och väntetid utan att tappa struktur.'],
    ['title' => 'Transporter', 'level' => 'Forts', 'summary' => 'Träna rörelse mellan moment så att hunden behåller fokus.'],
];
$member = jea_normalize_array($member);
$dogs = jea_normalize_array($dogs);
$announcements = jea_normalize_array($announcements);
$videos = jea_normalize_array($videos);
$featuredVideo = jea_normalize_array($featuredVideo);
$videoAdminQueue = jea_normalize_array($videoAdminQueue);
$grunderGroups = jea_normalize_array($grunderGroups);
$fortsGroups = jea_normalize_array($fortsGroups);
$theory = jea_normalize_array($theory);
$events = jea_normalize_array($events);
$payments = jea_normalize_array($payments);
$apiMap = jea_normalize_array($apiMap);
$exercises = jea_normalize_array($exercises);
