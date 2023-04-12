# Migration drupal
Étape pour migrer les sites drupal<br>

# Désactiver le cache du site
Les outils drupal on un cache, pour pouvoir exporter une bdd minimal il est conseiller de supprimer le cache et le désactiver dans le backoffice Developpement/Performence <br>

# Exporter la BDD
Exporter la bdd existante <br>

# Exporter le core de drupal
En fonction de la version de drupal exporter le coeur du drupal. Les fichier a exporter sont les suivants :<br>
<ul>
    <li>📂.git</li>
    <li>📂composer</li>
    <li>📂composer-run.sh</li>
    <li>📂core</li>
    <li>📂iframe</li>
    <li>📂librairie</li>
    <li>📂modules</li>
    <li>📂profiles</li>
    <li>📂themes</li>
    <li>📂vendor</li>
    <li>🗄️.csslintrc</li>
    <li>🗄️.editorconfig</li>
    <li>🗄️.eslintignore</li>
    <li>🗄️.eslintrc.json</li>
    <li>🗄️.gitattributes</li>
    <li>🗄️.ht.router.php</li>
    <li>🗄️.htaccess</li>
    <li>🗄️autoload.php</li>
    <li>🗄️composer.acreat.json</li>
    <li>🗄️composer.ckeditor-plugin.json</li>
    <li>🗄️composer.json</li>
    <li>🗄️composer.lock</li>
    <li>🗄️example.gitignore</li>
    <li>🗄️index.php</li>
    <li>🗄️robot.txt</li>
    <li>🗄️update.php</li>
    <li>🗄️web.config</li>
</ul>
Il ne faut pas exporter le dossier /sites celui ci sera créer manuellement.<br>

# Exporter le site drupal
La racine du site se trouve dans le dossier /sites/{nom_du_site} <br>
Si le drupal est en multisite le nom de domaine doit être le meme que le nom du dossier<br>

# Importer drupal
1. Importer le core a la racine 
2. Créer le dossier /sites a la racine
3. Importer le dossier du site dans /sites/{nom_du_site}
4. Créer le fichier /sites/sites.php

sites.php
```php
<?php

// phpcs:ignoreFile

/**
 * @file
 * Configuration file for multi-site support and directory aliasing feature.
 *
 * This file is required for multi-site support and also allows you to define a
 * set of aliases that map hostnames, ports, and pathnames to configuration
 * directories in the sites directory. These aliases are loaded prior to
 * scanning for directories, and they are exempt from the normal discovery
 * rules. See default.settings.php to view how Drupal discovers the
 * configuration directory when no alias is found.
 *
 * Aliases are useful on development servers, where the domain name may not be
 * the same as the domain of the live server. Since Drupal stores file paths in
 * the database (files, system table, etc.) this will ensure the paths are
 * correct when the site is deployed to a live server.
 *
 * To activate this feature, copy and rename it such that its path plus
 * filename is 'sites/sites.php'.
 *
 * Aliases are defined in an associative array named $sites. The array is
 * written in the format: '<port>.<domain>.<path>' => 'directory'. As an
 * example, to map https://www.drupal.org:8080/mysite/test to the configuration
 * directory sites/example.com, the array should be defined as:
 * @code
 * $sites = [
 *   '8080.www.drupal.org.mysite.test' => 'example.com',
 * ];
 * @endcode
 * The URL, https://www.drupal.org:8080/mysite/test/, could be a symbolic link
 * or an Apache Alias directive that points to the Drupal root containing
 * index.php. An alias could also be created for a subdomain. See the
 * @link https://www.drupal.org/documentation/install online Drupal installation guide @endlink
 * for more information on setting up domains, subdomains, and subdirectories.
 *
 * The following examples look for a site configuration in sites/example.com:
 * @code
 * URL: http://dev.drupal.org
 * $sites['dev.drupal.org'] = 'example.com';
 *
 * URL: http://localhost/example
 * $sites['localhost.example'] = 'example.com';
 *
 * URL: http://localhost:8080/example
 * $sites['8080.localhost.example'] = 'example.com';
 *
 * URL: https://www.drupal.org:8080/mysite/test/
 * $sites['8080.www.drupal.org.mysite.test'] = 'example.com';
 * @endcode
 *
 * @see default.settings.php
 * @see \Drupal\Core\DrupalKernel::getSitePath()
 * @see https://www.drupal.org/documentation/install/multi-site
 */

 $site['example.fr']    = 'example.fr';
 $site['example1.fr']   = 'example1.fr';
 $site['example2.fr']   = 'example2.fr';

```
5. Importer la bdd 
6. Configurer la bdd dans le fichier /sites/{nom_du_site}/settings.php en modifiant les accès a la bdd

settings.php
```php
<?php

$databases['default']['default'] = [
   'database' => '',
   'username' => '',
   'password' => '',
   'host' => '',
   'port' => '',
   'driver' => '',
   'prefix' => '',
   'collation' => '',
];
```

# Arboresence final

<ul>
    <li>📂.git</li>
    <li>📂composer</li>
    <li>📂composer-run.sh</li>
    <li>📂core</li>
    <li>📂iframe</li>
    <li>📂librairie</li>
    <li>📂modules</li>
    <li>📂profiles</li>
    <li>📂themes</li>
    <li>📂vendor</li>
    <li>📂sites
        <ul>
            <li>📂{nom_du_site}</li>
            <li>🗄️sites.php</li>
        </ul>
    </li>
    <li>🗄️.csslintrc</li>
    <li>🗄️.editorconfig</li>
    <li>🗄️.eslintignore</li>
    <li>🗄️.eslintrc.json</li>
    <li>🗄️.gitattributes</li>
    <li>🗄️.ht.router.php</li>
    <li>🗄️.htaccess</li>
    <li>🗄️autoload.php</li>
    <li>🗄️composer.acreat.json</li>
    <li>🗄️composer.ckeditor-plugin.json</li>
    <li>🗄️composer.json</li>
    <li>🗄️composer.lock</li>
    <li>🗄️example.gitignore</li>
    <li>🗄️index.php</li>
    <li>🗄️robot.txt</li>
    <li>🗄️update.php</li>
    <li>🗄️web.config</li>
</ul>
