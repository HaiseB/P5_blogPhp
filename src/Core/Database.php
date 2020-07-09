<?php
/**
 * Database Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
namespace App\Core;

/**
 * Database Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
class Database
{

    private $_pdo;

    /**
     * Constructor of the database object
     */
    public function __construct()
    {
        $dns = 'mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'] . ';charset=UTF8';

        try {
            $this->_pdo = new \PDO(
                $dns, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
                ]
            );
        } catch (\PDOException $e) {
            echo 'Connexion failed : ' . $e->getMessage();
        }
    }

    /**
     * Undocumented function
     *
     * @param string $query sql query
     * @param array $submit param to bind
     *
     * @return array
     */
    public function fetchAll(string $query, array $submit=[]) :array
    {
        $statement = $this->_pdo->prepare($query);
        $statement->execute($submit);

        return $statement->fetchAll();
    }

    /**
     * Undocumented function
     *
     * @param string $query sql query
     * @param array $submit param to bind
     *
     * @return object|null
     */
    public function fetch(string $query, array $submit=[]) :?object
    {
        $statement = $this->_pdo->prepare($query);
        $statement->execute($submit);
        $result = $statement->fetch();

        $result = (is_bool($result)) ? null : $result ;

        return $result;
    }

    /**
     * Undocumented function
     *
     * @param string $query sql query
     * @param array $submit param to bind
     *
     * @return void
     */
    public function create(string $query, array $submit=[]) :void
    {
        $statement = $this->_pdo->prepare($query);
        $statement->execute($submit);
    }

    /**
     * Undocumented function
     *
     * @param string $query sql query
     * @param array $submit param to bind
     *
     * @return void
     */
    public function update(string $query, array $submit=[]) :void
    {
        $statement = $this->_pdo->prepare($query);
        $statement->execute($submit);
    }

    /**
     * Undocumented function
     *
     * @param string $query sql query
     * @param array $submit param to bind
     *
     * @return void
     */
    public function delete(string $query, array $submit=[]) :void
    {
        $statement = $this->_pdo->prepare($query);
        $statement->execute($submit);
    }

    /**
     * Undocumented function
     *
     * @param string $table table who is asked
     *
     * @return void
     */
    public function getLastId(string $table)
    {
        $query = "SELECT MAX(id) as maxId FROM " . $table;
        $statement = $this->_pdo->prepare($query);
        $statement->execute();
        $lastID = $statement->fetch();

        return $lastID->maxId;
    }

}