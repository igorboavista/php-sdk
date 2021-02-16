<?php namespace Konduto\Models;

class Payment extends BaseModel {

    const TYPE_CREDIT = "credit";
    const TYPE_BOLETO = "boleto";
    const TYPE_DEBIT = "debit";
    const TYPE_TRANSFER = "transfer";
    const TYPE_VOUCHER = "voucher";
    const TYPE_PIX = "pix";

    const STATUS_APPROVED = "approved";
    const STATUS_DECLINED = "declined";
    const STATUS_PENDING  = "pending";

    public static $availableTypes = array(self::TYPE_CREDIT, self::TYPE_BOLETO,
        self::TYPE_DEBIT, self::TYPE_TRANSFER, self::TYPE_VOUCHER, self::TYPE_PIX);

    /**
     * @inheritdoc
     */
    protected function fields() {
        return array("type", "status", "amount", "description");
    }

    /**
     * Given an array, instantiates a payment among the possible
     * types of payments. The decision of what Model to use is made
     * by field 'type'
     * @param $array: array containing fields of the Payment
     * @return Payment CreditCard or Boleto object
     */
    public static function build(array $array) {
        if (array_key_exists("type", $array) && in_array($array["type"], self::$availableTypes)) {
            switch ($array["type"]) {
                case Payment::TYPE_CREDIT:
                    return new CreditCard($array);
                    break;

                case Payment::TYPE_BOLETO:
                    return new Boleto($array);
                    break;

                case Payment::TYPE_DEBIT:
                case Payment::TYPE_TRANSFER:
                case Payment::TYPE_VOUCHER:
                case Payment::TYPE_PIX:
                    return new Payment($array);
                    break;

                default:  // Exception
            }
        }
        throw new \InvalidArgumentException("Array must contain a valid 'type' field");
    }

    public function getType() {
        return $this->get("type");
    }

    public function getStatus() {
        return $this->get("status");
    }

    public function setType($value) {
        return $this->set("type", $value);
    }

    public function setStatus($value) {
        return $this->set("status", $value);
    }

    public function setAmount($value) {
        return $this->set("amount", $value);
    }

    public function getAmount() {
        return $this->get("amount");
    }

    public function setDescription($value) {
        return $this->set("description", $value);
    }

    public function getDescription() {
        return $this->get("description");
    }
}
