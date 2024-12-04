<?php
declare(strict_types=1);
/**
 * @category Mdbhojwani
 * @package Mdbhojwani_CustomerImport
 * @author Manish Bhojwani <manishbhojwani3@gmail.com>
 * @github https://github.com/mdbhojwani
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Mdbhojwani\CustomerImport\Console\Command;

use Magento\Framework\Exception\InputException;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Mdbhojwani\CustomerImport\Api\CustomerImportInterface;
use Mdbhojwani\CustomerImport\Model\Profile;
use Mdbhojwani\CustomerImport\Model\Customer;

/**
 * Class ImportCustomers
 *
 * @package Mdbhojwani\CustomerImport\Console\Command\ImportCustomers
 */
class ImportCustomers extends Command
{
    /**
     * Constants.
     */
    const SUCCESS = 0;
    const FAILURE = 1;

    /**
     * Object.
     */
    private $importer;

    /**
     * CustomerImport constructor.
     * @param Profile $profile
     * @param Customer $customer
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        private Profile $profile,
        private Customer $customer,
        private StoreManagerInterface $storeManager
    ) {
        parent::__construct();
        
        $this->profile = $profile;
        $this->customer = $customer;
        $this->storeManager = $storeManager;
    }

    /**
     * Configure
     * @return void
     */
    protected function configure(): void
    {
        $this->setName("customer:import");
        $this->setDescription("Customer Import via CLI");
        $this->setDefinition([
            new InputArgument(CustomerImportInterface::PROFILE_NAME, InputArgument::REQUIRED, "Profile name ex: sample-csv/sample-json"),
            new InputArgument(CustomerImportInterface::SOURCE, InputArgument::REQUIRED, "File Path ex: sample.csv/sample.json")
        ]);
        parent::configure();
    }

    /**
     * Execute
     * @return int|void
     * */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $profileName = $input->getArgument(CustomerImportInterface::PROFILE_NAME);
        $filePath = $input->getArgument(CustomerImportInterface::SOURCE);
        $output->writeln(sprintf("Profile Name: %s", $profileName));
        $output->writeln(sprintf("Source: %s", $filePath));

        try {
            if ($importData = $this->getCustomerImportObject($profileName)->fetchImportData($input)) {
                $storeId = $this->storeManager->getStore()->getId();
                $websiteId = $this->storeManager->getStore($storeId)->getWebsiteId();
                
                foreach ($importData as $data) {
                    $this->customer->createCustomer((array)$data, (int)$websiteId, (int)$storeId);
                }

                $output->writeln(sprintf("Total %s Customer(s) Imported.", count($importData)));

                return self::SUCCESS;
            }

            return self::FAILURE;
   
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $output->writeln("<error>$message</error>", OutputInterface::OUTPUT_NORMAL);
            return self::FAILURE;
        }
    }

    /**
     * Customer Import Object
     * @param $profileName
     * @return CustomerImportInterface
     */
    protected function getCustomerImportObject($profileName): CustomerImportInterface
    {
        if (!($this->importer instanceof CustomerImportInterface)) {
            $this->importer = $this->profile->create($profileName);
        }
        return $this->importer;
    }
}
