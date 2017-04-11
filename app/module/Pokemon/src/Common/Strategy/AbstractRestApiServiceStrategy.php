<?php

/**
 * Class AbstractRestApiServiceStrategy
 *
 * @package             Pokemon\Common\Strategy
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Strategy;

class AbstractRestApiServiceStrategy
{
    /** @var string FLAG_SUCCESS */
    const FLAG_SUCCESS = 200;
    /** @var string FLAG_ERROR */
    const FLAG_ERROR = 500;
    /** @var array $errors */
    protected $errors = [];
    /** @var array $warnings */
    protected $warnings = [];

    /**
     * Format data before return
     *
     * @param array $response
     *
     * @return array
     */
    protected function __r(array $response = null) : array
    {
        /** @var array $return */
        $return = [];
        if (sizeof($this->errors) >= 1) {
            $return['code'] = self::FLAG_ERROR;
            foreach ($this->errors as $error) {
                $return['errors'][] = $error;
            }
        } else {
            $return['code'] = self::FLAG_SUCCESS;
        }
        if (sizeof($this->warnings) >= 1) {
            foreach ($this->warnings as $warning) {
                $return['warnings'][] = $warning;
            }
        }
        if ($response) {
            $return['response'] = $response;
        }

        return $return;
    }

    /**
     * Add error
     *
     * @param string $message
     */
    protected function addError(string $message)
    {
        $this->errors[] = $message;
    }

    /**
     * Add warning
     *
     * @param string $message
     */
    protected function addWarning(string $message)
    {
        $this->warnings[] = $message;
    }
}