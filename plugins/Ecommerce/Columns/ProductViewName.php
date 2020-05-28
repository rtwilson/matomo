<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\Ecommerce\Columns;

use Piwik\Columns\Discriminator;
use Piwik\Columns\Join\ActionNameJoin;
use Piwik\Common;
use Piwik\Plugin\Dimension\ActionDimension;
use Piwik\Tracker\Action;
use Piwik\Tracker\Request;

class ProductViewName extends ActionDimension
{
    protected $type = self::TYPE_TEXT;
    protected $nameSingular = 'Goals_ProductName';
    protected $namePlural = 'Goals_ProductNames';
    protected $columnName = 'idaction_product_name';
    protected $segmentName = 'productViewName';
    protected $columnType = 'INT(10) UNSIGNED NULL';
    protected $category = 'Goals_Ecommerce';
    protected $sqlFilter = '\\Piwik\\Tracker\\TableLogAction::getIdActionFromSegment';

    public function getDbColumnJoin()
    {
        return new ActionNameJoin();
    }

    public function getDbDiscriminator()
    {
        return new Discriminator('log_action', 'type', Action::TYPE_ECOMMERCE_ITEM_NAME);
    }

    public function onLookupAction(Request $request, Action $action)
    {
        $sku = Common::unsanitizeInputValue($request->getParam('_pkn'));
        if ($request->hasParam('_pkn')) {
            return $sku;
        }

        return parent::onLookupAction($request, $action);
    }

    public function getActionId()
    {
        return Action::TYPE_ECOMMERCE_ITEM_NAME;
    }
}