# fotoshare.co-album-downloader
Download complete albums from fotoshare.co

# Installation

```
git clone https://github.com/CodeBrauer/fotoshare.co-album-downloader.git
cd fotoshare.co-album-downloader
composer install
```

# Requirements

PHP 7.1.3 or newer

# Usage

**For smaller albums:**

Just call the index.php with a webserver or create one like `php -S localhost:3000` and use the provided UI

**For larger albums:**

Use CLI:
```sh
php index.php <album url>
```

Example: `php index.php https://fotoshare.co/u/123456789/event`

In both cases there will be created a directory which contains: 
- Album media files (jpg, gif, mp4 etc.)
- CSV file (images.csv) with the album contents, providing the fields:

| Image URL                                         | Fotoshare.co Path | Width | Height | Type |
|---------------------------------------------------|-------------------|-------|--------|------|
| https://i.fotoshare.co/xx/19700101_010000_001.jpg | /i/abcdefg        | 1800  | 1200   | jpg  |
