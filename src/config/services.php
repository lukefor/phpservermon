<?php

/**
 * PHP Server Monitor - service container configuration.
 *
 * Replaces services.xml: the XML configuration format is deprecated since
 * symfony/dependency-injection 7.4 and removed in 8.0.
 *
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @link        http://www.phpservermonitor.org/
 **/

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    // The DB constants come from config.php, which doesn't exist yet on a fresh install.
    // Fall back to null (as PHP 7 did) so bootstrap can redirect to install.php.
    $const = static function (string $name) {
        return \defined($name) ? \constant($name) : null;
    };

    $parameters = $container->parameters();
    $parameters->set('config.theme', $const('PSM_THEME'));
    $parameters->set('modules', array(
        'module.config',
        'module.error',
        'module.server',
        'module.user',
        'module.install',
    ));
    $parameters->set('path.src', $const('PSM_PATH_SRC'));
    $parameters->set('path.templates', '%path.src%templates');
    $parameters->set('db.host', $const('PSM_DB_HOST'));
    $parameters->set('db.port', $const('PSM_DB_PORT'));
    $parameters->set('db.user', $const('PSM_DB_USER'));
    $parameters->set('db.pass', $const('PSM_DB_PASS'));
    $parameters->set('db.name', $const('PSM_DB_NAME'));

    // Symfony 4+ makes services private by default; the app fetches them via $container->get()
    $services = $container->services()->defaults()->public();

    // MODULES
    $services->set('module.config', psm\Module\Config\ConfigModule::class);
    $services->set('module.error', psm\Module\Error\ErrorModule::class);
    $services->set('module.server', psm\Module\Server\ServerModule::class);
    $services->set('module.user', psm\Module\User\UserModule::class);
    $services->set('module.install', psm\Module\Install\InstallModule::class);

    // SERVICES
    $services->set('db', psm\Service\Database::class)
        ->args(array(
            param('db.host'),
            param('db.user'),
            param('db.pass'),
            param('db.name'),
            param('db.port'),
        ));
    $services->set('event', Symfony\Component\EventDispatcher\EventDispatcher::class);
    $services->set('user', psm\Service\User::class)
        ->args(array(service('db')));
    $services->set('twig.loader', Twig\Loader\FilesystemLoader::class)
        ->args(array('%path.templates%/%config.theme%'));
    $services->set('twig', Twig\Environment::class)
        ->args(array(service('twig.loader')));

    // UTIL
    $services->set('util.user.validator', psm\Util\User\UserValidator::class)
        ->args(array(service('user')));
    $services->set('util.server.updatemanager', psm\Util\Server\UpdateManager::class)
        ->args(array(service('service_container')));
};
