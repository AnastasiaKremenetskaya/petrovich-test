<?php

namespace App\Gateways;

use App\Exceptions\Gateway\RecordNotFoundException;
use App\Exceptions\InternalServerException;
use App\Models\Url;
use Database\DbConnection;
use Exception;
use PDO;
use PDOException;

class UrlGateway
{
    /**
     * @var PDO
     */
    private $db;

    /**
     * @var string
     */
    private $tableName = 'urls';

    /**
     * @var string[]
     */
    private $fillable = [
        'url',
        'short_url',
    ];

    public function __construct()
    {
        $this->db = (new DbConnection())->get();
    }

    /**
     * Get model by id
     *
     * @param int $id
     * @return Url
     * @throws InternalServerException
     * @throws RecordNotFoundException
     */
    public function getById(int $id): Url
    {
        $statement = "SELECT * FROM $this->tableName WHERE `id` = :id";

        try {
            $statement = $this->db->prepare($statement);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $urlData = $statement->fetchAll()[0];
            if (is_null($urlData)) {
                throw new RecordNotFoundException(['id' => $id]);
            }
            return new Url($urlData);
        } catch (PDOException $e) {
            throw new InternalServerException();
        }
    }

    /**
     * Get model by url
     *
     * @param string $url
     * @return Url
     * @throws InternalServerException
     * @throws RecordNotFoundException
     */
    public function getByUrl(string $url): Url
    {
        $statement = "SELECT * FROM $this->tableName WHERE `url` = :url";

        try {
            $statement = $this->db->prepare($statement);
            $statement->bindValue(':url', $url);
            $statement->execute();
            $urlData = $statement->fetchAll()[0];
            if (is_null($urlData)) {
                throw new RecordNotFoundException(['url' => $url]);
            }
            return new Url($urlData);
        } catch (PDOException $e) {
            throw new InternalServerException();
        }
    }

    /**
     * Create model with the given attributes
     *
     * @param array $data
     * @return Url
     * @throws InternalServerException
     */
    public function create(array $data): Url
    {
        $properties = '`' . implode("`,`", $this->fillable) . '`';
        $values = ':' . implode(", :", $this->fillable);

        $statement = "INSERT INTO $this->tableName ($properties) VALUES ($values)";

        try {
            $statement = $this->db->prepare($statement);
            foreach ($this->fillable as $fillableProperty) {
                $statement->bindValue(":$fillableProperty", $data[$fillableProperty] ?? null);
            }
            $statement->execute();
            $id = $this->db->lastInsertId();

            return $this->getById($id);
        } catch (Exception $e) {
            throw new InternalServerException();
        }
    }

    /**
     * Update model with the given attributes
     *
     * @param int $id
     * @param array $data
     * @return Url
     * @throws InternalServerException|RecordNotFoundException
     */
    public function update(int $id, array $data): Url
    {
        $statement = "UPDATE $this->tableName SET ";

        $lastFillableKey = count(($this->fillable)) - 1;
        foreach ($this->fillable as $key => $fillableProperty) {
            $statement .= "`$fillableProperty` = :$fillableProperty";
            if ($key != $lastFillableKey) {
                $statement .= ",";
            }
        }

        $statement .= " WHERE `id` = :id";

        try {
            $statement = $this->db->prepare($statement);

            $statement->bindValue(":id", $id);
            foreach ($this->fillable as $fillableProperty) {
                $statement->bindValue(":$fillableProperty", $data[$fillableProperty] ?? null);
            }
            $statement->execute();

            return $this->getById($id);
        } catch (PDOException $e) {
            throw new InternalServerException();
        }
    }

    /**
     * Get all shortens
     *
     * @return Url[]
     * @throws InternalServerException
     */
    public function all(): array
    {
        $statement = "SELECT * FROM $this->tableName";

        try {
            $statement = $this->db->query($statement);
            $urlData = $statement->fetchAll();

            return array_map(function ($value) {
                return new Url($value);
            }, $urlData);

        } catch (PDOException $e) {
            throw new InternalServerException();
        }
    }
}
