<?php
namespace Webdinhdalat\Modeldb\Models;
use Phalcon\Mvc\Model;

class Users extends Model
{

    /**
     *
     * @var string
     */
    public $id;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $datecreate;

    /**
     *
     * @var string
     */
    public $is_active;

    /**
     *
     * @var string
     */
    public $is_del;

    /**
     *
     * @var string
     */
    public $room;

    /**
     *
     * @var string
     */
    public $desc;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
