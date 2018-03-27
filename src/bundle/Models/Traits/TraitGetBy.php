<?php

namespace Afip\Planning\Models\Traits;


use Afip\Planning\Connectivity\PDOConnect;

trait TraitGetBy
{
    /*
  __  __        _    _                 _
 |  \/  |  ___ | |_ | |__    ___    __| | ___
 | |\/| | / _ \| __|| '_ \  / _ \  / _` |/ __|
 | |  | ||  __/| |_ | | | || (_) || (_| |\__ \
 |_|  |_| \___| \__||_| |_| \___/  \__,_||___/

     */

    /**
     * @param string $field
     * @param $fieldValue
     *
     * @return array
     *
     * @throws \LogicException
     * @throws \ReflectionException
     */
    protected static function getBy(string $field, $fieldValue)
    {
        $pdo = PDOConnect::getConnection();

        $reflect = new \ReflectionClass(new self());

        $stm = $pdo->prepare(
            'SELECT * FROM '.lcfirst($reflect->getShortName())." WHERE $field = :fieldValue"
        );

        $stm->bindParam(':fieldValue', $fieldValue);

        $stm->execute();

        $stack = [];

        while ($fetched = $stm->fetch(\PDO::FETCH_ASSOC)) {
            $stack[] = new self($fetched);
        }

        $stm->closeCursor();

        return $stack;
    }

    /**
     * @param int $id
     *
     * @return array
     *
     * @throws \ReflectionException
     * @throws \LogicException
     */
    public static function getById(int $id)
    {
        return self::getBy('id', $id);
    }

    /**
     * @param int|null $limit
     * @param int|null $from
     * @return array
     * @throws \LogicException
     * @throws \ReflectionException
     */
    public static function getAll(int $limit = null, int $from = null)
    {
        $pdo = PDOConnect::getConnection();

        $reflect = new \ReflectionClass(new self());

        $query = 'SELECT * FROM '.lcfirst($reflect->getShortName());

        if ($limit !== null) {
            $query .= ' LIMIT';
            if ($from !== null) {
                $query .= ' '.$from.',';
            }
            $query .= ' '.$limit;
        }

        $stm = $pdo->query($query);

        $stack = [];

        while ($fetched = $stm->fetch(\PDO::FETCH_ASSOC)) {
            $stack[] = new self($fetched);
        }

        $stm->closeCursor();

        return $stack;
    }

    public static function countAll() {
        $pdo = PDOConnect::getConnection();

        $reflect = new \ReflectionClass(new self());

        $query = 'SELECT COUNT(*) AS count FROM '.lcfirst($reflect->getShortName());

        $stm = $pdo->query($query);

        $fetched = $stm->fetch(\PDO::FETCH_ASSOC);

        $stm->closeCursor();

        return $fetched['count'];
    }
}
