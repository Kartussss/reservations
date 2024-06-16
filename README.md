# reservations
Reservations

aplikácia je postavená nad dvomi kontajnermi  tableReservation (laravel+vue) a database (mysql)  spúšťanými  pomocou docker-compose.
Docker compose a v ňom definované služby boli vytvorené prostredníctvom laravel sail a spúštajú sa ako sail up.
Autentizácia bola dodaná prostredníctvom Starter Kits - Breeze and React / Vue s využitím Inertie, pre frontend je z defaultu ponechaný tailwind.

Do aplikácie bol dodaný package "moment" pre porovnávanie časových záznamov.

Aplikácia pozná stránky
- / (localhost/)
- /reservations (localhost/reservations) s modalom pre vytváranie rezervácií
- /contact (localhost/contact)


Z definície úlohy a spracovania, som nenašiel miesto pre testovanie Unit testami, feature testy neboli súčasťou zadania, ale existujú pre defaultný modul registrácie.
