<?php
declare(strict_types=1);
/**
 * @category Mdbhojwani
 * @package Mdbhojwani_CustomerImport
 * @author Manish Bhojwani <manishbhojwani3@gmail.com>
 * @github https://github.com/mdbhojwani
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Mdbhojwani\CustomerImport\Api;

use Symfony\Component\Console\Input\InputInterface;

/**
 * Interface CustomerImportInterface
 *
 * @package Mdbhojwani\CustomerImport\Api\CustomerImportInterface
 */
interface CustomerImportInterface
{
    /**
     * Constants.
     */
    public const PROFILE_NAME = "profile-name";
    public const SOURCE = "source";
    public const PROFILE_TYPE_CSV = "sample-csv";
    public const PROFILE_TYPE_JSON = "sample-json";

    /**
     * @param InputInterface $input
     * @return array
     */
    public function fetchImportData(InputInterface $input): array;

    /**
     * @param string $data
     * @return array
     */
    public function readImportFile(string $data): array;

    /**
     * @param mixed $data
     * @return array
     */
    public function prepareImportData($data): array;
}
