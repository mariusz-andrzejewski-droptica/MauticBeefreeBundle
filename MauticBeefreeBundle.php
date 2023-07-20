<?php

/**
 * @package     Mautic
 * @copyright   2020 Enguerr. All rights reserved
 * @author      Enguerr
 * @link        https://www.enguer.com
 * @license     GNU/AGPLv3 http://www.gnu.org/licenses/agpl.html
 */

namespace MauticPlugin\MauticBeefreeBundle;

use Doctrine\ORM\Tools\SchemaTool;
use Mautic\CoreBundle\Factory\MauticFactory;
use Mautic\PluginBundle\Bundle\PluginBundleBase;
use Mautic\PluginBundle\Entity\Plugin;

class MauticBeefreeBundle extends PluginBundleBase
{
  public static function onPluginInstall(Plugin $plugin, MauticFactory $factory, $metadata = null, $installedSchema = null)
  {
    if (null !== $metadata) {
      static::installPluginSchema($metadata, $factory, $installedSchema);
    }
  }

  public static function installPluginSchema(array $metadata, MauticFactory $factory, $installedSchema = null)
  {
    if (null !== $installedSchema) {
      // Schema exists so bail
      return;
    }

    $db             = $factory->getDatabase();
    $schemaTool     = new SchemaTool($factory->getEntityManager());
    $installQueries = $schemaTool->getCreateSchemaSql($metadata);

    foreach ($installQueries as $q) {
      $db->query($q);
    }
  }
}
