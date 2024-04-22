# Mercadona Spy

Mercadona Spy és una aplicació que sincronitza dades de productes de la botiga en línia de Mercadona utilitzant la seva API i els emmagatzema en una base de dades. A més, proporciona notificacions en temps real sobre pujades de preus a través de Telegram.

## Instal·lació

1. Clona aquest repositori a la teva màquina local:

```bash
git clone https://github.com/MiguelMart22/m9-mercadona.git
```

2. Instal·la les dependències del projecte utilitzant Composer:

```bash
composer install
```

3. Copia l'arxiu `.env.example` i reanomena'l a `.env`. Llavors, configura les variables d'entorn necessàries, com la connexió a la base de dades i les credencials de l'API de Telegram.

4. Genera una nova clau d'aplicació amb la comanda `php artisan key:generate`.

5. Executa les migracions de la base de dades per crear les taules necessàries:

```bash
php artisan migrate
```

## Ús

Abans de sincronitzar els productes de Mercadona, necessites obtenir les categories disponibles. Executa la següent comanda per recollir les categories:

```bash
php artisan fetch:categories
```

Un cop hagis obtingut les categories, pots sincronitzar els productes amb la següent comanda:

```bash
php artisan sync:mercadona
```

Aquesta comanda sincronitzarà les dades dels productes des de l'API de Mercadona i les emmagatzemarà a la base de dades.

## Automatització de tasques

S'ha automatitzat una tasca que executarà l'actualització dels productes de Mercadona un cop al dia. Pots configurar aquesta tasca al teu servidor executant la següent comanda:

```bash
php artisan schedule:work
```

A més, aquesta tasca està configurada per enviar una notificació per Telegram si hi ha una pujada de preu en algun producte.

## Configuració de Telegram

Per rebre notificacions sobre pujades de preus a través de Telegram, necessites configurar el teu bot de Telegram i obtenir un token de bot i un ID de xat. Llavors, afegeix aquestes credencials a l'arxiu `.env` del teu projecte.

## Dependències

Mercadona Spy utilitza la llibreria oficial del SDK de Telegram Bot per enviar notificacions. Pots instal·lar aquesta dependència utilitzant Composer:

```bash
composer require telegram-bot-sdk
```

## Contribució

Si vols contribuir a Mercadona Spy, segueix aquests passos:

1. Fes un fork del repositori.
2. Crea una branca per a la teva nova funcionalitat (`git checkout -b feature/nova-funcionalitat`).
3. Fes els teus canvis i fes commit d'ells (`git commit -am 'Afegir nova funcionalitat'`).
4. Fes un push de la teva branca (`git push origin feature/nova-funcionalitat`).
5. Obre una sol·licitud d'extracció a GitHub.

## Crèdits

Aquest projecte va ser creat per Miguel Martinez.

## Llicència

Aquest projecte està sota la Llicència [MIT](https://opensource.org/licenses/MIT).
