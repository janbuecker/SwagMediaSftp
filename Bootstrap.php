<?php
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

require(__DIR__ . "/vendor/autoload.php");

use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;

class Shopware_Plugins_Frontend_SwagMediaSftp_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    /**
     * Returns the version of the plugin
     *
     * @return string
     */
    public function getVersion()
    {
        return "1.0.0";
    }

    /**
     * Returns a marketing friendly name of the plugin.
     *
     * @return string
     */
    public function getLabel()
    {
        return "Media Adapter: SFTP";
    }

    /**
     * Returns plugin info
     *
     * @return array
     */
    public function getInfo()
    {
        return array(
            'version' => $this->getVersion(),
            'label' => $this->getLabel(),
            'supplier' => 'shopware AG',
            'description' => 'SFTP-Erweiterung für die Media Adapter',
            'support' => 'Shopware Forum',
            'link' => 'http://www.shopware.com'
        );
    }

    /**
     * Template method which will be called when the plugin will be uninstalled.
     *
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }

    /**
     * Template method which will be called when the plugin will be installed.
     *
     * @return bool
     */
    public function install()
    {
        $this->subscribeEvent('Shopware_Collect_MediaAdapter_sftp', 'createSftpAdapter');

        return true;
    }

    /**
     * Creates adapter instance
     *
     * @param Enlight_Event_EventArgs $args
     * @return AdapterInterface
     */
    public function createSftpAdapter(Enlight_Event_EventArgs $args)
    {
        $defaultConfig = [
            'host' => '',
            'port' => 22,
            'username' => '',
            'password' => '',
            'privateKey' => '',
            'root' => '',
            'timeout' => 10
        ];

        $config = array_merge($defaultConfig, $args->get('config'));

        return new SftpAdapter([
            'host' => $config['host'],
            'port' => $config['port'],
            'username' => $config['username'],
            'password' => $config['password'],
            'privateKey' => $config['privateKey'],
            'root' => $config['root'],
            'timeout' => $config['timeout']
        ]);
    }
}
