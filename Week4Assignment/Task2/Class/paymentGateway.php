<?php
    abstract class PaymentGateway{
        abstract public function charge($transaction);
    }
?>