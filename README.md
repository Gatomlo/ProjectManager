ProjectManager
==============

![screenshot dashboard](https://github.com/Gatomlo/ProjectManager/blob/master/Screenshot_14.png)


Pour installer :

créer votre base de données vierge

$ git clone https://github.com/Gatomlo/ProjectManager.git

$ cd projectmanager

$ composer install

répondre aux questions posées

$ php bin/console doctrine:schema:update --force

$ php bin/console fos:user:create adminusername adminmail@example.com adminp@ssword

$ php bin/console fos:user:promote adminusername ROLE_ADMIN
