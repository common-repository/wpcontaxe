=== wpCONTAXE ===
Contributors: CONTAXE
Tags: manage ads, contaxe, affiliate, ads, monetize, monetization, widget, income, advertising, advertisement, werbung, geld verdienen, revenue, money, banner, banners, intext
Requires at least: 3.3
Tested up to: 3.3.1
Stable tag: 1.3.2

CONTAXE-Werbemittel in Ihren Wordpress-Blog einbinden.

== Description ==

wpCONTAXE ermöglicht es WordPress-Nutzern die vielfältigen Werbeformen von CONTAXE einfach in ihren Blog zu integrieren. 

wpCONTAXE 1.3.2 benötigt mindestens WordPress 3.3. Falls du Fehler in wpCONTAXE gefunden hast oder Verbesserungsvorschläge hast erreichst du uns über unser [Kontaktformular](http://www.contaxe.com/de/kontakt/). 

= API-Key =
Ab sofort ist für wpCONTAXE ein API-Key nötig. Dieser kann auf https://www.contaxe.com/de/wordpressplugin/ generiert und anschließend in den allgemeinen Einstellungen des Plugins eingetragen werden.

= Features =
* Einfache Integration aller Werbeformate einschließlich der InText-Werbung sowie des [Intelligent Search Ads](http://www.intelligent-search-ad.com/).
* Viele Positionierungsmöglichkeiten:
  * Manuell in Beiträgen/Seiten
  * Automatisch am Anfang/Ende oder direkt in der Mitte von Beiträgen/Seiten
  * In der Sidebar (durch max. drei verschiedene Widgets)
  * Im Template
* Einzelne Beiträge/Seiten von InText-Werbeschaltung bzw. der automatischen Bannerplatzierung ausschließen oder auf Wunsch ganz werbefrei halten.
* Sichtbarkeit der Anzeigen einstellbar durch ein umfassendes Regelsystem.

= Geplante Features =
* Einstellungen für InText-Werbung/Intelligent Search Ad automatisch aus einem Bannercode übernehmen.

== Installation ==

1. Lade das Verzeichnis `wpcontaxe` in das `/wp-content/plugins/` Verzeichnis deiner Wordpress-Installation.
2. Aktiviere das Plugin über das Menü 'Plugins' in WordPress.
3. Konfiguriere das Plugin über den neuen Menüpunkt 'CONTAXE-Werbung'.

== Frequently Asked Questions ==

= Warum sehe ich nur Demo-Werbung? =

Bei wpCONTAXE können Einstellungen zur Sichtbarkeit der Werbung vorgenommen werden. Um Eigenklicks zu verhindern ist dort standardmäßig festgelegt, dass Administratoren nur Demo-Werbung sehen. Dies kann unter "Allgemeine Einstellungen"  in wpCONTAXE geändert werden.

= Warum wird die InText-Werbung nicht eingebunden? =

Wenn die InText-Werbung nicht eingebunden wird kann dies mehrere Ursachen haben:

1. InText-Werbung ist nicht aktiviert.
2. Du hast weder in den Allgemeinen Einstellungen noch in den Einstellungen zur InText-Werbung einen Channel ausgewählt.
3. Du hast den Beitrag mit Hilfe von `<!--wpcontaxe_no_hl-->` von der InText-Werbeschaltung ausgeschlossen.
4. In dem verwendeten Template fehlt `<?php wp_footer(); ?>` in der Datei footer.php.
5. Die InText-Werbung wird zwar eingebunden, man sieht davon jedoch nichts da zu keinem der Wörter auf der Seite relevante Werbung gefunden werden konnte. In diesem Fall prüfe bitte, ob InText-Werbung auf anderen Seiten deines Blogs funktioniert.
6. Du bist als Administrator eingeloggt. Standardmäßig ist InText-Werbung dann deaktiviert, um Eigenklicks zu verhindern. 

= Wie kann ich das Einblenden von Werbung innerhalb einzelner Beiträge verhindern? =

Die Einblendung von CONTAXE Werbung innerhalb von Beiträgen kann verhindert werden durch Hinzufügen des nachfolgenden Codes an einer beliebigen Position im Beitrag:

* `<!--wpcontaxe_no_ads-->` - gar keine Werbung im Beitrag 
* `<!--wpcontaxe_no_banners-->` - keine Banner im Beitrag
* `<!--wpcontaxe_no_hl-->` - keine InText-Werbung im Beitrag

== Upgrade Notice ==

= 1.3.0 =
In den allgemeinen Einstellungen muss ab sofort ein API-Key eingetragen werden, der auf https://www.contaxe.com/de/wordpressplugin/ generiert werden kann.

= 1.2.3 =
Die mit wpCONTAXE in Version 1.2.2 oder kleiner getroffenen Widget-Einstellungen gehen beim Update verloren und müssen erneut vorgenommen werden. 

== Changelog ==

= 1.3.2 =
* Neue Option in den allgemeinen Einstellungen um die Prüfung des SSL-Zertifikats bei API-Aufrufen zu deaktivieren.

= 1.3.1 =
* Detailliertere Fehlermeldung bei fehlgeschlagenen API-Aufrufen.

= 1.3.0 =
* Anpassung an die neuen Bannercodes, um Direktbuchungen zu ermöglichen.
* Ab sofort ist für wpCONTAXE ein API-Key nötig, welcher auf https://www.contaxe.com/de/wordpressplugin/ generiert werden kann.

= 1.2.5 =
* Editor-Integration an WordPress 3.3 angepasst.

= 1.2.4 =
* Syntax-Fehler behoben (bei short_open_tag=Off).

= 1.2.3 =
* Das Plugin an die neue Widget-API angepasst. Ab sofort ist möglich unbegrenzt viele CONTAXE-Widgets zu platzieren.

= 1.2.2 =
* Einen Fehler behoben der dazu geführt hat, dass beim Ändern eines Banners immer "kontextsensitiv, mit zufälliger Werbung auffüllen wenn nicht ausreichend relevante Anzeigen vorhanden sind" eingestellt wurde.

= 1.2.1 =
* Darstellungsproblem im Adminbereich behoben.

= 1.2.0 =
* Zusätzliche Regeln für das Regelsystem: Anzahl der Wörter im Beitrag; Datum des Beitrags innerhalb eines Zeitraums.
* Unterstützung für mehrere Werbeformen (Textbanner, Grafikbanner, Flashbanner, ...) an einem Werbeplatz. 

= 1.1.5 =
* Das Löschen von Bannern umgestellt, damit es auch mit WordPress 2.5 funktioniert.
* Falsche ID beim Medium Rectangle (2x2, Text) korrigiert.

= 1.1.4 =
* In Version 1.1.3 übersehenes Formularfeld umbenannt. (Das Speichern der Positionseinstellungen funktioniert jetzt wieder mit beiden Buttons.)

= 1.1.3 =
* Formularfelder umbenannt um einen 403-Fehler durch eine schlecht formulierte mod_security-Regel zu verhindern.
* Beta-Status entfernt

= 1.1.2 =
* InText-Vorschau repariert

= 1.1.1 =
* Regel für Startseite hinzugefügt

= 1.1.0 =
* Regelsystem für InText-Werbung und Banner
* Tooltips für Erklärungs-Texte

= 1.0.2 =
*  Fehler bei automatischer Positionierung in der Mitte von Beiträgen behoben. 

= 1.0.1 =
* Editor-Integration repariert.
* Beispiel-Code für Template-Integration repariert.
* Beispiel-Code in Bannerauflistung entfernt.
* Nur Demo-Banner in Beitrags-Vorschau anzeigen.
* Werbung auf 404-Seiten verbergen.
* Verbesserte Hinweise nach dem Speichern der Einstellungen/Banner.
* Zufällige Werbung ist standardmäßig aktiviert bei neuen Bannern.
* Banner können in Text-Widgets integriert werden (selbe Syntax wie in Beiträgen).
* Einbindung der zusätzlichen Plugin-Dateien verändert. Behebt ein Problem mit open_basedir.

= 1.0.0 =
* Erstes Release
