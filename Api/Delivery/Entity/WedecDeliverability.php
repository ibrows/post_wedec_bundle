<?php


namespace Ibrows\PostWedecBundle\Api\Delivery\Entity;


use JMS\Serializer\Annotation as Serializer;

class WedecDeliverability
{
    /**
     * Economy
     */
    const PRODUCT_CODE_ECO = 'ECO';
    /**
     * PostPac Priority
     */
    const PRODUCT_CODE_PRI = 'PRI';
    /**
     * ??
     */
    const PRODUCT_CODE_DIR = 'DIR';
    /**
     * Swiss-Express “Moon” (SEM) and SameDay afternoon and SameDay evening
     */
    const PRODUCT_CODE_SEM = 'SEM';
    /**
     * Evening Delivery
     */
    const PRODUCT_CODE_AZS = 'AZS';

    /**
     * Saturday Delivery
     */
    const PRODUCT_CODE_SA = 'SA';

    /**
     * @var \DateTime
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Serializer\SerializedName("incomingDate")
     */
    private $incomingDate;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("productCode")
     */
    private $productCode;

    /**
     * @return \DateTime
     */
    public function getIncomingDate()
    {
        return $this->incomingDate;
    }

    /**
     * @param \DateTime $incomingDate
     */
    public function setIncomingDate(\DateTime $incomingDate)
    {
        $this->incomingDate = $incomingDate;
    }

    /**
     * @return string
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * @param string $productCode
     */
    public function setProductCode(string $productCode)
    {
        $this->productCode = $productCode;
    }
}