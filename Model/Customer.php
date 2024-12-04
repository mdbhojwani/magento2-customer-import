<?php
declare(strict_types=1);
/**
 * @category Mdbhojwani
 * @package Mdbhojwani_CustomerImport
 * @author Manish Bhojwani <manishbhojwani3@gmail.com>
 * @github https://github.com/mdbhojwani
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Mdbhojwani\CustomerImport\Model;
 
use Magento\Framework\Exception;
use Mdbhojwani\CustomerImport\Model\Import\CustomerImport;

/**
 * Class Customer
 *
 * @package Mdbhojwani\CustomerImport\Model\Customer
 */
class Customer
{   
    /**
     * Customer constructor.
     * @param CustomerImport $customerImport
     */
    public function __construct(
        private CustomerImport $customerImport
    ) {
        $this->customerImport = $customerImport;
    }

    /**
     * Create Customer
     * @param array $data
     * @param int $websiteId
     * @param int $storeId
     * @throws Exception
     */
    public function createCustomer(array $data, int $websiteId, int $storeId): void
    {
        try {
            $customerData = [
                'email'         => $data['emailaddress'],
                '_website'      => 'base',
                '_store'        => 'default',
                'confirmation'  => null,
                'dob'           => null,
                'firstname'     => $data['fname'],
                'gender'        => null,
                'lastname'      => $data['lname'],
                'middlename'    => null,
                'prefix'        => null,
                'store_id'      => $storeId,
                'website_id'    => $websiteId,
                'password'      => null,
                'disable_auto_group_change' => 0
            ];
            
            // import customer data
            $this->customerImport->importCustomerData($customerData);
        } catch (Exception $e) {
            throw new Exception(__('Exception: ' . $e->getMessage()));
        }
    }
}
