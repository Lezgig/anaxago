Etape 1 : symfony new anaxago --version="6.4.*" --webapp <br />
Etape 2 : php bin/console doctrine:database:create 
Etape 3 : 
<ul>
  <li>
    php bin/console make:entity Task
  </li>
  <li>
    php bin/console make:entity User
  </li
  <li>
    php bin/console make:migrations
  </li>
  <li>
    php bin/console doctrine:migrations:migrate
  </li>
</ul>
<br />
Etape 6 : 
<ul>
  <li>
    composer require --dev symfony/test-pack
  </li>
  <li>
    php bin/phpunit
  </li>
</ul>
