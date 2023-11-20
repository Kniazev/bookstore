<?php

declare(strict_types=1);

namespace App\Repository;


trait RepositoryModifyTrait
{
    /**
     * @param object $object
     * @return void
     */
    public function save(object $object): void
    {
        $this->_em->persist($object);
    }

    /**
     * @param object $object
     * @return void
     */
    public function remove(object $object): void
    {
        $this->_em->remove($object);
    }

    /**
     * @param object $object
     * @return void
     */
    public function saveAndCommit(object $object): void
    {
        $this->save($object);
        $this->commit();
    }

    /**
     * @param object $object
     * @return void
     */
    public function removeAndCommit(object $object): void
    {
        $this->remove($object);
        $this->commit();
    }

    /**
     * @return void
     */
    public function commit(): void
    {
        $this->_em->flush();
    }
}
