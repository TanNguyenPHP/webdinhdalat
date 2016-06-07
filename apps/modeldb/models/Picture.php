<?php
namespace Webdinhdalat\Modeldb\Models;
use Phalcon\Mvc\Model;
class Picture extends Model
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
    public $is_del;

    /**
     *
     * @var string
     */
    public $datecreate;

    /**
     *
     * @var integer
     */
    public $id_album;

    /**
     *
     * @var string
     */
    public $position;

    /**
     *
     * @var string
     */
    public $is_show;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'picture';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Picture[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Picture
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
