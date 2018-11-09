# fotoshare.co-album-downloader

Download complete albums from fotoshare.co (dslrBooth)

# Installation

```
git clone https://github.com/CodeBrauer/fotoshare.co-album-downloader.git
cd fotoshare.co-album-downloader
composer install
```

# Requirements

PHP 7.1.3 or newer

# Usage

Notice: The album must be Public. (You can set it temporarily Public for the download, and set it back to private after the download finished) 

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

| "Image URL"                                   | GIF/Thumbnail | "Fotoshare.co Path"                                                                | Width | Height | Type | 
|-----------------------------------------------|---------------|------------------------------------------------------------------------------------|-------|--------|------| 
| https://i.fotoshare.co/xx/20100101_120000.jpg | /i/xxxxxxx    | https://t.fotoshare.co/v1/height/240/https://i.fotoshare.co/xx/20100101_120000.jpg | 1200  | 1800   | jpg  | 
| https://i.fotoshare.co/xx/20100101_120000.mp4 | /i/xxxxxxx    | https://i.fotoshare.co/xx/20100101_120000.gif                                      | 0     | 0      | mp4  | 
