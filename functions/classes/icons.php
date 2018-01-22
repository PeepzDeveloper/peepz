<?php

    /**
     * Class Icon
     *
     * @property AjaxLink $Link   The Link for onClick event.
     * @property int      $Height The Height of the image. default to 11px from the stylesheets
     * @property string   $ToolTip
     * @property string   $FileName
     * @property string   $Style
     * @property string   $Attributes
     * @property string   $ToolTipStyle
     * @property array    $Classes Additional classes to apply
     */
    class Icon
    {
        const Peepz ='fa fa-map-marker';
        const Search = 'fa fa-search';
        const Marker = 'fa fa-map-marker';
        const Save = 'fa fa-floppy-o';
        const User = 'ti-user';
        const Wallet = 'ti-wallet';
        const Settings = 'ti-settings';
        const Logout = 'fa fa-power-off';
        const Home = 'ti-home';
        const Email = 'ti-email';
        const Checkbox = 'ti-check-box';
        const CreditCard = 'fa fa-credit-card';
        const Group = 'fa fa-group';
        const OwnTransport = 'fa fa-car';
        const Age = 'fa fa-map-marker';
        const Language = 'fa fa-language';
        const Gender = 'mdi mdi-human-male-female';
        const Gender1 = 'mdi mdi-gender-male-female';
        const EchnicBackground = 'mdi mdi-fingerprint';
        const Height = 'mdi mdi-format-align-center';
        const Weight = 'mdi mdi-weight-kilogram';
        const PantsSize = 'fa fa-map-marker';
        const ShirtSize = 'mdi mdi-tshirt-crew';
        const DressSize = 'fa fa-map-marker';
        const ShoeSize = 'fa fa-map-marker';
        const VisibleTatoos = 'fa fa-tint';
        const HairColour = 'mdi mdi-spray';
        const VisiblePiercings = 'mdi mdi-google-circles';

        private $Link = '';
        private $Height;
        private $ToolTip;
        private $FileName;
        private $Style = '';
        private $Attributes;
        private $ToolTipStyle;
        private $Classes = [];

        /**
         * Icon constructor.
         *
         * @param $Icon
         * @param $Link
         */
        public function __construct($Icon, $Link = "")
        {
            $this->FileName = $Icon;
            $this->Link = $Link;
        }

        /**
         * @param string $Icon The Icon to be displayed,  Needs to be one of the constants of this Class
         * @param string $Link
         * @param string $Style
         * @return string
         */
        public static function Output($Icon, $Link = "", $Style = "")
        {
            $IconObj = new self($Icon, $Link);
            $IconObj->Style = $Style;
            return (string)$IconObj;
        }

        public function __get($Name)
        {
            if (!property_exists($this, $Name))
            {
                RaiseDevel('Unknown property - ' . $Name);
            }
            return $this->{$Name};
        }

        public function __set($Name, $Value)
        {
            if (!property_exists($this, $Name))
            {
                RaiseDevel('Unknown property - ' . $Name);
            }
            return $this->{$Name} = $Value;
        }

        public function __toString()
        {
            $result = "";

            //$result .= "<img src=\"{$this->FileName}\" alt=''>";

            $result .= "<i class='".$this->FileName."' aria-hidden='true'></i>";

            return $result;
        }

        static function getConstants()
        {
            $oClass = new ReflectionClass(__CLASS__);
            return $oClass->getConstants();
        }
    }