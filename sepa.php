<?php
/**
 * SEPA Gateway
 *
 * Allows instructions to be displayed to the client informing them on how to pay via bank transfer SEPA.
 *
 * @package blesta
 * @subpackage blesta.components.gateways.sepa
 * @copyright Copyright (c) 2025, MLGT
 * @link https://mlgt.info/en MLGT
 */

class sepa extends NonmerchantGateway
{
    private $meta;

    public function __construct()
    {
        $this->loadConfig(dirname(__FILE__) . DS . 'config.json');
        Loader::loadComponents($this, ['Input']);
        Language::loadLang('sepa', null, dirname(__FILE__) . DS . 'language' . DS);
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function getSettings(array $meta = null)
    {
        $this->view = $this->makeView('settings', 'default', str_replace(ROOTWEBDIR, '', dirname(__FILE__) . DS));
        Loader::loadHelpers($this, ['Form', 'Html']);
        $this->view->set('meta', $meta);
        return $this->view->fetch();
    }

    public function editSettings(array $meta)
    {
        $rules = [
          'instructions' => [
            ],             
          'instructions2' => [
            ], 
          'IBAN' => [
                    'valid' => [
                    'rule' => 'isEmpty',
                    'negate' => true,
                    'message' => Language::_('sepa.!error.instructions.valid', true)
                ]
            ]
        ];

        $this->Input->setRules($rules);
        $this->Input->validates($meta);
        return $meta;
    }

    public function encryptableFields()
    {
        return [];
    }

    public function setMeta(array $meta = null)
    {
        $this->meta = $meta;
    }

    public function buildProcess(array $contact_info, $amount, array $invoice_amounts = null, array $options = null)
    {
        $this->view = $this->makeView('process', 'default', str_replace(ROOTWEBDIR, '', dirname(__FILE__) . DS));
        Loader::loadHelpers($this, ['Html', 'TextParser']);
        $this->view->set('meta', $this->meta);
        return $this->view->fetch();
    }

    public function validate(array $get, array $post)
    {
        $this->getCommonError('unsupported');
        return null;
    }

    public function success(array $get, array $post)
    {
        $this->getCommonError('unsupported');
        return null;
    }
}
