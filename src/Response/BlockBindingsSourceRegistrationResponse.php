<?php

namespace WonderWp\Component\BlockBindingsSource\Response;

use WonderWp\Component\Response\AbstractResponse;

class BlockBindingsSourceRegistrationResponse extends AbstractResponse implements BlockBindingsSourceRegistrationResponseInterface
{
    protected ?\WP_Block_Bindings_Source $wpRegistrationResult = null;

    public function getWpRegistrationResult(): ?\WP_Block_Bindings_Source
    {
        return $this->wpRegistrationResult;
    }

    public function setWpRegistrationResult(?\WP_Block_Bindings_Source $wpRegistrationResult): BlockBindingsSourceRegistrationResponse
    {
        $this->wpRegistrationResult = $wpRegistrationResult;

        return $this;
    }
}
