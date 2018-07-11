<?php
namespace Wambo\Cms\Service;

use Ramsey\Uuid\UuidFactoryInterface;
use Ramsey\Uuid\UuidInterface;
use Wambo\Cms\Domain\Page;
use Wambo\Cms\Exception\PageNotFoundException;
use Wambo\Core\Service\AbstractRepository;
use Wambo\Core\Service\Database;

class PageRepository extends AbstractRepository
{
    const TABLE = 'pages';

    private $uuidFactory;

    public function __construct(Database $database, UuidFactoryInterface $uuidFactory)
    {
        $this->uuidFactory = $uuidFactory;
        parent::__construct($database);
    }

    public function getById(UuidInterface $uuid)
    {
        $rawData = $this->getRawDataById($uuid);

        if ($rawData === null) {
            throw new PageNotFoundException();
        }

        $uuid = $this->uuidFactory->fromBytes($rawData['uuid']);
        $title = $rawData['title'];
        $content = $rawData['content'];

        return new Page($uuid, $title, $content);
    }
}
