<?php
declare(strict_types=1);
/**
 * @category Mdbhojwani
 * @package Mdbhojwani_CustomerImport
 * @author Manish Bhojwani <manishbhojwani3@gmail.com>
 * @github https://github.com/mdbhojwani
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Mdbhojwani\CustomerImport\Model\Import;
 
use Magento\CustomerImportExport\Model\Import\Customer;

/**
 * Class CustomerImport
 *
 * @package Mdbhojwani\CustomerImport\Model\Import\CustomerImport
 */
class CustomerImport extends Customer
{
    /**
     * import Customer Data
     * @return mixed
     */
    public function importCustomerData(array $rowData)
    {
        $this->prepareCustomerData($rowData);
        $entitiesToCreate = [];
        $entitiesToUpdate = [];
        $entitiesToDelete = [];
        $attributesToSave = [];
        
        $processedData = $this->_prepareDataForUpdate($rowData);
        $entitiesToCreate = array_merge($entitiesToCreate, $processedData[self::ENTITIES_TO_CREATE_KEY]);
        $entitiesToUpdate = array_merge($entitiesToUpdate, $processedData[self::ENTITIES_TO_UPDATE_KEY]);
        foreach ($processedData[self::ATTRIBUTES_TO_SAVE_KEY] as $tableName => $customerAttributes) {
            if (!isset($attributesToSave[$tableName])) {
                $attributesToSave[$tableName] = [];
            }
            $attributesToSave[$tableName] = array_diff_key(
                $attributesToSave[$tableName],
                $customerAttributes
            ) + $customerAttributes;
        }
        
        $this->updateItemsCounterStats($entitiesToCreate, $entitiesToUpdate, $entitiesToDelete);
        
        /**
        * Save prepared data
        */
        if ($entitiesToCreate || $entitiesToUpdate) {
            $this->_saveCustomerEntities($entitiesToCreate, $entitiesToUpdate);
        }
        if ($attributesToSave) {
            $this->_saveCustomerAttributes($attributesToSave);
        }
        
        return $entitiesToCreate[0]['entity_id'] ?? $entitiesToUpdate[0]['entity_id'] ?? null;
    }
}