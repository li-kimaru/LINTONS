class UpgradeSchema implements UpgradeSchemaInterface
    {
      protected $triggerFactory;

        public function __construct(
            \Magento\Framework\DB\Ddl\TriggerFactory $triggerFactory
        )
        {
            $this->triggerFactory = $triggerFactory;
        }

        public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
        {
            $installer = $setup;

            $installer->startSetup();
            $trigger = $this->triggerFactory->create()
                ->setName('after_quote_item_option_insert')
                ->setTime(\Magento\Framework\DB\Ddl\Trigger::TIME_BEFORE)
                ->setEvent('INSERT')
                ->setTable($setup->getTable('quote_item_option'));

            $trigger->addStatement("IF NEW.code =  'info_buyRequest' THEN SET NEW.code = CONCAT(  'info_buyRequest_', NOW( ) ) ; END IF ;");

              $setup->getConnection()->dropTrigger($trigger->getName());
              $setup->getConnection()->createTrigger($trigger);

          $installer->endSetup();
        } 
    }