<?php
/**
 * Mage2
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to ind.purvesh@gmail.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://mage2.website for more information.
 *
 * @author    Purvesh <ind.purvesh@gmail.com>
 * @copyright 2016-2017 Mage2
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License v3.0
 */
namespace Mage2\Category;

use Illuminate\Support\Facades\View;
use Mage2\Framework\Configuration\Facades\AdminConfiguration;
use Mage2\Framework\AdminMenu\Facades\AdminMenu;
use Mage2\Framework\Support\BaseModule;
use Mage2\Framework\Auth\Facades\Permission;
use Mage2\Framework\Module\Facades\Module as ModuleFacade;
use Illuminate\Support\Facades\Event;
use Mage2\Category\Listeners\ProductCategorySavingListener;
use Mage2\Product\Events\ProductSavedEvent;
use Illuminate\Support\Collection;

class Module extends BaseModule
{

    /**
     *
     * Module Name Variable
     * @var string $name
     *
     */
    protected $name = NULL;

    /**
     *
     * Module identifier  Variable
     * @var $identifier
     *
     */
    protected $identifier = NULL;
    /**
     *
     * Module Description Variable
     * @var string $description
     *
     */
    protected $description = NULL;

    /**
     *
     * Module Enable Variable
     * @var bool $enable
     *
     */
    protected $enable = NULL;


    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    //protected $defer = true;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (true === $this->getEnable()) {
            //$this->registerModule();
            $this->registerAdminMenu();
            $this->registerAdminConfiguration();
            $this->registerViewPath();
            $this->registerTranslationPath();
            $this->registerDatabasePath();
            $this->registerModuleListener();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModuleYamlFile(__DIR__ . DIRECTORY_SEPARATOR . 'module.yaml');
        if (true === $this->getEnable()) {
            $this->mapWebRoutes();
            $this->registerPermissions();
        }

    }

    public function registerDatabasePath()
    {
        $this->loadMigrationsFrom(__DIR__ ."/../database/migrations");
    }

    protected function registerTranslationPath()
    {
        $this->loadTranslationsFrom(__DIR__ . "/resources/lang", "mage2-category");
    }


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    protected function registerViewPath()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mage2-category');
    }

    public function registerModuleListener()
    {

        Event::listen(ProductSavedEvent::class, ProductCategorySavingListener::class);
    }

    /**
     * Register Admin Menu for Mage2 Catalog Modules
     *
     */
    public function registerAdminMenu()
    {

        $adminUserMenu = ['catalog' => [
            'submenu' => [
                'category' => [
                    'label' => 'Category',
                    'route' => 'admin.category.index',
                ]
            ]
        ]];
        AdminMenu::registerMenu('mage2-catalog', $adminUserMenu);
    }

    public function registerAdminConfiguration()
    {
        $adminConfigurations[] = [
            'title' => 'Catalog Configuration',
            'description' => 'Some Description for Catalog Modules',
            'edit_action' => 'admin.configuration.catalog',
            'sort_order' => 1
        ];

        foreach ($adminConfigurations as $adminConfiguration) {
            //AdminConfiguration::registerConfiguration($adminConfiguration);
        }
    }

    /**
     *  Register Permission for the roles
     *
     * @return void
     */
    protected function registerPermissions()
    {
        /** State Permission Group */
        $permissionGroup = Permission::get('category');

        $permissionGroup->put('title', 'Category Permissions');

        $permissions = Collection::make([
            ['title' => 'Category List', 'routes' => 'admin.category.index'],
            ['title' => 'Category Create', 'routes' => "admin.category.create,admin.category.store"],
            ['title' => 'Category Edit', 'routes' => "admin.category.edit,admin.category.update"],
            ['title' => 'Category Destroy', 'routes' => "admin.category.destroy"],
        ]);

        $permissionGroup->put('routes', $permissions);

        Permission::set('category',$permissionGroup);
    }

}
