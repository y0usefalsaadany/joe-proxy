<?php

namespace Yousefpackage\JoeProxy\Models;

use SY\DataObject\Contracts\DataObject;
use SY\DataObject\Support\DataObjectTrait;
use SY\DataObject\Support\ObjectReadAccess;

class Log implements DataObject
{
    use DataObjectTrait;
    use ObjectReadAccess;

    public function __construct(array $properties = [])
    {
        $this->_properties = [
            'id'        => null,
            'ip'        => null,
            'os'        => '',
            'action'    => '',
            'city'      => '',
            'item_id'   => null,
            'page_name' => ''
        ];

        $this->hydrate($properties);
    }
}