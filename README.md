# Abi-Karten
Kartensystem für den Abiturjahrgang 2020 des Otto-Hahn-Gymnasiums (QR-Codes)


Frameworks JQuery und Bootstrap
Zur Generierung der QR Codes wird die QRServer Api verwendet.
Die Pdf Dokumente werden über tcpdf generiert

Zur Darstellung und Berechnung der Wegbeschreibung und der dazugehörigen Karte wird die Google Cloud Maps Platform (Directions API, Distance Matrix API, Maps Embed API, Maps JavaScript API und Geolocation API) genutzt

Screenshots und Demo für die Kartenkontrolle:

<img src="https://github.com/BOOM21/Abi-Karten/blob/master/Screenshots/Code_Recognized.PNG" alt="Allowed" width="200"/> <img src="https://github.com/BOOM21/Abi-Karten/blob/master/Screenshots/Already_In.PNG" alt="Already In" width="200"/> <img src="https://github.com/BOOM21/Abi-Karten/blob/master/Screenshots/Code_Unknown.PNG" alt="Denied" width="200"/>

Demo Video: https://yannic-hock.de/wp-content/uploads/2021/07/Demo-Vid.mp4



Gehostet wird die Seite auf einer Debian 10 VM meines Homeservers, den ich über Proxmox verwalte. Die MySQL zum Apache Service läuft ebenfalls auf dieser VM
