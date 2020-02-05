<?php

/**
 * CookieConsentBanner Module Main Php File
 *
 * PHP version 5.4
 *
 * @category Module
 * @package  CookieConsentBanner
 * @author   Maxime Morlet <Maxime.Morlet@outlook.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://Maxicom.pro
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * CookieConsentBanner Main Module Class
 *
 * @category Class
 * @package  CookieConsentBanner
 * @author   Maxime Morlet <Maxime.Morlet@outlook.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://Maxicom.pro
 */
class CookieConsentBanner extends Module
{
    /**
     * Constructor Method
     */
    public function __construct()
    {
        $this->name = 'cookieconsentbanner';
        $this->tab = 'front_office_features';
        $this->version = '0.0.1';
        $this->author = 'Maxime Morlet';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.5'
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Cookie Consent Banner');
        $this->description = $this->l('Configure and deploy your Cookie Consent Banner in seconds!');

        if (!Configuration::get($this->name)) {
            $this->warning = $this->l('No name provided');
        }
    }

    /**
     * DisplayForm Method
     *
     * @return Bool
     */
    public function displayForm()
    {
        $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper = new HelperForm();
        $fieldsForm[0]['form'] = [
          'legend' => [
              'title' => $this->l('Settings')
          ], 'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Free Text'),
                    'name' => 'ccb-text',
                    'size' => 20,
                    'required' => true
                ], [
                    'type' => 'text',
                    'label' => $this->l('Button text'),
                    'name' => 'ccb-buttontext',
                    'size' => 20,
                    'required' => true
                ]/*, [
                    'type' => 'text',
                    'label' => $this->l('Text Font'),
                    'name' => 'ccb-textfont',
                    'size' => 20,
                    'required' => true
                ]*/, [
                    'type' => 'text',
                    'label' => $this->l('Free Text Color'),
                    'name' => 'ccb-tc',
                    'size' => 20,
                    'required' => true
                ], [
                    'type' => 'text',
                    'label' => $this->l('Button Text Color'),
                    'name' => 'ccb-btc',
                    'size' => 20,
                    'required' => true
                ], [
                    'type' => 'text',
                    'label' => $this->l('Banner Background Color'),
                    'name' => 'ccb-bc',
                    'size' => 20,
                    'required' => true
                ], [
                    'type' => 'text',
                    'label' => $this->l('Button Background Color'),
                    'name' => 'ccb-bbc',
                    'size' => 20,
                    'required' => true
                ], [
                    'type' => 'text',
                    'label' => $this->l('Button Hover Background Color'),
                    'name' => 'ccb-bhbc',
                    'size' => 20,
                    'required' => true
                ]
          ], 'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
          ]
        ];

        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex
            = AdminController::$currentIndex . '&configure=' . $this->name;

        $helper->default_form_language = $defaultLang;
        $helper->allow_employee_form_lang = $defaultLang;

        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = [
            'save' => [
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex
                    .'&configure='.$this->name.'&save'.$this->name.
                    '&token='.Tools::getAdminTokenLite('AdminModules'),
            ],
            'back' => [
                'href' => AdminController::$currentIndex
                    .'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            ]
        ];

        $helper->fields_value['ccb-text'] = Configuration::get('ccb-text');
        $helper->fields_value['ccb-buttontext'] = Configuration::get('ccb-buttontext');
        $helper->fields_value['ccb-textfont'] = Configuration::get('ccb-textfont');
        $helper->fields_value['ccb-tc'] = Configuration::get('ccb-tc');
        $helper->fields_value['ccb-btc'] = Configuration::get('ccb-btc');
        $helper->fields_value['ccb-bc'] = Configuration::get('ccb-bc');
        $helper->fields_value['ccb-bbc'] = Configuration::get('ccb-bbc');
        $helper->fields_value['ccb-bhbc'] = Configuration::get('ccb-bhbc');

        return $helper->generateForm($fieldsForm);
    }

    /**
     * GetContent Method
     *
     * @return string
     */
    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit('submit' . $this->name)) {
            $ccbText = strval(Tools::getValue('ccb-text'));
            $ccbButtonText = strval(Tools::getValue('ccb-buttontext'));
            $ccbTextFont = strval(Tools::getValue('ccb-textfont'));
            $ccbTC = strval(Tools::getValue('ccb-tc'));
            $ccbBTC = strval(Tools::getValue('ccb-btc'));
            $ccbBC = strval(Tools::getValue('ccb-bc'));
            $ccbBBC = strval(Tools::getValue('ccb-bbc'));
            $ccbBHBC = strval(Tools::getValue('ccb-bhbc'));

            if (!$ccbText
                || !$ccbButtonText
                || !$ccbTextFont
                || !$ccbTC
                || !$ccbBTC
                || !$ccbBC
                || !$ccbBBC
                || !$ccbBHBC
                || empty($ccbText)
                || empty($ccbButtonText)
                || empty($ccbTextFont)
                || empty($ccbTC)
                || empty($ccbBTC)
                || empty($ccbBC)
                || empty($ccbBBC)
                || empty($ccbBHBC)
                || !Validate::isGenericName($ccbText)
                || !Validate::isGenericName($ccbButtonText)
                || !Validate::isGenericName($ccbTextFont)
                || !Validate::isGenericName($ccbTC)
                || !Validate::isGenericName($ccbBTC)
                || !Validate::isGenericName($ccbBC)
                || !Validate::isGenericName($ccbBBC)
                || !Validate::isGenericName($ccbBHBC)
            ) {
                $output .= $this->displayError('Invalid Configuration Value');
            } else {
                Configuration::updateValue('ccb-text', $ccbText);
                Configuration::updateValue('ccb-buttontext', $ccbButtonText);
                Configuration::updateValue('ccb-textfont', $ccbTextFont);
                Configuration::updateValue('ccb-tc', $ccbTC);
                Configuration::updateValue('ccb-btc', $ccbBTC);
                Configuration::updateValue('ccb-bc', $ccbBC);
                Configuration::updateValue('ccb-bbc', $ccbBBC);
                Configuration::updateValue('ccb-bhbc', $ccbBHBC);

                $output .= $this->displayConfirmation($this->l('Settings Updated!'));
            }
        }

        return ($output . $this->displayForm());
    }

    /**
     * HookDisplayFooter Method
     *
     * @param $params description
     */
    public function hookDisplayFooter($params)
    {
        $this->smarty->assign(
            [
                'ccbtext' => Configuration::get('ccb-text'),
                'ccbbuttontext' => Configuration::get('ccb-buttontext'),
                'ccbtextfont' => Configuration::get('ccb-textfont'),
                'ccbtc' => Configuration::get('ccb-tc'),
                'ccbbtc' => Configuration::get('ccb-btc'),
                'ccbbc' => Configuration::get('ccb-bc'),
                'ccbbbc' => Configuration::get('ccb-bbc'),
                'ccbbhbc' => Configuration::get('ccb-bhbc')
            ]
        );

        return ($this->display(__FILE__, 'cookieconsentbanner.tpl'));
    }

    /**
     * Uninstall Method
     *
     * @return bool
     */
    public function uninstall()
    {
        return (parent::uninstall() &&
            Configuration::deleteByName('ccb-text') &&
            Configuration::deleteByName('ccb-buttontext') &&
            Configuration::deleteByName('ccb-textfont') &&
            Configuration::deleteByName('ccb-tc') &&
            Configuration::deleteByName('ccb-btc') &&
            Configuration::deleteByName('ccb-bc') &&
            Configuration::deleteByName('ccb-bbc') &&
            Configuration::deleteByName('ccb-bhbc'));
    }

    /**
     * Install Method
     *
     * @return bool
     */
    public function install()
    {
        return (parent::install() &&
            $this->registerHook('displayFooter') &&
            Configuration::updateValue('ccb-text', `<b>Do you like cookies?</b>  We use cookies to ensure you get the best experience on our website.`) &&
            Configuration::updateValue('ccb-buttontext', 'I agree') &&
            Configuration::updateValue('ccb-textfont', 'rand') &&
            Configuration::updateValue('ccb-tc', 'white') &&
            Configuration::updateValue('ccb-btc', 'white') &&
            Configuration::updateValue('ccb-bc', '#212327') &&
            Configuration::updateValue('ccb-bbc', '#007bff') &&
            Configuration::updateValue('ccb-bhbc', '#0069d9'));
    }
}