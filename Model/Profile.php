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

use Mdbhojwani\CustomerImport\Api\CustomerImportInterface;
use Mdbhojwani\CustomerImport\Model\Profile\ImportCSV;
use Mdbhojwani\CustomerImport\Model\Profile\ImportJSON;

/**
 * Class Profile
 *
 * @package Mdbhojwani\CustomerImport\Model\Profile
 */
class Profile
{
    /**
     * Profile constructor.
     * @param ImportCSV $importCSV
     * @param ImportJSON $importJSON
     */
    public function __construct(
        protected ImportCSV $importCSV,
        protected ImportJSON $importJSON
    ) {
        $this->importCSV = $importCSV;
        $this->importJSON = $importJSON;
    }

    /**
     * Create class instance with specified parameters
     * @throws \Exception
     */
    public function create(string $profileName): CustomerImportInterface
    {
        if ($profileName === CustomerImportInterface::PROFILE_TYPE_CSV) {
            $object = $this->importCSV;
        } else if ($profileName === CustomerImportInterface::PROFILE_TYPE_JSON) {
            $object = $this->importJSON;
        } else {
            throw new \Exception("Unsupported Profile type specified");
        }
        
        return $object;
    }
}
