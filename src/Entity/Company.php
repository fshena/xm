<?php declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraint as CustomValidator;

class Company
{
    /**
     * @Assert\NotBlank
     * @CustomValidator\CompanySymbol
     */
    protected $companySymbol;

    /**
     * @Assert\NotBlank
     * @Assert\Date
     */
    protected $fromDate;

    /**
     * @Assert\NotBlank
     * @Assert\Date
     */
    protected $toDate;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    protected $email;

    /**
     * @return mixed
     */
    public function getCompanySymbol()
    {
        return $this->companySymbol;
    }

    /**
     * @param mixed $companySymbol
     */
    public function setCompanySymbol($companySymbol): void
    {
        $this->companySymbol = $companySymbol;
    }

    /**
     * @return mixed
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * @param mixed $fromDate
     */
    public function setFromDate($fromDate): void
    {
        $this->fromDate = $fromDate;
    }

    /**
     * @return mixed
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * @param mixed $toDate
     */
    public function setToDate($toDate): void
    {
        $this->toDate = $toDate;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }
}
