<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfMemberContact implements IteratorAggregate
{

    /**
     * @property MemberContact[] $MemberContact
     */
    protected $MemberContact = [
        
    ];

    /**
     * @param MemberContact[] $MemberContact
     * @return $this
     */
    public function setMemberContact($MemberContact)
    {
        $this->MemberContact = $MemberContact;
        return $this;
    }

    /**
     * @return MemberContact[]
     */
    public function getIterator()
    {
        return new ArrayIterator( $this->MemberContact );
    }

    /**
     * @return MemberContact[]
     */
    public function getMemberContact()
    {
        return $this->MemberContact;
    }


}

