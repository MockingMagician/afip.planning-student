<?php

namespace Afip\Planning\Models\Traits;

use Afip\Planning\Connectivity\PDOConnect;

trait TraitDelete
{
    public function delete(): self
    {
        $pdo = PDOConnect::getConnection();

        $reflect = new \ReflectionClass($this);

        $name = \lcfirst($reflect->getShortName());

        if (null !== $this->getId()) {
            $stmt = $pdo->prepare('DELETE FROM '.$name.' WHERE id = :id;');
            $id = $this->getId();
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            if ('00000' !== $stmt->errorCode()) {
                throw new \LogicException(\implode(' | ', $stmt->errorInfo()));
            }
        }

        $clean = new self();

        foreach ($reflect->getProperties() as $property) {
            $propertyName = $property->getName();
            $this->{$propertyName} = $clean->{$propertyName};
        }

        return $this;
    }
}
