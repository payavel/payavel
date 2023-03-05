<?php

namespace Payavel\Traits;

use Exception;
use RuntimeException;

trait PaymentResponses
{
    use ThrowsRuntimeException;

    /**
     * Maps details from the getWallet() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function getWalletResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the getPaymentMethod() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function getPaymentMethodResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the tokenizePaymentMethod() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function tokenizePaymentMethodResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the updatePaymentMethod() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function updatePaymentMethodResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the deletePaymentMethod() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function deletePaymentMethodResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the authorize() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function authorizeResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the capture() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function captureResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the void() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function voidResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the refund() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function refundResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Attempts to call the generic response method, else throws RuntimeException.
     *
     * @param string $function
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    private function genericResponse($function)
    {
        try {
            return $this->response();
        } catch (Exception $e) {
            if ($e instanceof RuntimeException) {
                $this->throwRuntimeException($function);
            }

            throw($e);
        }
    }

    /**
     * The generic payment request response.
     *
     * @throws \RuntimeException
     */
    public function response()
    {
        return $this->throwRuntimeException(__FUNCTION__);
    }
}
