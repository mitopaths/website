<?php
/**
 * User data mapper.
 * 
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 */ 
namespace Mitopaths\DataMapper;

/**
 * User data mapper.
 *
 * This class follows the Data Mapper Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 Mitopaths
 * @package Mitopaths\DataMapper
 */
class User {
    use Sql;
    
    
    /**
     * Creates a user.
     *
     * Given user is modified setting her identifier.
     *
     * @param \Mitopaths\Model\User $user User to create
     * @param string $password Password for the new user
     * @return $this This mapper itself
     */
    public function create(\Mitopaths\Model\User &$user, string $password): User {
        $this->query('INSERT INTO user(email, password, affiliation, role) VALUES(:email, :password, :affiliation, :role)', [
            ':email' => $user->getEmail(),
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':affiliation' => $user->getAffiliation(),
            ':role' => $user->getRole()
        ]);
        $user->setId($this->getLastInsertedId());
        
        return $this;
    }
    
    /**
     * Reads a user.
     *
     * @param int $id Identifier of the user to read
     * @return \Mitopaths\Model\User User
     */
    public function read(int $id): \Mitopaths\Model\User {
        $result = $this->query('SELECT * FROM user WHERE id = :id', [':id' => $id]);
        return $this->rowToModel($result->fetch());
    }
    
    /**
     * Updates a user.
     *
     * @param \Mitopaths\Model\User $user User to update
     * @return $this This mapper
     */
    public function update(\Mitopaths\Model\User $user): User {
        $this->query('UPDATE user SET email = :email, affiliation = :affiliation, role = :role WHERE id = :id', [
            ':id' => $user->getId(),
            ':email' => $user->getEmail(),
            ':affiliation' => $user->getAffiliation(),
            ':role' => $user->getRole()
        ]);
        return $this;
    }
    
    /**
     * Deletes a user.
     *
     * @param \Mitopaths\Model\User $user User to delete
     * @return $this This mapper
     */
    public function delete(\Mitopaths\Model\User $user): User {
        $this->query('DELETE FROM user WHERE id = :id', [':id' => $user->getId()]);
        
        return $this;
    }
    
    
    /**
     * Reads every user.
     *
     * @return array Array of users
     */
    public function readAll(): array {
        $result = $this->query('SELECT * FROM user');
        
        return $this->rowsToModels($result);
    }
    
    
    /**
     * Sets a password for given user.
     *
     * @param \Mitopaths\Model\User $user User
     * @param string $password New password
     * @return $this this mapper
     */
    public function setPassword(\Mitopaths\Model\User $user, string $password): User {
        $this->query('UPDATE user SET password = :password WHERE id = :id', [
            ':id' => $user->getId(),
            ':password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
        
        return $this;
    }
    
    
    /**
     * Returns authenticated user.
     *
     * @param string $email Email address of the user
     * @param string $password Password of the user
     * @throw \Exception If email or password are wrong
     */
    public function authenticate(string $email, string $password) {
        $result = $this->query('SELECT * FROM user WHERE email = :email', [
            ':email' => $email
        ]);
        $row = $result->fetch();
        
        if (!password_verify($password, $row['password'])) {
            throw new \Exception("Wrong password.");
        }
        
        return $this->rowToModel($row);
    }
    
    
    /**
     * Converts a raw record into a user.
     *
     * @param array $row Record to convert
     * @return \Mitopaths\Model\User User
     */
    protected function rowToModel($row) {
        return new \Mitopaths\Model\User(
            $row['id'],
            $row['email'],
            $row['affiliation'],
            $row['role'],
            strtotime($row['created_at']),
            strtotime($row['updated_at'])
        );
    }
}