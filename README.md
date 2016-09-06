# Bulhi\MonologDbBundle

Bundle provides custom Monolog handler, which saves the message to the database. Log entry has attached information about currently authenticated user via association to User entity.

Requires:

Monolog (included in Symfony out of the box) & FOS User Bundle.

## required settings:

Activate bundle in AppKernel::registerBundles() method
    
    ...
    new Bulhi\MonologDbBundle\BulhiMonologDbBundle(),
    ...

Define custom monolog channel in config.yml file. Name of the channel ('db_log' here) can be set to whatever you like. Also define the name of user entity in your app.

    monolog:
        channels: ['db_log']

        handlers:
            db_log_handler:
                type: service
                id: bulhi_monolog_db.log_handler
                channels: [db_log]

    bulhi_monolog_db:
        user_class: 'AppBundle\Entity\User'

Import bundle routes in routing.yml
    
    bulhi_monolog_db:
        resource: "@BulhiMonologDbBundle/Resources/config/routing.yml"
        prefix:   /log

## database

If your project uses Doctrine migrations(doctrine/doctrine-migrations-bundle), you can simply run migration diff, because LogEntry exists as a standard entity.

Another option is to use the console command
    
    php bin/console doctrine:schema:update --force

Or just create the table manually, e.g. for MySQL:

    CREATE TABLE `log_entry` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) DEFAULT NULL,
        `level` smallint(5) UNSIGNED NOT NULL,
        `message` longtext COLLATE utf8_unicode_ci NOT NULL,
        `created_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        KEY `IDX_B5F762DA76ED395` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

    ALTER TABLE `log_entry` ADD CONSTRAINT `FK_B5F762DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

(change names of 'users' table and the FK constraint accordingly, if needed)

## usage

Obtain Monolog service corresponding to the configured channel from the container and call one of it's methods (info(), warning(), error(), etc.).

E.g. in the controller:

    $logger = $this->get('monolog.logger.db_log');
    $logger->info('Just logged some valuable info');