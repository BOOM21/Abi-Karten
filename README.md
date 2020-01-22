# Abi-Karten
Kartensystem für den Abiturjahrgang 2020 des Otto-Hahn-Gymnasiums (QR-Codes)


Frameworks JQuery und Bootstrap
Zur Generierung der QR Codes wird die QRServer Api verwendet.
Die Pdf Dokumente werden über tcpdf generiert

Zur Darstellung und Berechnung der Wegbeschreibung und der dazugehörigen Karte wird die Google Cloud Maps Platform (Directions API, Distance Matrix API, Maps Embed API, Maps JavaScript API und Geolocation API) genutzt

Gehostet wird die Seite auf einer Debian 10 VM meines Homeservers, den ich über Proxmox verwalte. Die MySQL zum Apache Service läuft ebenfalls auf dieser VM
