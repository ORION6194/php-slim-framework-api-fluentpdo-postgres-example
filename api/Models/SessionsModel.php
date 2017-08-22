<?php

namespace KCTAPI\Models;

use KCTAPI\Daos\SessionsDao;
use Exception;

class SessionsModel extends BaseModel {

    public $id;
    public $user_id;
    public $last_seen;
    public $start_time;
    public $session_key;

    public function __construct() {
        parent::__construct();
        $this->id = '';
        $this->user_id = '';
        $this->last_seen = 0;
        $this->session_key = '';
        $this->start_time = 0;
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param string $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getLastSeen()
    {
        return $this->last_seen;
    }

    /**
     * @param int $last_seen
     */
    public function setLastSeen($last_seen)
    {
        $this->last_seen = $last_seen;
    }

    /**
     * @return int
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param int $start_time
     */
    public function setStartTime($start_time)
    {
        $this->start_time = $start_time;
    }

    /**
     * @return string
     */
    public function getSessionKey()
    {
        return $this->session_key;
    }

    /**
     * @param string $session_key
     */
    public function setSessionKey($session_key)
    {
        $this->session_key = $session_key;
    }

    public function save() {
        try {
            $sessions_dao = new SessionsDao();
            $sessions_dao->save($this);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function get() {
        try {
            $sessions_dao = new SessionsDao();
            return $sessions_dao->get($this);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update() {
        try {
            $sessions_dao = new SessionsDao();
            $sessions_dao->update($this);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getSession() {
        try {
            $sessions_dao = new SessionsDao();
            return $sessions_dao->getSession($this);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getSessionByUserId() {
        try {
            $sessions_dao = new SessionsDao();
            return $sessions_dao->getSessionByUserId($this);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateUserLastSeeen() {
        $sessionArr = array('user_id' => $this->user_id, 'last_seen' => time());
        try {
            $sessions_dao = new SessionsDao();
            $sessions_dao->updateByUserId($sessionArr);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deactivate($sessionArr) {
        try {
            $sessions_dao = new SessionsDao();
            $sessions_dao->updateByUserId($sessionArr);
        } catch (Exception $e) {
            throw $e;
        }
    }

}
