<?php
declare(strict_types=1);
/**
 * @category Mdbhojwani
 * @package Mdbhojwani_CustomerImport
 * @author Manish Bhojwani <manishbhojwani3@gmail.com>
 * @github https://github.com/mdbhojwani
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Mdbhojwani\CustomerImport\Model\Profile;

use Mdbhojwani\CustomerImport\Api\CustomerImportInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Serialize\SerializerInterface;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class ImportJSON
 *
 * @package Mdbhojwani\CustomerImport\Model\Profile\ImportJSON
 */
class ImportJSON implements CustomerImportInterface
{
    /**
     * ImportJSON constructor.
     * @param File $file
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private File $file,
        private SerializerInterface $serializer
    ) {
        $this->file = $file;
        $this->serializer = $serializer;
    }

    /**
     * Fetch data
     * @param InputInterface $input
     * @return array
     */
    public function fetchImportData(InputInterface $input): array
    {
        $file = $input->getArgument(CustomerImportInterface::SOURCE);
        return $this->readImportFile($file);
    }

    /**
     * Read File
     * @throws LocalizedException
     * @throws Exception
     * @throws FileSystemException
     */
    public function readImportFile(string $file): array
    {
        try {
            if (!$this->file->isExists($file)) {
                throw new LocalizedException(__('Invalid file path or File does not exist.'));
            }
            $data = $this->file->fileGetContents($file);
        } catch (FileSystemException $e) {
            throw new FileSystemException(__('Exception: ' . $e->getMessage()));
        }

        return $this->prepareImportData($data);
    }

    /**
     * Prepare Data
     * @param array $data
     * @return array
     */
    public function prepareImportData($data): array
    {
        return $this->serializer->unserialize($data);
    }
}
