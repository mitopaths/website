<?php
/**
 * User.
 * 
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model
 */ 
namespace Mitopaths\Model;

/**
 * User.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 Mitopaths
 * @package Mitopaths\Model
 */
class User {
    /** @var int $id Identifier of this user. */
    private $id;
    
    /** @var string $email Email address of this user. */
    private $email;
    
    /** @var string $affiliation Affiliation of this user. */
    private $affiliation;
    
    /** @var string $role Role of this user. */
    private $role;
    
    /** @var int $creation_timestamp UNIX timestamp of creation of this user. */
    private $creation_timestamp;
    
    /** @var int $update_timestamp UNIX timestamp of last update of this user. */
    private $update_timestamp;
    
    
    /**
     * Constructor.
     *
     * @param int|null $id Idenifier of this user
     * @param string $email Email address of this user
     * @param string $affiliation Affiliation of this user
     * @param string $role Role of this user
     * @param int $creation_timestamp UNIX timestamp of creation of this user
     * @param int $update_timestamp UNIX timestamp of last update of this user
     */
    public function __construct($id, string $email, string $affiliation, string $role, int $creation_timestamp = null, int $update_timestamp = null) {
        $this->id = $id;
        $this->email = $email;
        $this->affiliation = $affiliation;
        $this->role = $role;
        $this->setCreationTimestamp($creation_timestamp);
        $this->setUpdateTimestamp($update_timestamp);
    }
    
    
    /**
     * Returns identifier of this user.
     *
     * @return int Identifier of this user
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Returns email address of this user.
     *
     * @return string Email address of this user
     */
    public function getEmail(): string {
        return $this->email;
    }
    
    /**
     * Returns affiliation of this user.
     *
     * @return string Affiliation of this user
     */
    public function getAffiliation(): string {
        return $this->affiliation;
    }
    
    /**
     * Returns role of this user.
     *
     * @return string Role of this user
     */
    public function getRole(): string {
        return $this->role;
    }
    
    /**
     * Returns UNIX creation timestamp of this user.
     *
     * @return int UNIX creation timestamp of this user
     */
    public function getCreationTimestamp(): int {
        return $this->creation_timestamp;
    }
    
    /**
     * Returns UNIX last update timestamp of this user.
     *
     * @return int UNIX last update timestamp of this user
     */
    public function getUpdateTimestamp(): int {
        return $this->update_timestamp;
    }
    
    
    
    /**
     * Sets identifier of this user.
     *
     * @param int $id Identifier of this user
     * @return $this This user
     */
    public function setId(int $id): User {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Sets email address of this user.
     *
     * @param string $email Email address of this user
     * @return $this This user
     */
    public function setEmail(string $email): User {
        $this->email = $email;
        return $this;
    }
    
    /**
     * Sets afiliation of this user.
     *
     * @param string $affiliation Affiliation of this user
     * @return $this This user
     */
    public function setAffiliation(string $affiliation): User {
        $this->affiliation = $affiliation;
        return $this;
    }
    
    /**
     * Sets role of this user.
     *
     * @param string $role Role of this user
     * @return $this This user
     */
    public function setRole(string $role): User {
        $this->role = $role;
        return $this;
    }
    
    /**
     * Sets UNIX creation timestamp of this user.
     *
     * @param int $creation_timestamp UNIX creation timestamp of this user
     * @return $this This user
     */
    public function setCreationTimestamp(int $creation_timestamp = null): User {
        $this->creation_timestamp = !is_null($creation_timestamp) ? $creation_timestamp : time();
        return $this;
    }
    
    /**
     * Sets UNIX last update timestamp of this user.
     *
     * @param int $update_timestamp UNIX last update timestamp of this user
     * @return $this This user
     */
    public function setUpdateTimestamp(int $update_timestamp = null): User {
        $this->update_timestamp = !is_null($update_timestamp) ? $update_timestamp : time();
        return $this;
    }
    
    
    /**
     * Returns true if user has at least given role.
     *
     * @param string $role Role to check
     * @return bool True if and only if this user has given role or a higher role
     */
    public function hasRole(string $role): bool {
        return self::roleToLevel($this->role) <= self::roleToLevel($role);
    }
    
    /**
     * Throws an exception if user does not have given role or a higher role.
     *
     * @param string $role Role to check
     * @return $this This user
     * @throw \Exception If this user does not have given role
     */
    public function requireRole(string $role): User {
        if (!$this->hasRole($role)) {
            throw new \Exception("User needs to have the role \"$role\" to access this resource.");
        }
        
        return $this;
    }
    
    
    /**
     * Converts a role to a numerical level.
     *
     * @param string $role Role to convert
     * @return int Level corresponding to given role
     */
    private static function roleToLevel($role) {
        switch ($role) {
            case 'admin': return 0;
            case 'editor': return 1;
            case 'simple': return 2;
            default: return 100;
        }
    }
}