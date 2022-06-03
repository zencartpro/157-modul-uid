# 157-modul-uid
UID für Zen Cart 1.5.7 deutsch

Hinweis: 
Freigegebene getestete Versionen für den Einsatz in Livesystemen ausschließlich unter Releases herunterladen:
* https://github.com/zencartpro/157-modul-uid/releases

Dieses Modul erweitert die Kundendaten mit einem Feld für die UID für Firmenkunden innerhalb der EU.
Die UID wird bei der Registrierung und bei der Bearbeitung in der Administration online überprüft am System VIES
Firmen mit gültiger UID aus EU-Ländern außerhalb des Shoplandes werden dann im Shop bei einer Bestellung die Steuern sofort rückerstattet. 
Der Status der Überprüfung ist bei jedem Kunden mit UID in der Shopadministration ersichtlich.

* Dieses Modul wurde gegenüber früheren Version komplett überarbeitet und verwendet als Codebasis nun das Modul Vat4Eu von lat9
Frühere Versionen haben die Steuerausweisung im UID-Fall komplett entfernt, diese Version tastet die Preise nicht an, sondern zieht die Steuer mit entsprechenden Hinweisen in Warenkorb, Checkout und Rechnung sofort wieder ab.

* In der Administration ist ersichtlich, ob die UID wirklich bei VIES geprüft wurde oder von einem Administrator ohne VIES Prüfung hinterlegt wurde.
Wurde die UID nicht erfolgreich geprüft, so dass sie eine Adminbestätigung erfordert, wird dem Kunden im Shop ein entsprechender Hinweis angezeigt und solange die UID nicht bestätigt wurde, erfolgt kein Abzug der Steuer.

* Auf der Rechnung und auch auf der pdf Rechnung erscheinen UID des Kunden und ein Hinweis auf die innergemeinschaftliche steuerfreie Lieferung in folgendem Format:
steuerfreie innergemeinschaftliche Lieferung | Unsere UID: ATU1234567 | Ihre UID: DE1234567 

* User von älteren Versionen dieses Moduls, die bereits UID Daten in den Kundendaten hinterlegt haben, können diese mit einem beiliegenden Konvertierungsscript in die neue Datenbankstruktur des Moduls übernehmen.

* Die neue Version des Moduls erfordert fast keine Änderungen in Corefiles mehr, alles was möglich ist, wird mit Observern gelöst, so dass die Installation äußerst einfach ist.

* Hinweis:
Die Überprüfung bei VIES wird via SOAP durchgeführt. Stellen Sie daher sicher, dass in Ihrer PHP Konfiguration die SOAP Extension aktiv ist.

Changelog Version 3.1.1:
* 2022-06-03 webchills 
* Umstellung der Funktionalität auf die Codebasis von Vat4EU von lat9 (https://github.com/lat9/vat4eu)

Änderungen gegenüber des Originalmoduls:
* deutsche Übersetzung hinzugefügt
* Anpassung des Installers für die deutsche Zen Cart Version
* Verwendung der ohnehin in der deutschen Zen Cart Version vorhandenen EU Länderliste
* Zusatzeinstellung für eigene Shop UID
* Konfig "VAT Refund for in-country purchases" entfernt
* Ausgabe des Hinweistextes im Format steuerfreie innergemeinschaftliche Lieferung | Unsere UID: ATU1234567 | Ihre UID: DE1234567 
* Integration einer Konvertierungsmöglichkeit für die bereits vom früheren Modul 2.x hinterlegten UIDs
