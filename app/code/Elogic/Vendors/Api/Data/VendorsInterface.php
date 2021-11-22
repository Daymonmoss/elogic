<?php
declare(strict_types=1);

namespace Elogic\Vendors\Api\Data;

use Elogic\Vendors\Model\VendorsModel;

interface VendorsInterface
{
    const TABLE_NAME = 'elogic_vendors';
    const FIELD_NAME_ID = 'id';
    const FIELD_NAME_LOGO = 'logo';
    const FIELD_NAME_NAME = 'name';
    const FIELD_NAME_DESCRIPTION = 'description';
    const FIELD_NAME_DATE_ADDED = 'date_added';

    /**
     * @return string
     */
    public function getId() :?string;

    /**
     * @return string|null
     */
    public function getLogo() :?string ;

    /**
     * @param string|null $logo
     * @return VendorsInterface|VendorsModel
     */
    public function setLogo(?string $logo) :VendorsInterface;

    /**
     * @return string|null
     */
    public function getName() :?string ;

    /**
     * @param string|null $name
     * @return VendorsInterface|VendorsModel
     */
    public function setName(?string $name) :VendorsInterface;

    /**
     * @return string|null
     */
    public function getDescription() :?string;

    /**
     * @param string|null $description
     * @return VendorsInterface|VendorsModel
     */
    public function setDescription(?string $description) :VendorsInterface;


    /**
     * @return string
     */
    public function getDateAdded() :string;

}
