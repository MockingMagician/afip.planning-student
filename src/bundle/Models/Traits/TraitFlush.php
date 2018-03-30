<?php

namespace Afip\Planning\Models\Traits;

use Afip\Planning\Connectivity\PDOConnect;

trait TraitFlush
{
    public function flush()
    {
        $reflect = new \ReflectionClass($this);

        $name = \lcfirst($reflect->getShortName());

        $insert = null;

        $pdo = PDOConnect::getConnection();

        if (null === $this->getId()) {
            $statement = 'INSERT INTO '.$name.' SET'.PHP_EOL;
            foreach ($reflect->getProperties() as $property) {
                $propertyName = $property->getName();
                if ('id' !== $propertyName) {
                    $statement .= $propertyName.' = :'.$propertyName.','.PHP_EOL;
                }
            }
            $statement = \rtrim($statement, ','.PHP_EOL);
            $statement .= PHP_EOL.'ON DUPLICATE KEY UPDATE'.PHP_EOL;
            $statement .= 'id = LAST_INSERT_ID(id),'.PHP_EOL;
            foreach ($reflect->getProperties() as $property) {
                $propertyName = $property->getName();
                if ('id' !== $propertyName) {
                    $statement .= $propertyName.' = :'.$propertyName.','.PHP_EOL;
                }
            }
            $statement = \rtrim($statement, ','.PHP_EOL);
            $statement .= ';';
            $stmt = $pdo->prepare($statement);
            $insert = true;
        } else {
            $statement = 'UPDATE '.$name.' SET'.PHP_EOL;
            foreach ($reflect->getProperties() as $property) {
                $propertyName = $property->getName();
                if ('id' !== $propertyName) {
                    $statement .= $propertyName.' = :'.$propertyName.','.PHP_EOL;
                }
            }
            $statement = \rtrim($statement, ','.PHP_EOL);
            $statement .= ' WHERE id = :id;';
            $stmt = $pdo->prepare($statement);
            $id = $this->getId();
            $stmt->bindParam(':id', $id);
        }
        foreach ($reflect->getProperties() as $property) {
            $propertyName = $property->getName();
            if ('id' !== $propertyName) {
                $$propertyName = $this->{'get'.\ucfirst($propertyName)}();
                $stmt->bindParam(':'.$propertyName, $$propertyName);
            }
        }
        $stmt->execute();
        if ('00000' !== $stmt->errorCode()) {
            throw new \LogicException(\implode(' | ', $stmt->errorInfo()));
        }
        if (null !== $insert) {
            $this->id = (int)$pdo->lastInsertId();
        }
        $stmt->closeCursor();

        return $this;
    }
}
