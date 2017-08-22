<?php

namespace KCTAPI\Models;

use KCTAPI\Daos\CustomersDao;
use Exception;

class CustomersModel extends BaseModel {

    public $id;
    public $customer_id;
    public $full_name;
    public $address;
    public $mobile;
    public $email;
    public $city;

    public function __construct() {
        parent::__construct();
        $this->id = '';
        $this->full_name = '';
        $this->address = '';
        $this->mobile = '';
        $this->email = '';
        $this->city = '';
        $this->customer_id = '';
    }

    /**
     * @return int
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param int $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param int $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param string $created_by
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
    }

    /**
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * @param string $updated_by
     */
    public function setUpdatedBy($updated_by)
    {
        $this->updated_by = $updated_by;
    }

    /**
     * @return string
     */
    public function getRecordStatus()
    {
        return $this->record_status;
    }

    /**
     * @param string $record_status
     */
    public function setRecordStatus($record_status)
    {
        $this->record_status = $record_status;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param string $customer_id
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param string $full_name
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    public function save() {
        try {
            $customers_dao = new CustomersDao();
            $customers_dao->save($this);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function get() {
        try {
            $customers_dao = new CustomersDao();
            return $customers_dao->get($this);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByMobile() {
        try {
            $customers_dao = new CustomersDao();
            return $customers_dao->getByPhoneNumber($this);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByEmail() {
        try {
            $customers_dao = new CustomersDao();
            return $customers_dao->getByEmail($this);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByNameLike() {
        try {
            $customers_dao = new CustomersDao();
            return $customers_dao->getByNameLike($this);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByCustomerId() {
        try {
            $customers_dao = new CustomersDao();
            return $customers_dao->getByCustomerId($this);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update() {
        try {
            $customers_dao = new CustomersDao();
            $customers_dao->update($this);
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}
