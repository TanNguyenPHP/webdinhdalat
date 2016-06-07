<?php
namespace Webdinhdalat\Modeldb\Models;

class Album extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $dir;

    /**
     *
     * @var string
     */
    public $folder;

    /**
     *
     * @var string
     */
    public $is_del;

    /**
     *
     * @var string
     */
    public $datecreate;
    public $desc;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'album';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Album[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Album
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
